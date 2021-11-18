<?php

namespace App\Http\Controllers\API\statistics;

use App\Models\Memberships;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\members_extra_information;

class statisticsController extends Controller
{
    public function index(){

        $membership = Memberships::all();
        $membershipsMemberNumber = [];

        foreach ($membership as $k => $v){


            $membershipsMemberNumber[] = [ $v['name'] => count(members_extra_information::where('membership_id','=',$v['id'])->get())];
        }

        return response()->json(['success' => true, 'MembershipsStatistics' => $membershipsMemberNumber]);


    }
}
