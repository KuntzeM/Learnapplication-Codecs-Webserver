<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('media_id');
            $table->timestamps();
            $table->enum('media_type', ['video', 'image']);
            $table->string('origin_file');
            $table->string('name')->unique();
            $table->boolean('active');
            $table->boolean('demo');
            $table->string('owner');
            $table->string('manifest');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
