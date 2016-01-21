<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonClosuresTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_closures', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('person_id', false, true);
            $table->integer('ancestor_id_1', false, true);
            $table->integer('ancestor_id_2', false, true);
            $table->integer('level');
//            $table->integer('family');

            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('ancestor_id_1')->references('id')->on('persons');
            $table->foreign('ancestor_id_2')->references('id')->on('persons');

            $table->index('person_id');
            $table->index('ancestor_id_1');
            $table->index('ancestor_id_2');
//            $table->index('family');
        });
    }

    public function down()
    {
        Schema::table('person_closures', function(Blueprint $table)
        {
            Schema::dropIfExists('person_closures');
        });
    }
}
