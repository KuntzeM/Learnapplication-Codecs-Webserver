<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codecs extends Model
{
    protected $table = 'codecs';
    protected $primaryKey = 'codec_id';

    public function codec_configs()
    {
        return $this->hasMany('App\CodecConfigs', 'codec_id');
    }
}
