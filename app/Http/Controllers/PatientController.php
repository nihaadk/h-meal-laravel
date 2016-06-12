<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Patient;
use DB;

class PatientController extends Controller
{
    /*
     *
     * List of all Patients
     *
     * */
    public function index(Request $request)
    {
        $errorMessage = null;
        if (Auth::check()) {
            $query = $request->search;
            if ($query) {
                $patients = DB::table('patients')->where('zzzs_number', $query)->get();
                if (empty($patients)) {
                    $patients = DB::table('patients')->where('zzzs_number', $query)->get();
                }
                return view('pages.patient', ['Patients' => $patients, 'ErrorMessage' => $errorMessage]);
            } else {
                $patients = Patient::all();
                return view('pages.patient', ['Patients' => $patients, 'ErrorMessage' => $errorMessage]);
            }
        } else {
            return redirect()->to('/');
        }
    }

    /*
     * Check exists patient
     *
     * */
    public function existsPatient( $newZZZSst ){

        $allPatients =Patient::all();

        foreach ( $allPatients as $patient ){

            if($patient->zzzs_number == $newZZZSst ){
                return "Bolnik $patient->first_name $patient->last_name, z ZZZS števlikom $newZZZSst že obstaja !";
            }
        }

        return null;
    }





    /*
     *
     * Add new Patient
     *
     * */
    public function store(Request $request)
    {


        // Create new Patient
        $patient = new Patient;
        $patient->last_name = $request->last_name;
        $patient->first_name = $request->first_name;
        $patient->address = $request->address;
        $patient->date = $this->changeDataFormat($request->date);

        $errorMessage = $this->existsPatient($request->zzzs_number);

        if(is_null($errorMessage)){
            $patient->zzzs_number = $request->zzzs_number;
            $patient->save();
        }

        $patients = Patient::all();
        return view('pages.patient', ['Patients' => $patients, 'ErrorMessage' => $errorMessage]);

        //return redirect('app/patient/list');
    }

    /*
     *
     * Update Patient
     *
     * */
    public function update($id, Request $request)
    {
        $patient = Patient::findOrFail($id);
        $patient->last_name = $request->last_name;
        $patient->first_name = $request->first_name;
        $patient->address = $request->address;
        $patient->date = $this->changeDataFormat($request->date);
        $patient->save();

        return redirect('app/patient/list');
    }

    /*
     *
     * Delete Patient
     *
     * */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->to('app/patient/list');
    }

    


    /*
     *
     * Methods
     *
     * */
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