<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaCodecConfig extends Model
{
    protected $table = 'media_codec_configs';
    protected $primaryKey = 'media_codec_config_id';

    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }

    public function codec_configs()
    {
        return $this->belongsToMany('App\CodecConfigs', 'codec_config_id');
    }
}
