<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use View;


class AdminController extends Controller
{

    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    public function get_index()
    {
        return View::make('backend.index', array('url' => $this->url));
    }

    public function get_jobs()
    {
        $response = \App\Libary\REST\Jobs::getJobs();

        return $response;
    }




}
