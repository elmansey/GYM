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
         $role = Role::create([ 'guard_name' => 'staff', 'name'=> 'staff'  ]);
        $permissions = Permission::where(['guard_name' =>'staff','name' => 'dashboard'])->pluck('id','id')->all();
        $role->syncPermissions($permissions);
    }
}
