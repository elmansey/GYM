<?php

namespace Database\Seeders;

use App\Models\Memberships;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class membershipsDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->delete();

        $memberShips  = Memberships::create([
           'name'=>'golden'
        ]);
        $memberShips  = Memberships::create([
            'name'=>'silver'
        ]);
        $memberShips  = Memberships::create([
            'name'=>'Platinum'
        ]);
        $memberShips  = Memberships::create([
            'name'=>'Normal'
        ]);

    }
}
