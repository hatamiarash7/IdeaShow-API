<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('user_name');
            $table->string('title', 50)->unique();
            $table->text('body');
            $table->integer('like')->default(0);
            $table->integer('dislike')->default(0);
            $table->integer('reported')->default(0);
            $table->text('tags')->nullable();
            $table->integer('active')->default(1);
            $table->string('slug')->unique();
            $table->timestamps();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas');
    }
}
