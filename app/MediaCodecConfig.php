<?php

namespace App;


use App\Libary\REST\FileNodeJS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaCodecConfig extends Model
{
    public $codec_config_name;
    protected $table = 'media_codec_configs';
    protected $primaryKey = 'media_codec_config_id';
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

    public function getCodecConfig()
    {

        return CodecConfigs::where('codec_config_id', $this->codec_config_id)->first();
    }


    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id');
    }

    public function delete()
    {
        try {
            FileNodeJS::deleteFile($this->media->media_type, $this->file_path);
        } catch (\Exception $e) {

        }

        return parent::delete();
    }


}
