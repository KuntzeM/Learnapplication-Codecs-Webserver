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
 * Class FileNodeJS
 * singleton class
 * fordert Bilder und Videos an bzw versendet sie an den Mediaserver
 * @package App\Libary\REST
 */
class FileNodeJS
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
     * forder Video oder Bild an
     * @param $media_type string (image | video)
     * @param $name string
     * @param $size int / anzufordernde Dateigröße des Bildes -> ressourcen schonen
     * @return array gibt Datei und Metainformationen zurück
     *  'file' Datei
     *  'statuscode' HTTP-Code, 200 wenn erfolgreich
     *  'mime' Multimediatype z.B. video/webm
     *  'size' Dateigröße
     *  'duration' Videolänge
     * @throws \Exception Fehler, falls nicht angefordert werden kann
     */
    static public function getFile($media_type, $name, $size)
    {
        self::init();

        $client = new Client();

        try {
            $response = $client->get(self::$url . '/media/get/' . $media_type . '/' . $name, [
                'headers' => [
                    'x-access-token' => self::$token,
                    'resize' => $size
                ]
            ]);
            if($response->hasHeader('duration')){
                $duration = $response->getHeader('duration')[0];
            }else{
                $duration = 1;
            }
            return ['file' => $response->getBody(), 'statuscode' => $response->getStatusCode(), 'mime' => $response->getHeader('Content-Type'), 'size' => $response->getHeader('size'), 'duration' => $duration];
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
     * sendet ein Bild oder Video an den Mediaserver
     * @param $file binary
     * @param $name string / zu speichender Dateiname
     * @param $media_type string (image | video)
     * @return int HTTP-Statuscode 200 -> erfolgreich / 404 -> fehlgeschlagen
     */
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

    /**
     * Löscht Datei vom Mediaserver
     * @param $media_type string (image | video)
     * @param $name string eindeutige Dateiname
     * @throws \Exception Fehler falls nicht erfolgreich
     */
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

    /**
     * fordert PSNR und SSIM vom Mediaserver an
     * @param $media_type1 string (image | video)
     * @param $name1 string eindeutiger Name der original Datei
     * @param $media_type2 string (image | video)
     * @param $name2 string eindeutiger Name der zu vergleichenden Datei
     * @return array
     *  'psnr'
     *  'ssim'
     *  'size'  Dateigröße
     * @throws \Exception
     */
    static public function getMetadata($media_type1, $name1, $media_type2, $name2)
    {
        self::init();

        $client = new Client();

        try {
            $response = $client->get(self::$url . '/media/get/metrics/' . $media_type1 . '/' . $name1 . '/' . $media_type2 . '/' . $name2, [
                'headers' => [
                    'x-access-token' => self::$token,
                ]
            ]);

            $output = \GuzzleHttp\json_decode($response->getBody());

            return ['ssim' => $output->SSIM, 'psnr' => $output->PSNR, 'size' => $output->size];
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }
}