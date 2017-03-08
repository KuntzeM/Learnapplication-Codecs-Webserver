<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Job;
use App\Libary\REST\FileNodeJS;
use View;


class AdminController extends Controller
{

    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;

        FileNodeJS::poolMetadata();
    }

    public function get_index()
    {

        $jobs = Job::all();
        return View::make('backend.index', array('url'=> $this->url, 'jobs' => $jobs));
    }

    public function get_jobs()
    {
        $response = \App\Libary\REST\Jobs::getJobs();

        return $response;
    }




}
