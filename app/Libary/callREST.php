<?php
/**
 * Created by PhpStorm.
 * User: mathias
 * Date: 01.11.16
 * Time: 17:53
 */

namespace App\Libary;

use App\ConfigData;
use App\User;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;


class callREST
{

    private $token = null;
    private $url = null;

    /**
     * callREST constructor.
     */
    public function __construct()
    {
        $configData = ConfigData::getInstance();

        $this->url = $configData->media_server;

        $user = User::find(1)->first();
        $customClaims = ['sub' => $user->id, 'password' => $user->password, 'exp' => time() + $configData->api_expire];

        $payload = JWTFactory::make($customClaims);

        $this->token = JWTAuth::encode($payload);

    }

    public function getImage($id = null)
    {

        $configData = ConfigData::getInstance();
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $configData->media_server . '/public/image', [
            'x-access-token' => $this->token
        ]);
        $promise = $client->sendAsync($request)->then(function ($response) {
            var_dump(\GuzzleHttp\json_decode($response->getBody()));
        });
        $promise->wait();
    }
}