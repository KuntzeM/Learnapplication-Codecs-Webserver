<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Media;
use App\ConfigData;

/**
 * Class VideoController
 * @package App\Http\Controllers\Frontend
 */
class VideoController extends Controller
{
    /**
     * VideoController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;

    }

    /**
     * zeigt Seite zum vergleichen der Bildkodierungsverfahren an
     * @return mixed
     */
    public function index()
    {
        $files = $this->getVideos();
        $num_files = count($files);
        $rows = ceil($num_files/4);

        return view('frontend.video', ['url' => $this->url, 'files' => $files, 'num_files' => $num_files, 'rows' => $rows]);
    }

    /**
     * gibt Liste mit verfügbaren Videokodierungsverfahren zurück
     * @return mixed
     */
    private function getVideos(){
        return Media::where('media_type', 'video')->get();
    }



}
