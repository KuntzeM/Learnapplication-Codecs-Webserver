<?php

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Libary\callREST;
use Illuminate\Http\Request;
use View;
use Yajra\Datatables\Datatables;


class LogController extends Controller
{
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;

    }

    public function get_index()
    {
        return View::make('backend.log.index', ['url' => $this->url]);
    }

    public function reload_index()
    {
        try {
            return \App\Libary\REST\Log::getLog();
        } catch (\Exception $e) {
            return array();
        }

    }

    public function deleteLog(Request $request)
    {
        try {
            \App\Libary\REST\Log::deleteLog();
            return response()->json(array('message' => 'success'), 200);
        } catch (\Exception $e) {
            return response()->json(array('message' => 'error'), 404);
        }
    }

}
