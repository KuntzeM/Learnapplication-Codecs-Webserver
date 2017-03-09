<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Frontend;

use App\ConfigData;
use App\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Libary\Placeholder;

class HomeController extends Controller
{
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    public function index()
    {
        try {
            $html = Configuration::where('name', 'welcome')->firstOrFail();
            $html->value = Placeholder::changePlaceholder($html->value);
        } catch (ModelNotFoundException $e) {
            $html = '';
        }

        return view('frontend.home', ['url' => $this->url, 'html' => $html->value]);
    }
}
