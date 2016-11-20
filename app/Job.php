<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id';

    public function __construct($media_id, $codec_config_id)
    {

        $this->media_id = $media_id;
        $this->codec_config_id = $codec_config_id;


        return $this;
    }


}
