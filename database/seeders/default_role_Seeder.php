<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class default_role_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create([  'name'=> 'admin'  ]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

         $role = Role::create([ 'name'=> 'staff'  ]);
        $permissions = Permission::where(['name'=>[ 'dashboard','show-chat-rooms','show-class-chat']])->pluck('id','id')->all();
        $role->syncPermissions($permissions);

         $role = Role::create([ 'name'=> 'member'  ]);
        $permissions = Permission::where(['name'=>[ 'dashboard','show-chat-rooms','show-class-chat']])->pluck('id','id')->all();
        $role->syncPermissions($permissions);

    }
}
