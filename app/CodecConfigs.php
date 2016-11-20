<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App;

use Illuminate\Database\Eloquent\Model;


class CodecConfigs extends Model
{
    protected $table = 'codec_configs';
    protected $primaryKey = 'codec_config_id';

    public function codec()
    {
        return $this->belongsTo('App\Codecs', 'codec_id');
    }

    public function media_codec_configs()
    {
        return $this->belongsToMany('App\Media', 'media_id');
    }
}
