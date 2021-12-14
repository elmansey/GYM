<?php

namespace App\Http\Controllers\API\Groups;

use Carbon\Carbon;
use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\groupsResource;
use Illuminate\Support\Facades\Validator;
use App\Http\helperMe\addActivetyLogInHistory;

class GroupsController extends Controller
{

    use addActivetyLogInHistory;


    public function index()
    {

        $groups = Groups::all();
        return response()->json(['success' => true, 'groups' => groupsResource::collection($groups)], 200);
    }

    public function store(Request $request)
    {


        $validator = validator::make($request->all(), [
            'name' => 'required|max:25|unique:groups,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => '400'], 200);
        }

        $group = $request->all();
        $group = Groups::create($group);


        //save logs
        $userId = auth()->user()->id;
        $title  = 'has added a new group ';
        $date = Carbon::now('Africa/Cairo')->format('D, M, d Y H:i:s A');
        $this->saveLogs($userId, $title, $date);

        return  response()->json(['success' => true, 'group' => $group], 200);
    }

    public function getGroupsById($id)
    {

        $group =  Groups::find($id);

        return response()->json(['success' => true, 'group' => new  groupsResource($group)]);
    }

    public function update(Request $request, $id)
    {

        $validator = validator::make($request->all(), [
            'name' => ['required', 'max:25', Rule::unique('groups')->ignore($id)],

        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => '400'], 200);
        }


        $group = Groups::find($id);
        $group->update($request->all());


        return  response()->json(['success' => true, 'group' => $group], 200);
    }

    public function destroy($id)
    {

        $group = Groups::find($id);
        $group->delete();
        return response()->json(['success' => true], 200);
    }
}
