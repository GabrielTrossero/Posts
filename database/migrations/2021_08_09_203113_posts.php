<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('titulo', 150);
            $table->string('slug', 150)->unique();
            $table->text('descripcion')->nullable();
            $table->string('imagen', 150)->nullable();
            $table->dateTime('created', $precision = 0)->useCurrent();
            $table->dateTime('modified', $precision = 0)->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post');
    }
}
