<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Frontend;

use App\ConfigData;
use App\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Libary\Placeholder;

class AboutController extends Controller
{
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    public function index()
    {
        try {
            $html = Configuration::where('name', 'impressum')->firstOrFail();
            $html->value = Placeholder::changePlaceholder($html->value);
        } catch (ModelNotFoundException $e) {
            $html = '';
        }
        return view('frontend.about', ['url' => $this->url, 'html' => $html->value]);
    }
}
