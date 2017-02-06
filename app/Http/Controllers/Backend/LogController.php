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
        $rest = new callREST();
        return View::make('backend.log.index', ['url' => $this->url, 'token' => $rest->getToken()]);
    }

    public function reload_index()
    {
        return \App\Libary\REST\Log::getLog();
    }

    public function getDebugLevel()
    {
        $rest = new callREST();

        return $rest->getDebugLevel();
    }

    public function setDebugLevel(Request $request)
    {
        $rest = new callREST();
        $rest->setDebugLevel($request->debugLevel);
    }

    public function deleteLog(Request $request, $id)
    {
        try {
            \App\Libary\REST\Log::deleteLog();
            return response()->json(array('message' => 'success'), 200);
        } catch (\Exception $e) {
            return response()->json(array('message' => 'error'), 404);
        }
    }

}
