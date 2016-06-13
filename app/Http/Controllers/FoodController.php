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

    /*
      *
      * Load Food list
      *
      * */
    public function index(Request $request)
    {
        if(Auth::check())
        {
            $query = $request->search;

            if($query){

                $foods = DB::table('foods')->where('titel', $query)->get();

                return view('pages.food',['Foods' => $foods]);


            }else{
                $foods = Food::all();
                return view('pages.food',['Foods' => $foods]);
            }


        }else{
            return redirect()->to('/');
        }
    }

    /*
      *
      * Save new Food
      *
      * */
    public function store(Request $request)
    {
        $food = new Food();

        $food->food_code = $request->food_code;
        $food->title = $request->title;
        $food->fat = $request->fat;
        $food->protein = $request->protein;
        $food->calories = $request->calories;
        $food->carbohydrates = $request->carbohydrates;
        $food->food_type = $request->food_type;
        $food->quantity = $request->quantity;


        $food->save();

        return redirect('app/food/list');
    }

    /*
      *
      * Delete Food
      *
      * */
    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return redirect()->to('app/food/list');
    }

    /*
      *
      * Update Food
      *
      * */
    public function update($id, Request $request)
    {

        $food = Food::findOrFail($id);

        $food->title = $request->title;
        $food->food_code = $request->food_code;
        $food->fat = $request->fat;
        $food->protein = $request->protein;
        $food->calories = $request->calories;
        $food->carbohydrates = $request->carbohydrates;
        $food->food_type = $request->food_type;
        dd($request->food_type);
        $food->quantity = $request->quantity;

        $food->save();

        return redirect('app/food/list');
    }

    /*
      *
      * Update Food quantity
      *
      * */
    public function upQuantity($id){

        $food = Food::findOrFail($id);
        $q = $food->quantity;
        $q += 1;
        $food->quantity = $q;
        $food->save();

        return redirect()->to('app/food/list');
    }




}
