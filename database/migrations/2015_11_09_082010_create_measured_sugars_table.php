<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasuredSugarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // izmerjen sladkorja
        Schema::create('measured_sugars', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('patient_id');
            $table->integer('number_of_visits');
            $table->date('date_of_measurement');
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
        Schema::drop('measured_sugars');
    }
}
