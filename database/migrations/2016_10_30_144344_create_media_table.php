<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->engine = "InnoDB";
            $table->increments('media_id');
            $table->timestamps();
            $table->enum('media_type', ['video', 'image']);
            $table->string('origin_file')->default('');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->string('owner')->default(1);
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
