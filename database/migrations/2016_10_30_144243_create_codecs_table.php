<?php

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
            $table->engine = "InnoDB";
            $table->increments('codec_id');
            $table->string('name')->unique();
            $table->string('ffmpeg_codec');
            $table->string('extension', 20);
            $table->enum('media_type', ['video', 'image']);
            $table->text('documentation_compare')->nullable();
            $table->text('documentation_full')->nullable();
            $table->boolean('convert')->default(false);
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

    }
}
