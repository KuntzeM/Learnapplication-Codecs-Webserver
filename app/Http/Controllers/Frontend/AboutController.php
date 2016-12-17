<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\ConfigData;
class AboutController extends Controller
{
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    public function index()
    {
        return view('frontend.about', ['url'=>$this->url]);
    }
}
