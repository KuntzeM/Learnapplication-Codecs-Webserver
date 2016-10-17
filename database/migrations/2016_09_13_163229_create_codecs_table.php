<?php
/**
 * Copyright (c) 2016. by Julia Peter & Mathias Kuntze
 * media project TU Ilmenau
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codecs', function (Blueprint $table) {
            $table->increments('codec_id');
            $table->string('name')->unique();
            $table->string('ffmpeg_codec');
            $table->enum('media_type', ['video', 'image']);
            $table->text('documentation_de')->nullable();
            $table->text('documentation_en')->nullable();
            $table->timestamps();
        });

        Schema::create('codec_configs', function (Blueprint $table) {
            $table->increments('codec_config_id');
            $table->integer('codec_id')->unsigned();
            $table->foreign('codec_id')->references('config_id')->on('codecs');
            $table->string('name')->unique();
            $table->string('ffmpeg_parameters');
            $table->boolean('active');
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
        Schema::drop('codecs');
        Schema::drop('codec_configs');
    }
}
