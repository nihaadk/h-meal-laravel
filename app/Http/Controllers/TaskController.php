<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\User;
use App\Patient;
use Auth;

class TaskController extends Controller
{
    public function index(){

        $tasks = Task::all();
        $userList = [''=>''] + User::lists('name', 'id')->all();
        $patientList = [''=>''] + Patient::lists('last_name', 'id')->all();



        return view('pages.welcome')
            ->with('patientList', $patientList)
            ->with('userList', $userList)
            ->with('tasks', $tasks);
    }

    public function create(Request $request)
    {
        $task = new Task();
        
        $task->author = Auth::user()->name;
        $task->patient_id = $request->patient_id;
        $task->title = $request->title; 
        $task->description = $request->description;
        
        $task->save();

        return redirect()->back();
    }
    
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back();
    }

    public function update($id, Request $request){

        $task = Task::findOrFail($id);
        $task->description = $request->description;
        $task->author = Auth::user()->name;
        $task->save();

        return redirect()->back();
    }

    public function dateFilter($task, $from , $to){

        $taskN = (int)str_replace("-","",$task);
        $fromN = (int)str_replace("-","",$from);
        $toN = (int)str_replace("-","",$to);

        if($taskN >= $fromN && $taskN <= $toN){
            return true;
        }
        
        return false;
    }

    public function numberOfFilterAntributs($to, $from, $p_id, $a_name){

        // bolnik
        if($p_id != null && $to == null && $from == null && $a_name == null){
            return '1';
        }

        // author
        if($p_id == "" && $to == null && $from == null && $a_name != null){
            return '2';
        }

        // date
        if($p_id == "" && $to != null && $from != null && $a_name == null){
            return '3';
        }

        // bolnik in author
        if($p_id != "" && $to == null && $from == null && $a_name != null){
            return '4';
        }

        // bolnik in date 
        if($p_id != "" && $to != null && $from != null && $a_name == null){
            return '5';
        }

        // author in date
        if($p_id == "" && $to != null && $from != null && $a_name != null){
            return '6';
        }

        if($p_id != "" && $to != null && $from != null && $a_name != null){
            return '7';
        }

        return '0';
    }

    public function filter(Request $request){

        // from database
        $userList = [''=>''] + User::lists('name', 'id')->all();
        $patientList = [''=>''] + Patient::lists('last_name', 'id')->all();
        $tasks = Task::all();
        $patients = Patient::all();

        // from request
        $to = $this->changeDataFormat($request->to_date);
        $from = $this->changeDataFormat($request->from_date);
        $patient_id = $request->patient_id;
        $author = User::find($request->user_id);

        //dd($to, $from, $patient_id, $author);

        $filterTasks = collect([]);
        $combination = $this->numberOfFilterAntributs($to, $from, $patient_id, $author);

        //dd($this->numberOfFilterAntributs($to, $from, $patient_id, $author));

        switch ($combination) {
            case '0':
                // no filter
                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('tasks', $tasks);
                
                break;
            case '1':
                // bolnik
                foreach ($tasks as $t) {  
                    if( $t->patient_id == $patient_id){
                            $filterTasks->push($t);
                    }
                }

                $author = null;
                $from = null;
                $to = null;

                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('patient_id', $patient_id)
                    ->with('author', $author)
                    ->with('dateFrom', $from)
                    ->with('dateTo', $to)
                    ->with('tasks', $filterTasks);

                break;
            case '2':
                // author
                foreach ($tasks as $t) {  
                    if( $t->author == $author->name){
                            $filterTasks->push($t);
                    }
                }

                $patient_id = null;
                $from = null;
                $to = null;

                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('patient_id', $patient_id)
                    ->with('author', $author)
                    ->with('dateFrom', $from)
                    ->with('dateTo', $to)
                    ->with('tasks', $filterTasks);

                break;
            case '3':
                // date
                foreach ($tasks as $t) {  
                    if( $this->dateFilter($t->created_at->format('Y-m-d'),$from,$to)){
                            $filterTasks->push($t);
                    }
                }

                $patient_id = null;
                $author = null;    

                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('patient_id', $patient_id)
                    ->with('author', $author)
                    ->with('dateFrom', $from)
                    ->with('dateTo', $to)
                    ->with('tasks', $filterTasks);
                
                break;
            case '4':
                // bolnik author
                foreach ($tasks as $t) {  
                    if( $t->author == $author->name && $t->patient_id == $patient_id){
                            $filterTasks->push($t);
                    }
                }

                $from = null;
                $to = null;   

                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('patient_id', $patient_id)
                    ->with('author', $author)
                    ->with('dateFrom', $from)
                    ->with('dateTo', $to)
                    ->with('tasks', $filterTasks);
                
                break;
            case '5':
                // bolnik date
                foreach ($tasks as $t) {  
                    if( $t->patient_id == $patient_id && $this->dateFilter($t->created_at->format('Y-m-d'),$from,$to)){
                            $filterTasks->push($t);
                    }
                }

                $patient_id = null;

                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('patient_id', $patient_id)
                    ->with('author', $author)
                    ->with('dateFrom', $from)
                    ->with('dateTo', $to)
                    ->with('tasks', $filterTasks);
                
                break;
            case '6':
                // author date
                foreach ($tasks as $t) {  
                    if( $t->author == $author->name && $this->dateFilter($t->created_at->format('Y-m-d'),$from,$to)){
                            $filterTasks->push($t);
                    }
                }

                $patient_id = null;

                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('patient_id', $patient_id)
                    ->with('author', $author)
                    ->with('dateFrom', $from)
                    ->with('dateTo', $to)
                    ->with('tasks', $filterTasks);
                break;

                case '7':
                // all
                foreach ($tasks as $t) {  
                    if( $t->patient_id == $patient_id && $t->author == $author->name && $this->dateFilter($t->created_at->format('Y-m-d'),$from,$to)){
                            $filterTasks->push($t);
                    }
                }

                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('patientList', $patientList)
                    ->with('patient_id', $patient_id)
                    ->with('author', $author)
                    ->with('dateFrom', $from)
                    ->with('dateTo', $to)
                    ->with('tasks', $filterTasks);
                    
                break;
        }

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
