<?php

namespace App\Http\Controllers\Backend;

use App\ConfigData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;

class ConfigurationsController extends Controller
{
    public function __construct()
    {
        $config = ConfigData::getInstance();
        $this->url = $config->media_server;

    }

    public function get_index()
    {

        $config = ConfigData::getInstance();

        return View::make('backend.configurations.index', ['url'=> $this->url, 'title' => 'Configurations', 'config' => $config]);
    }

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
}
