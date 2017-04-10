<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App\Libary\REST;


use App\CodecConfigs;
use App\ConfigData;
use App\Media;
use App\MediaCodecConfig;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

/**
 * Class Jobs
 * singleton class
 * fordert bzw legt Kodierungsprozesse beim Mediaserver an
 * @package App\Libary\REST
 */
class Jobs
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
     * fordert alle Jobs vom Mediaserver an
     * @return \Psr\Http\Message\StreamInterface / JSON-Objekt
     * @throws \Exception
     */
    static public function getJobs()
    {
        self::init();

        $client = new Client();
        try {
            $response = $client->get(self::$url . '/jobs/get', [
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
     * Legt einen Auftrag für eine Kodierung und einer Datei an.
     * @param $media_id int ID der Media-Datei
     * @param $codec_config_id int ID der Kodierungskonfiguration
     * @return array
     *  'media_type' string (video | image)
     *  'name' string Dateiname
     *  'codec' string FFMpeg Parameter Kodierungsverfahren,
     *  'bitrate' int Bitrate oder Qualitätsparameter
     *  'optional' string optionaler Kodierungsparameter
     *  'convert' boolean doppelte Kodierung zu lesbaren Kodierung (H.264 bzw. PNG)
     *  'output' string Speicherpfad
     */
    static public function createJobPackage($media_id, $codec_config_id)
    {
        try {
            $codec_config = CodecConfigs::findOrFail($codec_config_id);
            $media = Media::findOrFail($media_id);

            try{
                $mmc = MediaCodecConfig::where('media_id', $media_id)->where('codec_config_id', $codec_config_id)->firstOrFail();

            }catch (ModelNotFoundException $e){
                $mmc = new MediaCodecConfig();
                $mmc->file_path = $media->media_id . '_' . $codec_config->codec_config_id . '_' . md5($media->name . microtime(false) . rand(1, 10)) . '.' . $codec_config->codec->extension;
                $mmc->media_id = $media->media_id;
                $mmc->codec_config_id = $codec_config->codec_config_id;
                $mmc->save();
            }

            $output = [
                'media_type' => $media->media_type,
                'name' => $media->origin_file,
                'codec' => $codec_config->codec->ffmpeg_codec,
                'bitrate' => $codec_config->ffmpeg_bitrate,
                'optional' => $codec_config->ffmpeg_parameters,
                'convert' => $codec_config->codec->convert,
                'output' => $mmc->file_path
            ];
            return $output;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

    }

    /**
     * Sendet kombinierte array von createJobPackage() (mehrere Kodierungsaufträge) an den Mediaserver
     * @param $package array multiarray mit mehreren array von createJobPackage(...)
     * @throws \Exception
     */
    static public function postJob($package)
    {
        self::init();

        $client = new Client();
        try {

            $client->post(self::$url . '/jobs/post', [
                'form_params' => $package,
                'headers' => [
                    'x-access-token' => self::$token
                ]
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * gibt dem Mediaserver den Befehl den Kodierungsprozess zu starten
     * @return \Psr\Http\Message\StreamInterface JSON-Objekt
     * @throws \Exception
     */
    static public function postStartTranscoding()
    {
        self::init();
        $client = new Client();
        try {

            $response = $client->post(self::$url . '/jobs/startTranscoding', [
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
