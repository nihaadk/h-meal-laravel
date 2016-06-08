<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create new User, Role, Permission
        $user = new User;
        $role = new Role;
        $permission = new Permission;

        $user->name = "Start";
        $user->email = "admin@test.com";
        $user->password = bcrypt("123456");
        $user->save();


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
}
