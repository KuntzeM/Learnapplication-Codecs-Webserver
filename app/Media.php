<?php

namespace App;

use App\Libary\REST\FileNodeJS;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'media_id';

    public function getTranscodedFiles()
    {
        $output = array();

        $codec_configs = CodecConfigs::leftJoin('codecs', function ($join) {
            $join->on('codecs.codec_id', '=', 'codec_configs.codec_id');
        })->where('media_type', $this->media_type)
            ->orderBy('codec_configs.codec_id', 'asc')
            ->select('*', 'codec_configs.name as cc_name', 'codecs.name as codec_name')
            ->get();

        foreach ($codec_configs as $codec_config) {
            $media_codec_config = MediaCodecConfig::where('codec_config_id', $codec_config['codec_config_id'])
                ->where('media_id', $this->media_id)
                ->get();
            $media_codec_config_id = 0;
            $psnr = 0;
            $ssim = 0;
            $size = 0;

            if (count($media_codec_config) > 0) {
                $media_codec_config_id = $media_codec_config[0]->media_codec_config_id;
                $psnr = $media_codec_config[0]->psnr;
                $ssim = $media_codec_config[0]->ssim;
                $size = $media_codec_config[0]->size;
            }

            /*
             * status:
             * -1 => no transcoded video
             * 0 => job is in queue
             * 1 => video exists
             */

            if ($media_codec_config_id == 0) {

                /*$job = Job::where('media_id', $this->media_id)->where('codec_config_id', $codec_config['codec_config_id'])->first();

                if ($job) {
                    $status = 0;
                } else {
                    $status = -1;
                }
                */
                $status = 0;
            } else {
                $status = 1;
            }


            $tmp = [
                'codec_config_id' => $codec_config['codec_config_id'],
                'codec_name' => $codec_config->codec_name,
                'codec_config_name' => $codec_config->cc_name,
                'media_codec_config_id' => $media_codec_config_id,
                'size' => $size,
                'psnr' => $psnr,
                'ssim' => $ssim,
                'status' => $status
            ];

            array_push($output, $tmp);
        }

        return $output;
    }

    public function getUrl($resize_width = null)
    {
        $size = '';
        if ($resize_width != null) {
            $size = '?size=' . intval($resize_width);
        }

        return url(join(DIRECTORY_SEPARATOR, ['getMedia', $this->media_type, $this->origin_file])) . $size;
    }

    public function photos()
    {
        return $this->has_many('Photo');
    }

    public function delete()
    {
        // delete all related photos
        $this->media_codec_configs()->delete();

        try {
            FileNodeJS::deleteFile($this->media_type, $this->origin_file);
        } catch (\Exception $e) {

        }

        return parent::delete();
    }

    public function media_codec_configs()
    {
        return $this->hasMany('App\MediaCodecConfig', 'media_id');
    }
}
