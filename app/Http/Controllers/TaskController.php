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
}
