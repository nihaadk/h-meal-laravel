<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Patient;
use DB;
use Validator;

class ChartController extends Controller
{
    
    public function index()
    {   
        $chart = 'bar';
        $label = 'Dnevni vnosi';
        $xdata1 = null;
        $xdata2 = null;
        $xdata3 = null;
        $xdata4 = null;
        $ydata = null;
        $error = null;
        $chartVersion = 1;


        return view('pages.chart')
            ->with('chart', $chart)
            ->with('xdata1', $xdata1)
            ->with('xdata2', $xdata2)
            ->with('xdata3', $xdata3)
            ->with('xdata4', $xdata4)
            ->with('ydata', $ydata)
            ->with('error', $error)
            ->with('chartVersion', $chartVersion)
            ->with('label', $label);   
    }



    public function update(Request $request)
    {
        $error = $this->ValidationRequest($request);

        // Ce je napaka vrne samo sporocilo napake
        if($error != null){

            $chart = null;
            $chartVersion = null;
            $xdata1 = null;
            $xdata2 = null;
            $xdata3 = null;
            $xdata4 = null;
            $ydata = null;

            return view('pages.chart')
                ->with('chart', $chart)
                ->with('chartVersion', $chartVersion)
                ->with('xdata1', $xdata1)
                ->with('xdata2', $xdata2)
                ->with('xdata3', $xdata3)
                ->with('xdata4', $xdata4)
                ->with('ydata', $ydata)
                ->with('error', $error);
        }else {
            // Ce ni napake, vrne graf
            $error = null;
            $chart = $request->chart;
            $label = $request->tabela;
            $id = $this->returnPatientID($request->zzzs_number);
            $data = $this->returnData($request->tabela, $id);

            if($request->tabela == 'Dnevni vnosi'){
                $chartVersion = 2;
                $xdata1 = $data->lists('fat');
                $xdata2 = $data->lists('calories');
                $xdata3 = $data->lists('carbohydrates');
                $xdata4 = $data->lists('protein');
                $ydata = $data->lists('date_of_visit');

            } else {
                $chartVersion = 1;
                $xdata1 = $data->lists('measurement');
                $xdata2 = null;
                $xdata3 = null;
                $xdata4 = null;
                $ydata = $data->lists('date_of_measurement');
            }

            return view('pages.chart')
                ->with('chart', $chart)
                ->with('xdata1', $xdata1)
                ->with('xdata2', $xdata2)
                ->with('xdata3', $xdata3)
                ->with('xdata4', $xdata4)
                ->with('ydata', $ydata)
                ->with('chartVersion', $chartVersion)
                ->with('error', $error);
        }
        
    }

    public function ValidationRequest($request){

        $validator = Validator::make($request->all(), [
            'chart' => 'required|max:255',
            'tabela' => 'required|max:255',
            'zzzs_number' => 'required|min:12|max:12',
        ]);

        // validate request
        if ($validator->fails()) {
            return "Napaka, preverite ZZZS številko";
        }

        return null;
    }

    public function returnPatientID( $zzzs_number ){
        $patient = DB::table('patients')->where('zzzs_number', $zzzs_number)->first();
        return $patient->id;
    }

    public function returnData($table, $id){

        $patient = Patient::findOrFail($id);

        if($table == 'Dnevni vnosi'){
            $data = $patient->getDayvisits;

        }else if($table == 'Izmjereni sladkor'){
            $data = $patient->getMeasuredsugars;
           
        }
        return $data;
    }



    

    
}
