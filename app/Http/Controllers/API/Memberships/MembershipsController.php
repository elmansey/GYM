<?php

namespace App\Http\Controllers\API\Memberships;

use Carbon\Carbon;
use http\Env\Response;
use App\Models\Memberships;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MembershipsRersource;
use App\Http\helperMe\addActivetyLogInHistory;

class MembershipsController extends Controller
{

    use addActivetyLogInHistory;

    public function index()
    {

        $memberShips = Memberships::all();
        return response()->json(['success' => true, 'memberships' => $memberShips], 200);
    }

    public function store(Request $request)
    {


        $validator = validator::make($request->all(), [
            'name' => 'required|max:25|unique:memberships,name',
            'payment' => 'required',
            'Membership_price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => '400'], 200);
        }

        $membership = $request->all();
        $membership['Membership_private_Features'] = $request['Membership_private_Features'] == 'true' ? true : false;

        $membership = Memberships::create($membership);


         //save logs
         $userId = auth()->user()->id;
         $title  = 'has added a new membership ';
         $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
         $this->saveLogs($userId,$title,$date);


        return  response()->json(['success' => true, 'membership' =>new  MembershipsRersource($membership) ], 200);
    }

    public function getMembershipsById($id)
    {

        $membership = Memberships::find($id);

        return response()->json(['success' => true, 'membership' => new  MembershipsRersource($membership)]);
    }

    public function update(Request $request, $id)
    {

        $validator = validator::make($request->all(), [
            'name' => ['required', 'max:25', Rule::unique('memberships')->ignore($id)],
            'payment' => 'required',
            'Membership_price' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => '400'], 200);
        }



        $membership = Memberships::find($id);
        $request['Membership_private_Features'] = $request['Membership_private_Features'] == 'true' || '1' || 1 ? true : false;
        $membership->update($request->all());


        return  response()->json(['success' => true, 'membership' => new  MembershipsRersource($membership)], 200);
    }

    public function destroy($id)
    {

        $membership = Memberships::find($id);
        $membership->delete();
        return response()->json(['success' => true], 200);
    }


    public function IsAllowFuatureInThisMembership($id){

        $membership = Memberships::where('id','=',$id)->first();


        $allow =  $membership['Membership_private_Features'] == true ? true : false ;

         return response()->json(['success' => true , 'memberShip' => $membership,'allow' => $allow],200);

    }



}
