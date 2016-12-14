<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\CodecConfigs;


class MediaCodecConfig extends Model
{
    protected $table = 'media_codec_configs';
    protected $primaryKey = 'media_codec_config_id';

    public $codec_config_name;
    protected $codec_config;
    /**
     * MediaCodecConfig constructor.
     */
    public function __construct(array $attributes = array(), $value =null)
    {
        /* override your model constructor */
        parent::__construct($attributes);


    }

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


    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }


}
