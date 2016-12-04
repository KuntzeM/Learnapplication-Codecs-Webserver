<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Media;

class VideoController extends Controller
{
    private function getVideos(){
        return Media::where('media_type', 'video')->get();
    }


    public function index()
    {
        $files = $this->getVideos();
        $num_files = count($files);
        $rows = ceil($num_files/4);

        return view('frontend.video', ['files'=> $files, 'num_files'=>$num_files, 'rows'=>$rows]);
    }
}
