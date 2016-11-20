<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'media_id';


    public function media_codec_configs()
    {
        return $this->hasMany('App\MediaCodecConfig', 'media_id');
    }

    private function existConfig($config_id, $media_codec_config)
    {

    }

    public function getTranscodedFiles()
    {
        $output = array();

        $codec_configs = CodecConfigs::leftJoin('codecs', function ($join) {
            $join->on('codecs.codec_id', '=', 'codec_configs.codec_id');
        })->where('media_type', $this->media_type)
            ->orderBy('codec_configs.codec_id', 'asc')
            ->select('*', 'codec_configs.name as cc_name', 'codecs.name as codec_name')
            ->get();

        foreach ($codec_configs as $codec_config) {
            $media_codec_config = MediaCodecConfig::where('codec_config_id', $codec_config['codec_config_id'])
                ->where('media_id', $this->media_id)
                ->get();
            $media_codec_config_id = 0;
            if (count($media_codec_config) > 0) {
                $media_codec_config_id = $media_codec_config[0]->media_codec_config_id;
            }

            $tmp = [
                'codec_config_id' => $codec_config['codec_config_id'],
                'codec_name' => $codec_config->codec_name,
                'codec_config_name' => $codec_config->cc_name,
                'media_codec_config_id' => $media_codec_config_id,
            ];

            array_push($output, $tmp);
        }

        return $output;
    }

    public function getUrl($resize_width = null){
        $config = ConfigData::getInstance();
        $size = '';
        if($resize_width != null){
            $size = '?size=' . intval($resize_width);
        }


        return join(DIRECTORY_SEPARATOR, [$config->media_server, 'public/media', $this->media_id]) . $size;
    }
}
