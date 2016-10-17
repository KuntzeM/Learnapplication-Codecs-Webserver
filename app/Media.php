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
}
