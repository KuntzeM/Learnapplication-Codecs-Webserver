<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaCodecConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_codec_configs', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('media_codec_config_id');
            $table->integer('codec_config_id')->unsigned();
            $table->foreign('codec_config_id')->references('codec_config_id')->on('codec_configs');
            $table->integer('media_id')->unsigned();
            $table->foreign('media_id')->references('media_id')->on('media');
            $table->string('file_path');
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
        Schema::dropIfExists('media_codec_configs');
    }
}
