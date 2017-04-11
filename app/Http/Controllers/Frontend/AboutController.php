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

/**
 * Class AboutController
 * @package App\Http\Controllers\Frontend
 */
class AboutController extends Controller
{
    /**
     * AboutController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    /**
     * zeig Impressum an
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
