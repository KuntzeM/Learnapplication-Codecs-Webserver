<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Libary\REST;


use App\ConfigData;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

/**
 * Class Log
 * singleton class
 * forder Log an und fragt den Mediaserver nach seinem Status
 * @package App\Libary\REST
 */
class Log
{
    /**
     * URL zum Mediaserver
     * @var string
     */
    static private $url;
    /**
     * Authentifikations-Token
     * @var string
     */
    static private $token;

    /**
     * fordert den Log an
     * @return \Psr\Http\Message\StreamInterface JSON-Objekt
     * @throws \Exception
     */
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

    /**
     * Erzeugt einen Token und initialisiert ein Singleton-Objekt
     */
    static private function init()
    {
        $configData = ConfigData::getInstance();
        self::$url = $configData->media_server;
        $customClaims = ['token' => $configData->api_key, 'exp' => time() + $configData->api_expire];
        $payload = JWTFactory::make($customClaims);
        $token = JWTAuth::encode($payload);
        self::$token = $token;
    }

    /**
     * löscht den Log des Mediaservers
     * @throws \Exception
     */
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

    /**
     * überprüft ob der Mediaserver erreichbar ist und ob ein Kodierungsprozess läuft
     * @return \Psr\Http\Message\StreamInterface JSON-Objekt
     * @throws \Exception
     */
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