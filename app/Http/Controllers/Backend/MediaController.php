<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use App\Media;

class MediaController extends Controller
{

    public function __construct()
    {
        #$this->middleware('auth');
    }

    public function get_index()
    {
        $video_media = Media::where('media_type', 'video')->get();
        $image_media = Media::where('media_type', 'image')->get();
        return View::make('backend.media.index', ['video_media' => $video_media, 'image_media' => $image_media]);
    }

    public function get_media($id)
    {
        try {
            $media = Media::findOrFail($id);
            $new = false;
        } catch (ModelNotFoundException $e) {
            $media = new Media();
            $title = 'New Codec';
            $new = true;
        }
        return View::make('backend.media.media', ['media' => $media, 'new'=>$new, 'title' => 'Update Media']);
    }

    public function upload_media()
    {
        $media = new Media();
        return View::make('backend.media.media', ['media' => $media, 'new'=>true, 'title' => 'New Media']);
    }
}
