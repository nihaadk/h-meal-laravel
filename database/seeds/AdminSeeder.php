<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\Permission;
use App\User;
use App\Patient;

class AdminSeeder extends Seeder
{

    public function run()
    {
        Model::unguard();

        // create new ADMIN User, Role, Permission
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

        // create new NORMAL User, Role, Permission
        $user1 = new User;
        $role1 = new Role;
        $permission1 = new Permission;

        $user1->name = "Nurse";
        $user1->email = "nurse@test.com";
        $user1->password = bcrypt("123456");
        $user1->save();


        $role1->name = 'user';
        $role1->label = 'user';
        $role1->save();

        $permission1->name = 'user';
        $permission1->label = 'user';
        $permission1->save();

        // connect role_id and permission_id
        $role1->givePermissionTo($permission);

        // connect role_id and user_id
        $user1->roles()->save($role);


        $patient = new Patient;

        $patient->first_name = 'Marko';
        $patient->last_name = 'Rojnik';
        $patient->address = 'Ulica celje';
        $patient->date = '1981-03-27';
        $patient->zzzs_number = '050253390666';
        $patient->save();

        $patient1 = new Patient;

        $patient1->first_name = 'Emir';
        $patient1->last_name = 'Kepic';
        $patient1->address = 'Ulica ljubljana';
        $patient1->date = '1967-08-03';
        $patient1->zzzs_number = '053251190333';
        $patient1->save();
        
        
    }
}
