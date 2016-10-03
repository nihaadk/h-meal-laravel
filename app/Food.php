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

// Food obj food_code
// 0000050100124110

// Patient->DV->food_code obj food_code
// 0000050100124110

