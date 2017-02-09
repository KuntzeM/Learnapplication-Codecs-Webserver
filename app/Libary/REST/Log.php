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
        try {
            $response = $client->get(self::$url . '/log/get', [
                'headers' => [
                    'x-access-token' => self::$token
                ]
            ]);
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

        try {
            $response = $client->get(self::$url . '/log/delete', [
                'headers' => [
                    'x-access-token' => self::$token
                ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    static public function getStatus()
    {
        self::init();

        $client = new Client();

        try {
            $response = $client->get(self::$url . '/public/status', [
                'headers' => [
                    'x-access-token' => self::$token
                ]
            ]);
            return $response->getBody();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }


}