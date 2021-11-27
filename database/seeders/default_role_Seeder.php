<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        $role = Role::create([  'name'=> 'owner'  ]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);


        $role = Role::create([ 'name'=> 'admin'  ]);
        $permissions = DB::table('permissions')->whereIn('id',[ 1])->pluck('id','id')->all();
        $role->syncPermissions($permissions);


        $role = Role::create([ 'name'=> 'staff'  ]);
        $permissions = DB::table('permissions')->whereIn('id',[ 1])->pluck('id','id')->all();
        $role->syncPermissions($permissions);



    }
}
