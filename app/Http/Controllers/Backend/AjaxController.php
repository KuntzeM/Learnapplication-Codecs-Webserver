<?php

namespace App\Http\Controllers\Backend;

use App\CodecConfigs;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Job;
use App\Libary\callREST;
use App\Media;
use App\MediaCodecConfig;
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

            return response()->json(array('media' => json_encode($output)), 200);
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

        try {
            $codec_config = CodecConfigs::findOrFail($request->codec_config_id);
            $media = Media::findOrFail($request->media_id);

            $job = new Job();
            $job->media_id = $request->media_id;
            $job->codec_config_id = $request->codec_config_id;

            $job->save();

            $status = 200;
        } catch (ModelNotFoundException $e) {
            $status = 404;
        }

        $rest = new callREST();
        $rest->postStartTranscoding();

        return response()->json(array('message' => 'success'), $status);
    }

    public function startTranscoding(Request $request)
    {

        $rest = new callREST();
        $status = $rest->postStartTranscoding();

        //return response()->json(array('message' => 'success'), $status);
    }
}
