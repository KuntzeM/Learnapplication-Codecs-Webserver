<?php
/**
 * Copyright (c) 2016-2017. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */
namespace App;

use App\Libary\REST\FileNodeJS;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Media
 * Model für Datenbanktabelle: Media
 * @package App
 */
class Media extends Model
{
    /**
     * @var string
     */
    protected $table = 'media';
    /**
     * @var string
     */
    protected $primaryKey = 'media_id';

    /**
     * gibt alle kodierten Versionen und Informationen des Bildes bzw. Videos zurück
     * @return array
     */
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

    /**
     * gibt die URL zur Datei zurück
     * @param null $resize_width int Bildgröße
     * @return string
     */
    public function getUrl($resize_width = null)
    {
        $size = '';
        if ($resize_width != null) {
            $size = '?size=' . intval($resize_width);
        }

        return url(join(DIRECTORY_SEPARATOR, ['getMedia', $this->media_type, $this->origin_file])) . $size;
    }

    /**
     * fordert beim Mediaserver an die Datei und alle ihrer Versionen zu löschen
     * @return bool|null
     */
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

    /**
     * Beziehung zu Model MediaCodecConfig
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media_codec_configs()
    {
        return $this->hasMany('App\MediaCodecConfig', 'media_id');
    }
}
