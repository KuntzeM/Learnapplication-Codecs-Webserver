<?php
/**
 * Created by PhpStorm.
 * User: mathias
 * Date: 06.02.17
 * Time: 22:23
 */

namespace App\Libary\REST;


use App\CodecConfigs;
use App\ConfigData;
use App\Media;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;


class Job
{
    static private $url;
    static private $token;

    static public function getJob()
    {
        self::init();

        $client = new Client();
        $header = [
            'x-access-token' => self::$token
        ];
        try {
            $response = $client->get(self::$url . '/job/get', $header);
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

    static public function createJobPackage($media_id, $codec_config_id)
    {
        try {
            $codec_config = CodecConfigs::findOrFail($codec_config_id);
            $media = Media::findOrFail($media_id);
            $output = $media->media_id . '_' . $codec_config->codec_config_id . '_' . md5($media->name . microtime(false) . rand(1, 10)) . '.' . $codec_config->codec->extension;

            $output = [
                'media_type' => $media->media_type,
                'name' => $media->origin_file,
                'codec' => $codec_config->codec->ffmpeg_codec,
                'bitrate' => $codec_config->ffmpeg_bitrate,
                'optional' => $codec_config->ffmpeg_parameters,
                'convert' => $codec_config->codec->convert,
                'output' => $output
            ];
            return $output;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }

    }

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

    static public function deleteLog()
    {
        self::init();

        /**
         * TODO: delete job
         */
    }
}
