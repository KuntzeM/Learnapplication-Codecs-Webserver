<?php

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

/**
 * Class ConfigurationsController
 * @package App\Http\Controllers\Backend
 */
class ConfigurationsController extends Controller
{
    /**
     * ConfigurationsController constructor.
     */
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;

    }

    /**
     * fordert Viewer für Konfigurationsseite an
     * @return mixed
     */
    public function get_index()
    {
        $config = ConfigData::getInstance();

        return View::make('backend.configurations.index', ['url'=> $this->url, 'title' => 'Configurations', 'config' => $config]);
    }

    /**
     * speichert Konfigurationen
     * @param Request $request
     * @return $this
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'min:5|confirmed',
            'password_confirmation' => 'same:password',
            'media_server' => 'required',
            'api_key' => 'required',
            'api_expire' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $configData = ConfigData::getInstance();

        $configData->username = $request->username;
        $configData->email = $request->email;
        $configData->password = $request->password;
        $configData->media_server = $request->media_server;
        $configData->api_key = $request->api_key;
        $configData->api_expire = $request->api_expire;

        $configData->update();

        return redirect('/admin/configurations')->withErrors('configurations are updated', 'success');
    }

    /**
     * fordert Seite tum ändern der Startseite und Impressum an
     * @param $type string (welcome | impressum)
     * @return $this
     */
    public function get_site($type)
    {

        try {
            $site = Configuration::where('name', $type)->firstOrFail();
        } catch (ModelNotFoundException $e) {

            $site = new Configuration();
            if ($type == 'impressum' or $type == 'welcome') {
                $site->name = $type;
            } else {
                return redirect('/admin/configurations')->withErrors('Seite ' . $type . ' existiert nicht', 'error');
            }
            $site->save();
        }
        return View::make('backend.codecs.documentation', ['url' => $this->url, 'codec' => Null, 'type' => Null, 'documentation' => $site->value, 'site' => $type]);


    }

    /**
     * speichert Startseite und Impressum
     * @param Request $request
     * @param $type string (welcome | impressum)
     * @return $this
     */
    public function update_site(Request $request, $type)
    {
        try {
            $site = Configuration::where('name', $type)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $site = new Configuration();
            if ($type == 'impressum' or $type == 'welcome') {
                $site->name = $type;
            } else {
                return redirect('/admin/configurations')->withErrors('Seite ' . $type . ' existiert nicht', 'error');
            }
        }

        $site->value = $request->documentation;
        $site->save();

        return redirect('/admin/configurations')->withErrors('Seite ' . $type . ' wurde gespeichert', 'success');
    }
}
