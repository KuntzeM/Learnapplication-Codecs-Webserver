<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Media;
use App\CodecConfigs;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id';


    public function getMedia(){

        try{
            return Media::find($this->media_id);
        }catch(ModelNotFoundException $e){
            return new Media();
        }

    }
    public function getCodecConfiguration(){
        try{
            return CodecConfigs::find($this->codec_config_id);
        }catch(ModelNotFoundException $e){
            return new CodecConfigs();
        }

    }


}
