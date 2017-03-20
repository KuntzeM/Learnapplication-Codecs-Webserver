<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodecConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('codec_configs', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('codec_config_id');
            $table->integer('codec_id')->unsigned();
            $table->foreign('codec_id')->references('codec_id')->on('codecs');
            $table->string('name');
            $table->string('ffmpeg_bitrate');
            $table->string('ffmpeg_parameters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('codec_configs');
    }
}
