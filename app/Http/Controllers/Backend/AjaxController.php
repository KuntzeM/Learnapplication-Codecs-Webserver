<?php

namespace App\Http\Controllers\Backend;

use App\CodecConfigs;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Job;
use App\Libary\callREST;
use App\Media;
use App\MediaCodecConfig;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AjaxController extends Controller
{
    public function __construct()
    {
        #$this->middleware('auth');
    }

    public function getMediaConfigs(Request $request){
        try {
            $output = DB::table('media_codec_configs')
                ->leftJoin('codec_configs', 'codec_configs.codec_config_id', '=', 'media_codec_configs.codec_config_id')
                ->leftJoin('codecs', 'codecs.codec_id', '=', 'codec_configs.codec_id')
                ->select('media_codec_configs.media_codec_config_id', 'codec_configs.name as codec_config_name', 'codecs.name as codec_name')
                ->where('media_codec_configs.media_id', '=', $request->media_id)->get();

            return response()->json(array('media' => $output), 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(array('message' => 'error', 404));
        }

    }

    public function activateCodecConfig(Request $request)
    {

        try {
            $codec_config = CodecConfigs::findOrFail($request->codec_config_id);
            if ($codec_config->active) {
                $codec_config->active = false;
                $active_msg = 'deactivated';
            } else {
                $codec_config->active = true;
                $active_msg = 'activated';
            }
            $codec_config->save();
            $status = 200;
        } catch (ModelNotFoundException $e) {
            $status = 404;
        }


        return response()->json(array('name' => $codec_config->name, 'active_msg' => $active_msg), $status);
    }

    public function processTranscoding(Request $request)
    {
        if ($request->codec_config_id != null) {

            try {
                $package = \App\Libary\REST\Job::createJobPackage($request->media_id, $request->codec_config_id);
                \App\Libary\REST\Job::postJob($package);
                //$this->startTranscoding($request);
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
                        $package = \App\Libary\REST\Job::createJobPackage($media->media_id, $codec_config->codec_config_id);
                        array_push($packages, $package);
                    }

                }
                \App\Libary\REST\Job::postJob($packages);
                //$this->startTranscoding($request);
                return response()->json(array('message' => 'success'), 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(array('message' => $e->getMessage() . 'Job konnte nicht angelegt werden! media_id: ' . $request->media_id . ' codec_config_id: ' . $request->codec_config_id), 404);
            }
        }
    }


    public function startTranscoding(Request $request)
    {

        $rest = new callREST();
        $status = $rest->postStartTranscoding();

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
                throw new ModelNotFoundException('wrong documentation type!');
            }

            $mediaConfig = MediaCodecConfig::findOrFail($request->media_codec_config_id);


            return response()->json(array('message' => 'success',
                'codec' => $mediaConfig->getCodecConfig()->codec->name,
                'config' => $mediaConfig->getCodecConfig()->name,
                'size' => $mediaConfig->size,
                'documentation' => $mediaConfig->getCodecConfig()->codec->{'documentation_' . $request->type}));
        } catch (ModelNotFoundException $e) {
            return response()->sendHeaders(404);//json(array('message' => $e->getMessage()));
        }

    }
}
