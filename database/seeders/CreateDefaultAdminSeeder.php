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


        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);



        $user = User::create([

            'name' => 'test',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(123456),
            'role'  => json_encode(['Admin'])

        ]);

        $user->assignRole([$role->id]);
    }
}
