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

        $role = Role::create(['name' => 'owner']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);


        $role = Role::create(['name' => 'admin']);
        $permissions = DB::table('permissions')->whereIn('id', [1, 22, 23, 24, 25, 26, 29, 35, 37, 40, 42, 43, 44, 45, 47, 52, 55, 57, 58])->pluck('id', 'id')->all();
        $role->syncPermissions($permissions);


        $role = Role::create(['name' => 'staff']);
        $permissions = DB::table('permissions')->whereIn('id', [1, 22, 23, 24, 25, 26, 29, 35, 37, 40, 42, 43, 44, 45, 47, 52, 55, 57, 58])->pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
    }
}
