<?php


namespace App\Libary\REST;


use App\ConfigData;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class Log
{
    static private $url;
    static private $token;

    static public function getLog()
    {
        self::init();

        $client = new Client();
        $header = [
            'x-access-token' => self::$token
        ];
        try {
            $response = $client->get(self::$url . '/log/get', $header);
            return $response->getBody();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    static private function init()
    {
        $configData = ConfigData::getInstance();
        self::$url = $configData->media_server;
        $customClaims = ['token' => $configData->api_key, 'exp' => time() + $configData->api_expire];
        $payload = JWTFactory::make($customClaims);
        $token = JWTAuth::encode($payload);
        self::$token = $token;
    }

    static public function deleteLog()
    {
        self::init();

        $client = new Client();
        $header = [
            'x-access-token' => self::$token
        ];
        try {
            $response = $client->get(self::$url . '/log/delete', $header);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

}