<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function(Blueprint $table) {
           $table->increments('id');
           $table->integer('forum_id');
           $table->integer('user_id');
           $table->integer('user_name');
           $table->text('subject');
           $table->integer('last_poster_id');
           $table->string('last_poster_name');
           $table->boolean('closed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
