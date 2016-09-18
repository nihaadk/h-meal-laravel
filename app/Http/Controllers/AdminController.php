<?php
namespace App\Http\Controllers;


use App\User;
use App\Role;
use App\Task;
use App\Permission;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;


class AdminController extends Controller
{
    /*
     *
     * Return List all Users
     *
     * */
    public function index(Request $request)
    {   
        return view('pages.welcome');
    }

    /*
     *
     * Query for Search
     *
     * */
    public function showUserList(Request $request)
    {
        if(Auth::check())
        {
            $query = $request->search;
            if($query){   
                $users = DB::table('users')->where('name', $query)->get();
                return view('pages.user_list',['Users' => $users, 'list' => $this->returnUserList()]);
            }else{
                $users = User::all();
                return view('pages.user_list',['Users' => $users, 'list' => $this->returnUserList()]);
            }
        }else{
            return redirect()->to('/');
        }
    }

   
    public function addUser(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // validate request
        if ($validator->fails()) {
            return redirect('app/user/list')
                        ->withErrors($validator)
                        ->withInput();
        }
       
        // create new User, Role, Permission
        $user = new User;
        $role = new Role;
        $permission = new Permission;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        
        if($request->role == "user"){


            $role->name = 'user';
            $role->label = 'user';
            $role->save();

            $permission->name = 'user';
            $permission->label = 'user';
            $permission->save();

            // connect role_id and permission_id
            $role->givePermissionTo($permission);

            // connect role_id and user_id
            $user->roles()->save($role);    
        }

        if($request->role == "admin"){
            
            $role->name = 'admin';
            $role->label = 'admin';
            $role->save();

            $permission->name = 'admin';
            $permission->label = 'admin';
            $permission->save();

            // connect role_id and permission_id
            $role->givePermissionTo($permission);
            
            // connect role_id and user_id
            $user->roles()->save($role); 
        }
        
        return redirect('app/user/list');        
    }

   
    public function destroy($id)
    {
        $tasks = Task::all();
        $user = User::findOrFail($id);
        
        foreach ($tasks as $task) {
            if($user->name == $task->author){
                $task->delete();
            }
        }

        $user->delete();

        return redirect()->to('app/user/list');
    }


    public function update($id, Request $request){

        $user = User::findOrFail($id);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return redirect('app/user/list');
    }

    public function returnUserList(){
        $allPatients = User::all();
        $arrayOfPatients = array_pluck($allPatients, 'name');
        $listOfPatients = join(',', $arrayOfPatients);
        return $listOfPatients;
    }




    
}
