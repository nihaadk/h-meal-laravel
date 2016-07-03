<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Food;
use Illuminate\Support\Facades\Auth;
use DB;


class FoodController extends Controller
{

    public function index(Request $request)
    {
        if(Auth::check())
        {
            $query = $request->search;
            if($query)
            {
                $foods = DB::table('foods')->where('food_code', $query)->get();
                return view('pages.food',['Foods' => $foods, 'list' => $this->returnFoodList()]);
            }else{
                $foods = Food::all();
                return view('pages.food',['Foods' => $foods, 'list' => $this->returnFoodList()]);
            }
        }
        else
        {
            return redirect()->to('/');
        }
    }

   
  
    public function store(Request $request)
    {
        $food = new Food();
        $food->title = $request->title;
        $food->fat = $request->fat;
        $food->protein = $request->protein;
        $food->calories = $request->calories;
        $food->carbohydrates = $request->carbohydrates;
        $food->food_type = $request->food_type;
        $food->quantity = $request->quantity;

        $food->food_code = $this->makeFoodCode($request);

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
        $food->food_code = $request->food_code;
        $food->fat = $request->fat;
        $food->protein = $request->protein;
        $food->calories = $request->calories;
        $food->carbohydrates = $request->carbohydrates;
        //$food->food_type = $request->food_type;
        $food->quantity = $request->quantity;



        $food->save();

        return redirect('app/food/list');
    }

    public function upQuantity($id)
    {

        $food = Food::findOrFail($id);
        $q = $food->quantity;
        $q += 1;
        $food->quantity = $q;
        $food->save();

        return redirect()->to('app/food/list');
    }

    public function floatToDigit( $var){
      $const = 10;
      $fvar = (float) $var; // 2.2 
      $ivar = (int) $var;  // 2
      $dec = $fvar - $ivar; // 0,2
      return $ivar.($dec*$const); // 2 + 0,2*10
    }

    public function converTo3Dig( $var ){
        
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
    

    public function makeFoodCode( $req )
    {
      $fat = $this->converTo3Dig($req->fat);
      $protein = $this->converTo3Dig($req->protein);
      $calories = $this->converTo3Dig($req->calories);
      $carbo = $this->converTo3Dig($req->carbohydrates);

      if($req->food_type == 'Intravenozno'){
        $type = 1;
      }else {
        $type = 0;
      }

      $code = $this->converTo3Dig($req->food_code);

      $r = $type.''.$code.''.$fat.''.$protein.''.$carbo.''.$calories;
      //dd($r); 
      return $r;         
    }

     public function returnFoodList(){
        $allPatients = Food::all();
        $arrayOfPatients = array_pluck($allPatients, 'food_code');
        $listOfPatients = join(',', $arrayOfPatients);
        return $listOfPatients;
    }





}
