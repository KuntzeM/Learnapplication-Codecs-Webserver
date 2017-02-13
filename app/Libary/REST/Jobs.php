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
use App\MediaCodecConfig;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;


class Jobs
{
    static private $url;
    static private $token;

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
