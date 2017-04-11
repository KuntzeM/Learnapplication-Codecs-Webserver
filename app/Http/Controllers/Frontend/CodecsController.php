<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App\Http\Controllers\Frontend;

use App\Codecs;
use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Libary\Placeholder;

/**
 * Class CodecsController
 * @package App\Http\Controllers\Frontend
 */
class CodecsController extends Controller
{
    /**
     * CodecsController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

    /**
     * zeigt Informationen über Kodierungsverfahren an
     * @param null $id int ID Kodierungsverfahren
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id = null)
    {
        $content = null;
        $titel = 'Codecs';

        try {
            $codec = Codecs::findorFail($id);
            $content = Placeholder::changePlaceholder($codec->documentation_full);

            $titel = $codec->name;
        } catch (ModelNotFoundException $e) {

        }

        $video_codecs = Codecs::where('media_type', 'video')->get();
        $image_codecs = Codecs::where('media_type', 'image')->get();

        return view('frontend.codecs', ['url' => $this->url, 'video_codecs' => $video_codecs, 'image_codecs' => $image_codecs, 'titel' => $titel, 'content' => $content, 'id' => $id]);
    }
}
