<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Codecs
 * Model für Datenbanktabelle: Codecs
 * @package App
 */
class Codecs extends Model
{
    /**
     * @var string
     */
    protected $table = 'codecs';
    /**
     * @var string
     */
    protected $primaryKey = 'codec_id';

    /**
     * Beziehung zu Model CodecConfigs
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codec_configs()
    {
        return $this->hasMany('App\CodecConfigs', 'codec_id');
    }
}
