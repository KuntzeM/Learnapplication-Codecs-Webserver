<?php

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Log;
use View;

class LogController extends Controller
{
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;

    }

    public function get_index()
    {

        $log = Log::all();

        return View::make('backend.log.index', ['url' => $this->url, 'log' => $log]);
    }

}
