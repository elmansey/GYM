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
            'name'=>'Cardio',
            'TotalGroupMembers' => 5
        ]);
        $group  = Groups::create([
            'name'=>'Bodybuilding',
            'TotalGroupMembers' => 5
        ]);
        $group  = Groups::create([
            'name'=>'WeightLoss',
            'TotalGroupMembers' => 5
        ]);
        $group  = Groups::create([
            'name'=>'Yoga',
            'TotalGroupMembers' => 5
        ]);
        $group  = Groups::create([
            'name'=>'GeneralTraining',
            'TotalGroupMembers' => 5
        ]);



    }
}
