<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('parental', 255)->nullable();
            $table->boolean('gender');


//            $table->integer('real_depth');
//            $table->integer('position');

            $table->integer('parent_id_1', false, true)->nullable();
            $table->integer('parent_id_2', false, true)->nullable();

            $table->timestamps();

            $table->foreign('parent_id_1')->references('id')->on('persons');
            $table->foreign('parent_id_2')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
