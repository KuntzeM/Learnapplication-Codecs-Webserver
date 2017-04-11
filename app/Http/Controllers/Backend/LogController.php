<?php

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Libary\callREST;
use Illuminate\Http\Request;
use View;
use Yajra\Datatables\Datatables;

/**
 * Class LogController
 * @package App\Http\Controllers\Backend
 */
class LogController extends Controller
{
    /**
     * LogController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;

    }

    /**
     * fordert viewer für Log-Übersicht an
     * @return mixed
     */
    public function get_index()
    {
        return View::make('backend.log.index', ['url' => $this->url]);
    }

    /**
     * AJAX Aufruf, fordert neue Logs vom Mediaserver an
     * @return array|\Psr\Http\Message\StreamInterface
     */
    public function reload_index()
    {
        try {
            return \App\Libary\REST\Log::getLog();
        } catch (\Exception $e) {
            return array();
        }

    }

    /**
     * sendet dem Mediaserver den Befehl zum löschen des Logs
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
