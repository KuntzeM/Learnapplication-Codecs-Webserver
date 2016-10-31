<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Libary\FFMpegQueue;
use App\User;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use View;

class AdminController extends Controller
{

    public function __construct()
    {
        #$this->middleware('auth');
    }

    public function get_index()
    {
        $user = User::find(1)->first();
        $customClaims = ['sub' => '1', 'password' => $user->password, 'exp' => time() + 14400];

        $payload = JWTFactory::make($customClaims);

        $token = JWTAuth::encode($payload);
        $client = new Client();
        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://localhost:3000/auth/video', [
            'x-access-token' => $token
        ]);
        $promise = $client->sendAsync($request)->then(function ($response) {
            var_dump(\GuzzleHttp\json_decode($response->getBody()));
        });
        $promise->wait();

        return View::make('backend.index', array('pid' => "1"));
    }


}
