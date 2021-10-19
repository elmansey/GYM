<?php

namespace Database\Seeders;

use App\Models\Groups;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class groupsDefaultSeeder extends Seeder
{

    public function run()
    {
        DB::table('groups')->delete();

        $group  = Groups::create([
            'name'=>'Cardio'
        ]);
        $group  = Groups::create([
            'name'=>'Bodybuilding'
        ]);
        $group  = Groups::create([
            'name'=>'WeightLoss'
        ]);
        $group  = Groups::create([
            'name'=>'Yoga'
        ]);
        $group  = Groups::create([
            'name'=>'GeneralTraining'
        ]);



    }
}
