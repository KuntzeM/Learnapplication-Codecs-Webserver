<?php

namespace App\Http\Controllers\Backend;

use App\CodecConfigs;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function __construct()
    {
        #$this->middleware('auth');
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
}
