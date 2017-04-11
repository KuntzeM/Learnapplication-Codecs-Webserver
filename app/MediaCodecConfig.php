<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App;


use App\Libary\REST\FileNodeJS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class MediaCodecConfig
 * Model für Datenbanktabelle: MediaCodecConfig
 * @package App
 */
class MediaCodecConfig extends Model
{
    /**
     * @var string
     */
    public $codec_config_name;
    /**
     * @var string
     */
    protected $table = 'media_codec_configs';
    /**
     * @var string
     */
    protected $primaryKey = 'media_codec_config_id';
    /**
     * @var CodecConfigs
     */
    protected $codec_config;

    /**
     * MediaCodecConfig constructor.
     */
    public function __construct(array $attributes = array(), $value =null)
    {
        /* override your model constructor */
        parent::__construct($attributes);
    }

    /**
     * fordert Kodierungsinformationen zu dieser kodierten Version an
     * @return array|null
     */
    public function getMediaCodecInfos(){
        try{
            $output = array();
            $codec_config = CodecConfigs::findOrFail($this->codec_config_id);
            $output['media_codec_config_id']= $this->media_codec_config_id;
            $output['codec_name'] = $codec_config->codec->name;
            $output['codec_config_name'] = $codec_config->name;

            return $output;
        }catch(ModelNotFoundException $ex){
            return null;
        }
    }

    /**
     * Beziehung zu Model CodecConfigs
     * @return CodecConfigs
     */
    public function getCodecConfig()
    {
        return CodecConfigs::where('codec_config_id', $this->codec_config_id)->first();
    }

    /**
     * Beziehung zu Model Media
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }

    /**
     * löscht die Kodierungsversion
     * @return bool|null
     */
    public function delete()
    {
        try {
            FileNodeJS::deleteFile($this->media->media_type, $this->file_path);
        } catch (\Exception $e) {

        }
        return parent::delete();
    }
}
