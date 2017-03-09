<?php

namespace App\Http\Controllers\Frontend;

use App\Codecs;
use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Libary\Placeholder;

class CodecsController extends Controller
{
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;


    }

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
