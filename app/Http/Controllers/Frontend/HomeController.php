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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Libary\Placeholder;

/**
 * Class HomeController
 * @package App\Http\Controllers\Frontend
 */
class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;
    }

    /**
     * zeigt Startseite an
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
