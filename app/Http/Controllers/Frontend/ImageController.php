<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App\Http\Controllers\Frontend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Media;
use DB;

/**
 * Class ImageController
 * @package App\Http\Controllers\Frontend
 */
class ImageController extends Controller
{
    /**
     * ImageController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    /**
     * zeigt Seite zum vergleichen der Bildkodierungsverfahren an
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $files = $this->getImages();
        $num_files = count($files);
        $rows = ceil($num_files/4);

        return view('frontend.image', ['files'=> $files, 'num_files'=>$num_files, 'rows'=>$rows, 'url'=>$this->url]);
    }

    /**
     * gibt Liste mit allen verfügbaren Bildern wieder
     * @return mixed
     */
    private function getImages()
    {
        return Media::where('media_type', 'image')->get();
    }
}
