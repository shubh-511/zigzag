<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->string('slug'); // post slug
            $table->string('txt_content');
            $table->string('file_content');
            $table->string('category');     //specify profile,cover,posts
            $table->string('type');     //file type jpg,png,pdf,doc,emoji etc.
            $table->string('size');     //file size
            $table->string('extension'); //file extension
            $table->string('status');    //post status  
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
        Schema::dropIfExists('posts');
    }
}
