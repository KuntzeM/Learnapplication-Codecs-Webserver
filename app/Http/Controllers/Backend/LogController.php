<?php

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Libary\callREST;
use App\Log;
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
        return Datatables::of(Log::query())->setRowClass(function ($log) {
            switch ($log->level) {
                case 'info':
                    return 'info';
                    break;
                case 'warn':
                    return 'warning';
                    break;
                case 'error':
                    return 'danger';
                    break;
            }

        })->make(true);
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

    public function clearLog(Request $request)
    {
        Log::truncate();
        return response()->json(array('message' => 'success'), 200);
    }

}
