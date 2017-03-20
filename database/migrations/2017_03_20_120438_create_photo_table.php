<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_id')
                    ->unsigned();
            $table->foreign('album_id')
                    ->references('id')
                    ->on('album')
                    ->onDelete('cascade');
            $table->string('filename', 255);
            $table->string('original_name', 255);
            $table->string('title', 128);
            $table->string('description', 255);
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
        Schema::drop('photo');
    }

}
