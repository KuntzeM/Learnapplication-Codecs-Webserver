<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Frontend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Media;
use DB;

class ImageController extends Controller
{

    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    public function index()
    {
        $files = $this->getImages();
        $num_files = count($files);
        $rows = ceil($num_files/4);

        return view('frontend.image', ['files'=> $files, 'num_files'=>$num_files, 'rows'=>$rows, 'url'=>$this->url]);
    }

    private function getImages()
    {
        return Media::where('media_type', 'image')->get();
    }
}
