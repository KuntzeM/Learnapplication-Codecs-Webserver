<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Media;
use App\CodecConfigs;

class ImageController extends Controller
{

    private function getImages(){
        return Media::where('media_type', 'image')->get();
    }


    public function index()
    {
        $files = $this->getImages();
        $num_files = count($files);
        $rows = ceil($num_files/4);
        $media = Media::findOrFail(5);
        #dd($media->media_codec_configs[0]->getMediaCodecInfos());
        return view('frontend.image', ['files'=> $files, 'num_files'=>$num_files, 'rows'=>$rows]);
    }
}
