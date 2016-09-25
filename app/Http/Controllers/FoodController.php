<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Food;
use App\Category;
use Illuminate\Support\Facades\Auth;
use DB;


class FoodController extends Controller
{

    public function index(Request $request)
    {
        if(Auth::check())
        {
            $food_category = Category::all();
            $query = $request->search;
            if($query)
            {
                $foods = DB::table('foods')->where('food_code', $query)->get();
                return view('pages.food',['Foods' => $foods, 'list' => $this->returnFoodList(),'food_category' => $food_category]);
            }else{
                $foods = Food::all();
                return view('pages.food',['Foods' => $foods, 'list' => $this->returnFoodList(),'food_category' => $food_category]);
            }
        }
        else
        {
            return redirect()->to('/');
        }
    }

   
  
    public function store(Request $request)
    {
        if($request->title == "" || $request->fat == "" || $request->protein == "" || $request->calories == "" || $request->carbohydrates == ""){

           return redirect('app/food/list');
        }

        
        $food = new Food();
        $food->title = $request->title;
        $food->fat = $request->fat;
        $food->protein = $request->protein;
        $food->calories = $request->calories;
        $food->carbohydrates = $request->carbohydrates;
        $food->food_category_id = $request->food_category_id;
        $food->quantity = $request->quantity;

        $food->food_code = $this->makeFoodCode(
            $request->fat, 
            $request->protein, 
            $request->calories, 
            $request->carbohydrates, 
            $request->food_category_id, 
            $request->code
        );

        $food->save();

        return redirect('app/food/list');
    }

   
    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return redirect()->to('app/food/list');
    }

    public function update($id, Request $request)
    {

        $food = Food::findOrFail($id);

        $food->title = $request->title;
        $food->fat = $request->fat;
        $food->protein = $request->protein;
        $food->calories = $request->calories;
        $food->carbohydrates = $request->carbohydrates;
        $food->quantity = $request->quantity;
        $code = substr($food->food_code, 1, 3);
        
        $food->food_code = $this->makeFoodCode(
            $request->fat, 
            $request->protein, 
            $request->calories, 
            $request->carbohydrates, 
            $request->food_category_id, 
            $code
        );

        $food->save();

        return redirect('app/food/list');
    }

    public function floatToDigit( $var){
      $const = 10;
      $fvar = (float) $var; // 2.2 
      $ivar = (int) $var;  // 2
      $dec = $fvar - $ivar; // 0,2
      return $ivar.($dec*$const); // 2 + 0,2*10
    }

    public function converTo3Dig( $var ){

        if($var == '0'){
          return '000';
        }

        if( (int)($var/10) != 0  && (int)($var/10) < 10 ){
          $left = $this->floatToDigit($var);  
          return $left;
        }
        else if( (int)($var/100) != 0 ){
          return $var;   
        }
        else {
          $left = $this->floatToDigit($var);  
          return '0'.$left;
        }
    }
    

    public function makeFoodCode( 
      $fat_r, 
      $protein_r, 
      $calories_r, 
      $carbo_r, 
      $category_id_r, 
      $code_r )
    {
      $fat = $this->converTo3Dig($fat_r);
      $protein = $this->converTo3Dig($protein_r);
      $calories = $this->converTo3Dig($calories_r);
      $carbo = $this->converTo3Dig($carbo_r);
      
      // Intravenozno
      if($category_id_r == '1'){
        $type = 1;
      // Per os
      }else {
        $type = 0;
      }

      $code = $this->converTo3Dig($code_r);

      // 1 (type) + 3 (code) + 3 (fat) + 3 (protein) + 3 (carbo) + 3 (calories)
      $r = $type.''.$code.''.$fat.''.$protein.''.$carbo.''.$calories;
      return $r;         
    }

     public function returnFoodList(){
        $allPatients = Food::all();
        $arrayOfPatients = array_pluck($allPatients, 'food_code');
        $listOfPatients = join(',', $arrayOfPatients);
        return $listOfPatients;
    }



}
