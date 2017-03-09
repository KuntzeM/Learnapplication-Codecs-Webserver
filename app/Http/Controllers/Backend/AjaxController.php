<?php

namespace App\Http\Controllers\Backend;

use App\CodecConfigs;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Job;
use App\Libary\Placeholder;
use App\Libary\REST\Log;
use App\Media;
use App\MediaCodecConfig;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AjaxController extends Controller
{

    public function getMediaConfigs(Request $request){
        try {
            $output = DB::table('media_codec_configs')
                ->leftJoin('codec_configs', 'codec_configs.codec_config_id', '=', 'media_codec_configs.codec_config_id')
                ->leftJoin('codecs', 'codecs.codec_id', '=', 'codec_configs.codec_id')
                ->select('media_codec_configs.media_codec_config_id', 'codecs.media_type as media_type', 'media_codec_configs.file_path as file ', 'codec_configs.name as codec_config_name', 'codecs.name as codec_name')
                ->orderBy('codec_configs.name', 'DESC')
                ->where('media_codec_configs.media_id', '=', $request->media_id)->get();

            return response()->json(array('media' => $output), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(array('message' => 'error', 404));
        }

    }

    public function getStatus(Request $request)
    {
        $request = Log::getStatus();

        return $request;
    }

    public function processTranscoding(Request $request)
    {
        if ($request->codec_config_id != null) {

            try {
                $package = \App\Libary\REST\Jobs::createJobPackage($request->media_id, $request->codec_config_id);
                \App\Libary\REST\Jobs::postJob($package);

                return response()->json(array('message' => 'success'), 200);
            } catch (\Exception $e) {
                return response()->json(array('message' => $e->getMessage() . 'Job konnte nicht angelegt werden! media_id: ' . $request->media_id . ' codec_config_id: ' . $request->codec_config_id), 404);
            }


        } else {
            try{
                $media = Media::findOrFail($request->media_id);
                $codec_configs = CodecConfigs::all();
                $packages = array();
                foreach ($codec_configs as $codec_config){

                    if($codec_config->codec->media_type == $media->media_type){
                        $package = \App\Libary\REST\Jobs::createJobPackage($media->media_id, $codec_config->codec_config_id);
                        array_push($packages, $package);
                    }

                }
                \App\Libary\REST\Jobs::postJob($packages);

                return response()->json(array('message' => 'success'), 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(array('message' => $e->getMessage() . 'Job konnte nicht angelegt werden! media_id: ' . $request->media_id . ' codec_config_id: ' . $request->codec_config_id), 404);
            }
        }
    }


    public function startTranscoding(Request $request)
    {

        try {
            $response = \App\Libary\REST\Jobs::postStartTranscoding();
            return response()->json(array('message' => $response->getContents()), 200);
        } catch (\Exception $e) {
            return response()->json(array('message' => $e->getMessage()), 404);
        }

    }

    public function getTranscodingProcesses(Request $request)
    {

        $jobs = Job::all();
        $output = array();
        foreach ($jobs as $job) {
            $tmp = array('id' => $job->id, 'name' => $job->getMedia()->name, 'media_type' => $job->getMedia()->media_type, 'codec' => $job->getCodecConfiguration()->codec->name,
                'codec_config' => $job->getCodecConfiguration()->name, 'process' => $job->process);
            $output[] = $tmp;
        }

        return response()->json(array('message' => 'success', 'jobs' => $output), 200);

    }

    public function getCodecDocumentation(Request $request)
    {

        try {
            if (!in_array($request->type, ['compare', 'full'])) {
                throw new ModelNotFoundException('Falscher Dokument-Type: ' . $request->type);
            }

            $split_name = explode('/', $request->name);
            if (count($split_name) != 2) {
                throw new ModelNotFoundException('Argument Name ist falsch: ' . $request->name);
            }

            $mediaConfig = MediaCodecConfig::leftJoin('codec_configs', function ($join) {
                $join->on('media_codec_configs.codec_config_id', '=', 'codec_configs.codec_config_id');
            })->leftJoin('codecs', function ($join) {
                $join->on('codecs.codec_id', '=', 'codec_configs.codec_id');
            })->where('codecs.media_type', $split_name[0])
                ->where('media_codec_configs.file_path', $split_name[1])->first();


            return response()->json(array('message' => 'success',
                'codec' => $mediaConfig->getCodecConfig()->codec->name,
                'config' => $mediaConfig->getCodecConfig()->name,
                'size' => $mediaConfig->size,
                'psnr' => $mediaConfig->psnr,
                'ssim' => $mediaConfig->ssim,
                'documentation' => Placeholder::changePlaceholder($mediaConfig->getCodecConfig()->codec->{'documentation_' . $request->type})));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'DOkumentation konnte nicht geladen werden: ' . $e->getMessage(),
            ], 404);//json(array('message' => $e->getMessage()));
        }

    }

    public function getFileSize(Request $request)
    {

        try {
            $split_name = explode('/', $request->name);
            if (count($split_name) != 2) {
                throw new ModelNotFoundException('Argument Name ist falsch: ' . $request->name);
            }

            $mediaConfig = MediaCodecConfig::where('file_path', $split_name[1])->first();

            return response()->json(array('message' => 'success',
                'size' => $mediaConfig->size));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Dateigröße konnte nicht geladen werden: ' . $e->getMessage(),
            ], 404);//json(array('message' => $e->getMessage()));
        }

    }
}
