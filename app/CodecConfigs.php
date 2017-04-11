<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CodecConfigs
 * Model für Datenbanktabelle: CodecConfigs
 * @package App
 */
class CodecConfigs extends Model
{
    protected $table = 'codec_configs';
    protected $primaryKey = 'codec_config_id';

    /**
     * Beziehung zu Model Codecs
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function codec()
    {
        return $this->belongsTo('App\Codecs', 'codec_id');
    }

    /**
     * Beziehung zu Model MediaCodecConfig
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function media_codec_configs()
    {
        return $this->belongsToMany('App\Media', 'media_id');
    }
}
