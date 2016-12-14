<?php

use Illuminate\Database\Seeder;

class CodecsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('codecs')->insert([
            'name' => 'H.264',
            'ffmpeg_codec' => 'libx264',
            'extension' => 'mkv',
            'media_type' => 'video',
            'documentation_de' => '',
            'documentation_en' => '',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('codecs')->insert([
            'name' => 'VP9',
            'ffmpeg_codec' => 'libvpx-vp9',
            'extension' => 'mkv',
            'media_type' => 'video',
            'documentation_de' => '',
            'documentation_en' => '',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('codecs')->insert([
            'name' => 'jpg',
            'ffmpeg_codec' => 'jpg',
            'extension' => 'jpg',
            'media_type' => 'image',
            'documentation_de' => '',
            'documentation_en' => '',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('codecs')->insert([
            'name' => 'png',
            'ffmpeg_codec' => 'png',
            'extension' => 'png',
            'media_type' => 'image',
            'documentation_de' => '',
            'documentation_en' => '',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('codecs')->insert([
            'name' => 'jpg2000',
            'ffmpeg_codec' => 'jp2',
            'extension' => 'jp2',
            'media_type' => 'image',
            'documentation_de' => '',
            'documentation_en' => '',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);

        DB::table('codec_configs')->insert([
            'name' => '1000 kbit/s',
            'codec_id' => 1,
            'ffmpeg_bitrate' => '1000',
            'ffmpeg_parameters' => '',
            'active' => true,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('codec_configs')->insert([
            'name' => '1000 kbit/s',
            'codec_id' => 2,
            'ffmpeg_bitrate' => '1000',
            'ffmpeg_parameters' => '',
            'active' => true,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('codec_configs')->insert([
            'name' => '75%',
            'codec_id' => 3,
            'ffmpeg_bitrate' => '75',
            'ffmpeg_parameters' => '',
            'active' => true,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('codec_configs')->insert([
            'name' => 'compression level 0 ',
            'codec_id' => 4,
            'ffmpeg_bitrate' => '9',
            'ffmpeg_parameters' => '',
            'active' => true,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        DB::table('codec_configs')->insert([
            'name' => '75%',
            'codec_id' => 5,
            'ffmpeg_bitrate' => '75',
            'ffmpeg_parameters' => '',
            'active' => true,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
    }
}
