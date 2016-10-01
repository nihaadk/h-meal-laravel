<?php

namespace App\Http\Controllers;

use App\Day_visit;
use Illuminate\Http\Request;
use App\Patient;
use App\Food;
use App\Category;
use App\Http\Requests;
use App\Measured_sugar;
use App\Visit;

class PatientDetailController extends Controller
{

    public function showDetails($id)
    {
        // Create right Patient with right ID
        $patient = Patient::findOrFail($id);
        $category =Category::all()->reverse();

        $foodlist =Food::lists('title','food_code');

        // Return view with patient parameter
        return view('pages.patient_details',['Patient' => $patient,'Food_list' => $foodlist, 'categorys' => $category]);
    }

    /*
        DAY VISITS
    */

    public function storeDayVisits($id, Request $request){

        $patient = Patient::findOrFail($id);
        $food = Food::where('food_code', $request->food_code)->get()->first();

        if($request->quantity == null || $request->food_type == 3){
            return redirect("app/patient/detail/$id");
        }

        // preveri stanje KOLICINE hrane
        if($request->quantity <= $food->quantity){
            $food->quantity = $food->quantity - $request->quantity;
            $food->save();
        }

        $dayVisit = new Day_visit;

        // (vnesena vrednost / kolicina hranljive snovi) * #### hranljive vrednost
        // #### je lahko Mas, Beljank, OH, KCal
        $dayVisit->protein = ($request->quantity / $food->quantity) * $food->protein;
        $dayVisit->calories = ($request->quantity / $food->quantity) * $food->calories;
        $dayVisit->carbohydrates = ($request->quantity / $food->quantity) * $food->carbohydrates;
        $dayVisit->fat = ($request->quantity / $food->quantity) * $food->fat;
        $dayVisit->quantity = $request->quantity;

        $dayVisit->food_category_id = $request->food_type;
        $dayVisit->food_code = $request->food_code;

        $patient->getDayvisits()->save($dayVisit);
        
        return redirect("app/patient/detail/$id");
    }

    public function editds($id, Request $request){
        
        $dv = Day_visit::findOrFail($id);

        $food = Food::where('food_code', $dv->food_code)->get()->first();


        $protein_food = $food->protein;
        $calories_food = $food->calories;
        $carbohydrates_food =$food->carbohydrates;
        $fat_food = $food->fat;

        $quantity = $request->quantity;

        // (vnesena vrednost / kolicina hranljive snovi) * #### hranljive vrednost
        // #### je lahko Mas, Beljank, OH, KCal
        $dv->protein = ($request->quantity / $food->quantity) * $food->protein;
        $dv->calories = ($request->quantity / $food->quantity) * $food->calories;
        $dv->carbohydrates = ($request->quantity / $food->quantity) * $food->carbohydrates;
        $dv->fat = ($request->quantity / $food->quantity) * $food->fat;
        $dv->quantity = $request->quantity;

        $dv->save();

        return redirect()->back();
    }

    public function destroyds($id) {
        $dv = Day_visit::findOrFail($id);
        $dv->delete();
        return redirect()->back();
    }





    /*
        M SUGAR
    */


    public function storeMsugar($id, Request $request){

        // Create right Patient with right ID
        $patient = Patient::findOrFail($id);

        // Create m_suggar array and fill with request data
        $m_sug = new Measured_sugar();
        $m_sug->number_of_visits  = $request->number_of_visits;
        $m_sug->measurement  = $request->measurement;

        // save
        $patient->getMeasuredsugars()->save($m_sug);


        // Return to patient detail view
        return redirect("app/patient/detail/$id");
    }

    public function destroyms($id) {
        $ms = Measured_sugar::findOrFail($id);
        $ms->delete();
        return redirect()->back();
    }

    public function editdms($id, Request $request){
        $ms = Measured_sugar::findOrFail($id);
        
        if($request->measurement == null){
            return redirect()->back();
        }

        $ms->measurement = $request->measurement;
        $ms->save();
        return redirect()->back();
    }




    /*
       VISITS
    */

    public function storeVisits( $id, Request $request){
        // Create right Patient with right ID
        $patient = Patient::findOrFail($id);

        // Create visit array and fill with request data
        $visit = new Visit();

        // Check is visit table empty , and increment number of visits 
        if($patient->getVisits()->count() > 0){
            $thelastVisit = $patient->getVisits()->orderBy('created_at', 'food_code')->first();
            $numberOfVisit = $thelastVisit->number_of_visits;
            $numberOfVisit += 1;
        } else {
            $numberOfVisit = 1;
        }
      
        $visit->patient_id = $id;
        $visit->number_of_visits = $numberOfVisit;

        $visit->start_date = $this->changeDataFormat($request->start_date);
        $visit->end_date = $this->changeDataFormat($request->end_date);
        $visit->section_code = $request->section_code;
        $visit->height = $request->height;
        $visit->heaviness = $request->heaviness;
        $visit->ideal_heaviness = $request->ideal_heaviness;
        $visit->nutritive_needs = $request->nutritive_needs;

        //dd($visit);

        // save
        $patient->getVisits()->save($visit);


        // Return to patient detail view
        return redirect("app/patient/detail/$id");
    }

    public function editv($id, Request $request){
        
        $v = Visit::findOrFail($id);

        if($this->changeDataFormat($request->start_date) != null){
            $v->start_date = $this->changeDataFormat($request->start_date);
        }

        if($this->changeDataFormat($request->end_date) != null ){
            $v->end_date = $this->changeDataFormat($request->end_date);
        }

        $v->section_code = $request->section_code;
        $v->height = $request->height;
        $v->heaviness = $request->heaviness;
        $v->ideal_heaviness = $request->ideal_heaviness;
        $v->nutritive_needs = $request->nutritive_needs;  
        $v->save();

        return redirect()->back();
    }

    public function destroyv($id) {
        $v = Visit::findOrFail($id);
        $v->delete();
        return redirect()->back();
    }


    // Method for change the data format
    public function changeDataFormat($date){

        $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $rdate = str_replace(',','',$date);
        $rdate = str_replace(' ','-',$rdate);

        for( $i=0; $i < sizeof($months); $i++){

            if(strpos($rdate, $months[$i])){
                $cdate = str_replace($months[$i],($i+1),$rdate);
                return date('Y-m-d', strtotime($cdate));
                // dan-mesec-leto
            }
        }

        return null;
    }


}
