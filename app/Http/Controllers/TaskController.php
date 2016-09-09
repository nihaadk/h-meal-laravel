<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\User;

class TaskController extends Controller
{
    public function index(){

        $tasks = Task::all();
        $userList = User::lists('name', 'id');

        return view('pages.welcome')
            ->with('userList', $userList)
            ->with('tasks', $tasks);
    }
    
    public function create(Request $request)
    {
        $task = new Task();
        
        $author = User::find($request->user_id);
        $task->author = $author->name;
        $task->description = $request->description;
        $task->created_at = $request->created_at;
        
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


    public function filter(Request $request){

        // from database
        $userList = User::lists('name', 'id');
        $tasks = Task::all();

        // from request
        $to = $this->changeDataFormat($request->to_date);
        $from = $this->changeDataFormat($request->from_date);
        $user = User::find($request->user_id);
        $author = $user->name;

        if( $to != null && $from != null && $author != null ){

            $filterTasks = collect([]);

            foreach ($tasks as $t) {  
                
                if( $t->author == $author && $this->dateFilter($t->created_at->format('Y-m-d'),$from,$to)){
                        $filterTasks->push($t);
                }
            }

            if( $filterTasks != null){
                return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('tasks', $filterTasks);
            }

            return view('pages.welcome')
                    ->with('userList', $userList)
                    ->with('tasks', $tasks);
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
