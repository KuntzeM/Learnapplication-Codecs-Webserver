<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use View;

/**
 * Class AdminController
 * @package App\Http\Controllers\Backend
 */
class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;
    }

    /**
     * gibt Viewer aus: Kodierungsprozesse
     * @return mixed
     */
    public function get_index()
    {
        return View::make('backend.index', array('url' => $this->url));
    }

    /**
     * fordert Kodierungsprozesse vom Mediaserver an und gibt sie als JSON-Objekt wieder
     * wird per AJAX aufgerufen
     * @return \Psr\Http\Message\StreamInterface
     */
    public function get_jobs()
    {
        $response = \App\Libary\REST\Jobs::getJobs();

        return $response;
    }
}
