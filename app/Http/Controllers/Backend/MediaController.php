<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

/**
 * Class MediaController
 * @package App\Http\Controllers\Backend
 */
class MediaController extends Controller
{
    /**
     * MediaController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;
    }

    /**
     * forder Übersicht über Bilder und Videos an
     * @return mixed
     */
    public function get_index()
    {

        $video_media = Media::where('media_type', 'video')->get();
        $image_media = Media::where('media_type', 'image')->get();

        return View::make('backend.media.index', ['url'=> $this->url, 'video_media' => $video_media, 'image_media' => $image_media]);
    }

    /**
     * Einzelansicht Bild/Video bzw neue Datei hochladen
     * @param $id int ID Media-Datei
     * @return $this
     */
    public function get_media($id)
    {
        try {
            $media = Media::findOrFail($id);

            return View::make('backend.media.media', ['url' => $this->url, 'media' => $media, 'new' => false, 'title' => 'Update Media']);
        } catch (ModelNotFoundException $e) {
            return redirect('/admin/media')->withErrors('media id ' . $id . ' don\'t exist!', 'error');
        }
    }

    /**
     * neues Video bzw Bild hochladen
     * @return mixed
     */
    public function upload_media()
    {
        $media = new Media();
        $config = ConfigData::getInstance();

        return View::make('backend.media.media', ['media' => $media, 'new' => true, 'title' => 'New Media', 'url' => $config->media_server]);
    }

    /**
     * speichert Media-Datei in Datenbank
     * @param Request $request
     * @param $id int ID Mediadatei
     * @return $this
     */
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

}
