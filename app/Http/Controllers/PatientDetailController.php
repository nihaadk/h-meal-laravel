<?php

namespace App\Http\Controllers;

use App\Day_visit;
use Illuminate\Http\Request;
use App\Patient;
use App\Food;
use App\Http\Requests;
use App\Measured_sugar;
use App\Visit;

class PatientDetailController extends Controller
{

    public function showDetails($id)
    {
        // Create right Patient with right ID
        $patient = Patient::findOrFail($id);

        $foodlist = Food::lists('id','food_code');

        // Return view with patient parameter
        return view('pages.patient_details',['Patient' => $patient,'Food_list' => $foodlist]);
    }

    public function storeDayVisits($id, Request $request){

        // Create right Patient with right ID
        $patient = Patient::findOrFail($id);

        // Create day_visits array and fill with request data
        $dayVisit = new Day_visit;
        $dayVisit->number_of_visits  = $request->number_of_visits;
        $dayVisit->date_of_visit = $this->changeDataFormat($request->date_of_visit);
        $dayVisit->food_code = $request->food_code;
        $dayVisit->provided = $this->changeDataFormat($request->provided);

        // Save the request data in the day_visits table
        $patient->getDayvisits()->save($dayVisit);

        // Return to patient detail view
        return redirect("app/patient/detail/$id");

    }

    public function storeMsugar($id, Request $request){

        // Create right Patient with right ID
        $patient = Patient::findOrFail($id);

        // Create m_suggar array and fill with request data
        $m_sug = new Measured_sugar();
        $m_sug->number_of_visits  = $request->number_of_visits;
        $m_sug->date_of_measurement  = $this->changeDataFormat($request->date_of_measurement);
        $m_sug->measurement  = $request->measurement;

        // save
        $patient->getMeasuredsugars()->save($m_sug);


        // Return to patient detail view
        return redirect("app/patient/detail/$id");

    }

    public function storeVisits( $id, Request $request){
        // Create right Patient with right ID
        $patient = Patient::findOrFail($id);

        // Create visit array and fill with request data
        $visit = new Visit();

        $visit->number_of_visits = $request->number_of_visits;
        $visit->start_date = $this->changeDataFormat($request->start_date);
        $visit->end_date = $this->changeDataFormat($request->end_date);
        $visit->section_code = $request->section_code;
        $visit->height = $request->height;
        $visit->heaviness = $request->heaviness;
        $visit->i_heaviness = $request->i_heaviness;
        $visit->nutritive_needs = $request->nutritive_needs;

        // save
        $patient->getVisits()->save($visit);


        // Return to patient detail view
        return redirect("app/patient/detail/$id");
    }




    /*
     * Other Methods
     * */

    // Method for change the data format
    public function changeDataFormat($date){

        $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');
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
