<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public static function returnTitle($code){

    	$food = Food::where('food_code', $code)->get();

    	if(!$food->isEmpty()){
    		$firstFood = $food->first();
    	}

    	return $firstFood;
    }
    
}
