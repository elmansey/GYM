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
           'name'=>'golden',
            'Membership_Period' => '1month',
            'Membership_price'  => 2000

        ]);
        $memberShips  = Memberships::create([
            'name'=>'silver',
            'Membership_Period' => '1month',
            'Membership_price'  =>  1500
        ]);
        $memberShips  = Memberships::create([
            'name'=>'Platinum',
            'Membership_Period' => '1week',
            'Membership_price'  =>  1000
        ]);
        $memberShips  = Memberships::create([
            'name'=>'Normal',
            'Membership_Period' => '1week',
            'Membership_price'  =>  800
        ]);

    }
}
