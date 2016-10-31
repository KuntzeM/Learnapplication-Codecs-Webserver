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
    public function get_index()
    {
        #$client = new Client();
        /*
        $res = $client->request('GET', 'http://localhost:3000/public/video', [
            'auth' => ['user', 'pass']
        ]);
        echo $res->getStatusCode();
        // 200
                echo $res->getHeaderLine('content-type');
        // 'application/json; charset=utf8'
                echo $res->getBody();
        // {"type":"User"...'
        */
        // Send an asynchronous request.

        $config = ConfigData::getInstance();
        //$config->sendMessage();
        return View::make('backend.configurations.index', ['title' => 'Configurations', 'config' => $config]);
    }

    public function update(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'min:5|confirmed',
            'password_confirmation' => 'same:password',
            'media_server' => 'required|active_url',
            'api_key' => 'required'
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

        $configData->update();

        return redirect('/admin/configurations')->withErrors('configurations are updated', 'success');
    }
}
