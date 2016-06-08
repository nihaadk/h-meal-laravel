<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // obiski
        Schema::create('visits', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('patient_id');
            $table->integer('number_of_visits');
            $table->date('stard_date_of_hosp');
            $table->date('end_date_of_hosp');
            $table->double('section_code');
            $table->double('height');
            $table->double('weight');
            $table->double('ideal_weight');
            $table->string('nutritive_needs');
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
        Schema::drop('visits');
    }
}
