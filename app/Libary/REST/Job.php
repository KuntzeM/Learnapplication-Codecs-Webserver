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

    static public function addJob($media_id, $codec_config_id)
    {
        try {
            $codec_config = CodecConfigs::findOrFail($codec_config_id);
            $media = Media::findOrFail($media_id);
            try {
                $output = $media->media_id . '_' . $codec_config->codec_config_id . '_' . md5($media->name . microtime(false) . rand(1, 10)) . '.' . $codec_config->codec->extension;

                Job::postJob($media->media_type, $media->origin_file, $codec_config->codec->ffmpeg_codec, $codec_config->ffmpeg_bitrate, $codec_config->ffmpeg_parameters, $output);
            } catch (\Exception $e) {
                return false;
            }
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
    }

    static private function postJob($media_type, $name, $codec, $bitrate, $optional, $output)
    {
        self::init();

        $client = new Client();
        try {
            $client->postAsync(self::$url . '/jobs/post', [
                'multipart' => [
                    [
                        'name' => 'token',
                        'contents' => self::$token
                    ],
                    [
                        'name' => 'media_type',
                        'contents' => $media_type
                    ],
                    [
                        'name' => 'name',
                        'contents' => $name
                    ],
                    [
                        'name' => 'codec',
                        'contents' => $codec
                    ],
                    [
                        'name' => 'bitrate',
                        'contents' => $bitrate
                    ],
                    [
                        'name' => 'optional',
                        'contents' => $optional
                    ],
                    [
                        'name' => 'output',
                        'contents' => $output
                    ],

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
