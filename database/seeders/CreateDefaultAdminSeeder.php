<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateDefaultAdminSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();


        $role = Role::create([ 'guard_name' => 'admin', 'name'=> 'owner'  ]);
        $permissions = Permission::where(['guard_name' => 'admin'])->pluck('id','id')->all();
        $role->syncPermissions($permissions);




        $user = User::create([


            'name' => 'test',
            'user_name' => 'user test',
            'email' => 'owner@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581' ,


        ]);

        $user->assignRole($role->name);

    }
}
