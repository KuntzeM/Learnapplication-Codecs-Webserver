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


    public function postStartTranscoding()
    {

        $configData = ConfigData::getInstance();
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('POST', $configData->media_server . '/auth/startTranscoding', [
            'x-access-token' => $this->token
        ]);
        $promise = $client->sendAsync($request)->then(function ($response) {
            //var_dump(\GuzzleHttp\json_decode($response->getBody()));
        });
        //$promise->wait();
    }

    public function getDebugLevel()
    {

        $configData = ConfigData::getInstance();
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $configData->media_server . '/auth/debugLevel', [
            'x-access-token' => $this->token
        ]);
        $promise = $client->send($request);
        $json = json_decode($promise->getBody());
        return $json->debugLevel;
    }

    public function setDebugLevel($debugLevel)
    {

        $configData = ConfigData::getInstance();
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('POST', $configData->media_server . '/auth/debugLevel', [
            'x-access-token' => $this->token,

        ], json_encode($debugLevel));
        $promise = $client->sendAsync($request)->then(function ($response) {
            //var_dump(\GuzzleHttp\json_decode($response->getBody()));
        });
    }

    public function deleteMedia($id)
    {

        $configData = ConfigData::getInstance();
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('DELETE', $configData->media_server . '/auth/media/' . $id, [
            'x-access-token' => $this->token
        ]);
        $promise = $client->send($request);
        return $promise;
    }

    public function getToken()
    {
        return $this->token;
    }
}