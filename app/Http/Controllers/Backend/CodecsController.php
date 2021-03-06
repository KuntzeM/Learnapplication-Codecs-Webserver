<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App\Http\Controllers\Backend;

use App\CodecConfigs;
use App\Codecs;
use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Media;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use View;

/**
 * Class CodecsController
 * @package App\Http\Controllers\Backend
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
     * liefert Viewer für die Übersichtsseite der Kodierungsverfahren
     * @return mixed
     */
    public function get_index()
    {
        $video_codecs = Codecs::where('media_type', 'video')->get();
        $image_codecs = Codecs::where('media_type', 'image')->get();
        return View::make('backend.codecs.index', ['url'=> $this->url, 'video_codecs' => $video_codecs, 'image_codecs' => $image_codecs]);
    }

    /**
     * löscht ein Kodierungsverfahren und alle dazugehörigen Konfigurationen
     * @param $id int ID Kodierungsverfahren
     * @return $this Weiterleitung
     */
    public function delete_codec($id)
    {
        $codec = Codecs::findOrFail($id);
        //Session::flash('message', $codec->name . ' and ' . count($codec->codec_configs) . ' Configurations are deleted!');
        //Session::flash('alert-class', 'success');
        foreach ($codec->codec_configs as $config) {
            $config->delete();
        }
        $codec->delete();

        return redirect('/admin/codecs')->withErrors($codec->name . ' and ' . count($codec->codec_configs) . ' Configurations are deleted!', 'success');
    }

    /**
     * löscht Kodierungskonfiguration
     * @param $id int ID Kodierungskonfiguration
     * @return $this Weiterleitung
     */
    public function delete_codec_config($id)
    {
        try {

            $codecConfig = CodecConfigs::findOrFail($id);


            $codecConfig->delete();

            return redirect('/admin/codecs')->withErrors($codecConfig->name . ' is deleted', 'success');

        } catch (ModelNotFoundException $e) {
            return redirect('/admin/codecs')->withErrors($codecConfig->name . ' not founded', 'error');
        }
    }

    /**
     * Zeigt Einzelansicht Kodierungsverfahren an. Ist ID = null, so wird eine leere Seite zum anlegen eines Verfahrens angezeigt
     * @param null $id int ID Kodierungsverfahren
     * @return mixed
     */
    public function get_codec($id = null)
    {
        try {
            $codec = Codecs::findOrFail($id);
            $title = 'Change Codec';
            $new = false;
        } catch (ModelNotFoundException $e) {
            $codec = new Codecs();
            $title = 'New Codec';
            $new = true;
        }

        return View::make('backend.codecs.codec', ['url' => $this->url, 'codec' => $codec, 'title' => $title, 'new' => $new]);
    }

    /**
     * zeigt Einzelansicht einer Kodierungskonfiguration an. Ist $id = null so wird eine leere Seite zum anlegen einer neuen Konfiguration angezeigt
     * @param null $id int ID Kodierungskonfiguration
     * @param null $codec_id ID Kodierungsverfahren
     * @return mixed
     */
    public function get_codec_config($id = null, $codec_id = null)
    {

        try {
            $codec_config = CodecConfigs::findOrFail($id);
            $title = 'Change Codec Configuration';
            $new = false;
        } catch (ModelNotFoundException $e) {
            $codec_config = new CodecConfigs();
            $title = 'New Codec Configuration';
            $new = true;
            $codec_config->codec = Codecs::findOrFail($codec_id);
        }

        return View::make('backend.codecs.codec_config', ['url' => $this->url, 'codec_config' => $codec_config, 'title' => $title, 'new' => $new]);
    }

    /**
     * ändert Kodierungsverfahren
     * @param Request $request Formulardaten
     * @param $id int ID Kodierungsverfahren
     * @return $this
     */
    public function update_codec(Request $request, $id)
    {
        $codec = Codecs::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:codecs,name,' . $id . ',codec_id',
            'ffmpeg_codec' => 'required',
            'extension' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $codec->name = $request->name;
        $codec->ffmpeg_codec = $request->ffmpeg_codec;
        $codec->extension = $request->extension;
        $codec->convert = boolval($request->convert);
        $codec->save();

        return redirect('/admin/codecs')->withErrors('codec ' . $codec->name . ' is updated', 'success');
    }

    /**
     * legt neues Kodierungsverfahren an
     * @param Request $request Post-Anfrage
     * @return $this
     */
    public function new_codec(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:codecs',
            'ffmpeg_codec' => 'required',
            'media_type' => 'required',
            'extension' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }


        $codec = new Codecs();
        $codec->name = $request->name;
        $codec->ffmpeg_codec = $request->ffmpeg_codec;
        $codec->media_type = $request->media_type;
        $codec->extension = $request->extension;
        $codec->convert = $request->convert;
        //$codec->active = true;
        $codec->save();

        return redirect('/admin/codecs')->withInput()->withErrors('codec ' . $codec->name . ' is created', 'success');
    }

    /**
     * ändert Kodierungskonfiguration
     * @param Request $request POST-Anfrage
     * @param $id ID Kodierungskonfiguration
     * @return $this
     */
    public function update_codec_config(Request $request, $id)
    {

        $codec_config = CodecConfigs::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'codec_id' => 'required',
            'ffmpeg_parameters' => '',
            'ffmpeg_bitrate' => 'required | numeric'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $codec_config->name = $request->name;
        $codec_config->ffmpeg_parameters = $request->ffmpeg_parameters;
        $codec_config->ffmpeg_bitrate = $request->ffmpeg_bitrate;
        $codec_config->save();
        $packages = array();
        if ($request->start_transcoding) {
            $media = Media::where('media_type', $codec_config->codec->media_type);

            foreach ($media->cursor() as $item) {

                $package = \App\Libary\REST\Jobs::createJobPackage($item->media_id, $codec_config->codec_config_id);
                array_push($packages, $package);
            };

            try {

                \App\Libary\REST\Jobs::postJob($packages);
                $response = \App\Libary\REST\Jobs::postStartTranscoding();
            } catch (\Exception $e) {
                return redirect('/admin/codecs')->withErrors('Jobs konnten nicht angelegt werden!', 'warning');
            }

        }

        return redirect('/admin/codecs')->withErrors('codec ' . $codec_config->codec->name . ' configuration ' . $codec_config->name . ' is updated', 'success');
    }

    /**
     * neue Kodierungskonfiguration anlegen
     * @param Request $request POST-Anfrage
     * @return $this
     */
    public function new_codec_config(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'codec_id' => 'required',
            'ffmpeg_parameters' => '',
            'ffmpeg_bitrate' => 'required | numeric'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }


        $codec_config = new CodecConfigs();
        $codec_config->name = $request->name;
        $codec_config->ffmpeg_bitrate = $request->ffmpeg_bitrate;
        $codec_config->ffmpeg_parameters = $request->ffmpeg_parameters;
        $codec_config->codec_id = $request->codec_id;
        $codec_config->active = false;
        $codec_config->save();
        $packages = array();
        if ($request->start_transcoding) {
            $media = Media::where('media_type', $codec_config->codec->media_type);
            foreach ($media->cursor() as $item) {
                $package = \App\Libary\REST\Jobs::createJobPackage($item->media_id, $codec_config->codec_config_id);
                array_push($packages, $package);
            };
            try {
                \App\Libary\REST\Jobs::postJob($packages);
                $response = \App\Libary\REST\Jobs::postStartTranscoding();
            } catch (\Exception $e) {
                return redirect('/admin/codecs')->withErrors('Jobs konnten nicht angelegt werden!', 'warning');
            }



        }

        return redirect('/admin/codecs')->withInput()->withErrors('codec ' . $codec_config->codec->name . ' configuration ' . $codec_config->name . ' is created', 'success');
    }

    /**
     * forderte Seite zum ändern der Dokumentation an
     * @param $type string (compare | full) Art der Dokumentation
     * @param $id int ID Kodierungsverfahren
     * @return $this
     */
    public function get_documentation($type, $id)
    {
        try {
            $codec = Codecs::findOrFail($id);
            $documentation = ($type == 'compare') ? $codec->documentation_compare : $codec->documentation_full;
            return View::make('backend.codecs.documentation', ['url' => $this->url, 'codec' => $codec, 'type' => $type, 'documentation' => $documentation]);

        } catch (ModelNotFoundException $e) {
            return redirect('/admin/codecs')->withErrors('Codec mit der ID ' . $id . ' konnte nicht gefunden werden!', 'error');
        }

    }

    /**
     * speichert Dokumentation
     * @param Request $request
     * @param $id  int ID Kodierungsverfahren
     * @return $this
     */
    public function update_documentation(Request $request, $id)
    {
        $codec = Codecs::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'documentation' => 'required',
            'type' => Rule::in(['compare', 'full'])
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $codec->{'documentation_' . $request->type} = $request->documentation;
        $codec->save();

        return redirect('/admin/codecs')->withErrors('Dokumenation von Codec ' . $codec->name . ' wurde gespeichert', 'success');
    }
}
