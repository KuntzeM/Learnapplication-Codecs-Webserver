<?php

namespace App\Libary;

class Placeholder
{
    public static function changePlaceholder($html){

        $vcodecs = \App\Codecs::where('media_type', 'video')->get();

        $vcodec_list = array();
        foreach ($vcodecs as $item) {

            $vcodec_list[] = '<li>'.$item->name.'</li>';
        };

        $vcodec_string = '<ul class="codec_list">'.implode('', $vcodec_list).'</ul>';

        $icodecs = \App\Codecs::where('media_type', 'image')->get();

        $icodec_list = array();
        foreach ($icodecs as $item) {

            $icodec_list[] = '<li>'.$item->name.'</li>';
        };

        $icodec_string = '<ul class="codec_list">'.implode('', $icodec_list).'</ul>';

        $html = str_replace('[!video_codecs]', $vcodec_string, $html);
        $html = str_replace('[!image_codecs]', $icodec_string, $html);

        return $html;
    }

}