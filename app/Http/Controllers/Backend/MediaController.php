<?php

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Libary\callREST;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

class MediaController extends Controller
{

    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;
    }

    public function get_index()
    {

        $video_media = Media::where('media_type', 'video')->get();
        $image_media = Media::where('media_type', 'image')->get();

        return View::make('backend.media.index', ['url'=> $this->url, 'video_media' => $video_media, 'image_media' => $image_media]);
    }

    public function get_media($id)
    {
        try {
            $media = Media::findOrFail($id);

            return View::make('backend.media.media', ['url' => $this->url, 'media' => $media, 'new' => false, 'title' => 'Update Media']);
        } catch (ModelNotFoundException $e) {
            return redirect('/admin/media')->withErrors('media id ' . $id . ' don\'t exist!', 'error');
        }
    }

    public function upload_media()
    {
        $media = new Media();
        $config = ConfigData::getInstance();

        $rest = new callREST();
        return View::make('backend.media.media', ['media' => $media, 'new' => true, 'title' => 'New Media', 'token' => $rest->getToken(), 'url' => $config->media_server]);
    }

    public function update_media(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $media->name = $request->name;
        $media->save();

        return redirect('/admin/media')->withErrors('media with id ' . $media->media_id . ' is updated', 'success');
    }

    public function delete_media($id)
    {
        $media = Media::findOrFail($id);

        $rest = new callREST();
        $response = $rest->deleteMedia($id);

        if ($response->getStatusCode() == 200 AND $response->getReasonPhrase() == 'OK') {
            foreach ($media->media_codec_configs as $mcc) {
                $mcc->delete();
            }
            $media->delete();

            return redirect('/admin/media')->withErrors($media->name . ' is deleted!', 'success');

        } else {
            return redirect('/admin/media')->withErrors($media->name . ' cannot delete!', 'error');
        }

    }
}
