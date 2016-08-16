<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //  koda hrane
        //  naziv
        //  način vnosa (iv, per os, ...)
        //  beljakovine (na 100 enot)
        //  kalorije (na 100 enot)
        //  ogljikovi hidrati (na 100 enot)
        //  maščobe (na 100 enot)

        // hrana
        Schema::create('foods', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('food_code');
            $table->string('food_type');
            $table->string('title');
            $table->integer('quantity');
            $table->double('protein');
            $table->double('calories');
            $table->double('carbohydrates');
            $table->double('fat');
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
        Schema::drop('foods');
    }
}
