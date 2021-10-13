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


        $role = Role::create(['name' => 'owner']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);


        $ElRoles = ['owner'];

        $user = User::create([


            'name' => 'test',
            'email' => 'owner@gmail.com',
            'password' => bcrypt(123456),
            'phone' => '01019535581' ,
            'roles'  => json_encode($ElRoles)

        ]);

        $user->assignRole([$role->id]);
    }
}
