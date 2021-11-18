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
            'Membership_price'  => 2000,
            'Membership_private_Features' => true

        ]);

        $memberShips  = Memberships::create([
            'name'=>'Normal',
            'Membership_Period' => '1week',
            'Membership_price'  =>  800,
            'Membership_private_Features' => false

        ]);

    }
}
