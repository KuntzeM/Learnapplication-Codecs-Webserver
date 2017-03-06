<?php


namespace App\Libary\REST;


use App\ConfigData;
use App\Media;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class FileNodeJS
{
    static private $url;
    static private $token;

    static public function getFile($media_type, $name, $size)
    {
        /**
         * TODO: resize image
         */

        self::init();

        $client = new Client();

        try {
            $response = $client->get(self::$url . '/media/get/' . $media_type . '/' . $name, [
                'headers' => [
                    'x-access-token' => self::$token,
                    'resize' => $size
                ]
            ]);
            return ['file' => $response->getBody(), 'statuscode' => $response->getStatusCode(), 'mime' => $response->getHeader('Content-Type'), 'size' => $response->getHeader('size')];
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

    static public function postFile($file, $name, $media_type)
    {
        self::init();

        try {
            $client = new Client();

            $response = $client->post(self::$url . '/media/post', [
                'multipart' => [
                    [
                        'name' => 'name',
                        'contents' => $name
                    ],
                    [
                        'name' => 'media_type',
                        'contents' => $media_type
                    ],
                    [
                        'name' => 'file',
                        'contents' => fopen($file, 'r')
                    ]
                ],
                'headers' => [
                    'x-access-token' => self::$token
                ]
            ]);
            return 200;
        } catch (\Exception $e) {
            return 404;
        }

    }

    static public function deleteFile($media_type, $name)
    {
        self::init();

        $client = new Client();

        try {
            $client->delete(self::$url . '/media/delete/' . $media_type . '/' . $name, [
                'headers' => [
                    'x-access-token' => self::$token
                ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    static public function putFile(Media $m, $name)
    {
        self::init();
    }
}