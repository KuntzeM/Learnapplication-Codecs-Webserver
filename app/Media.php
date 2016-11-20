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

    public function codec_configs()
    {
        return $this->media_codec_configs->codec_config;
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
