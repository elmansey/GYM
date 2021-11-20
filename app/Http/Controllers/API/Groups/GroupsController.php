<?php

namespace App\Http\Controllers\API\Groups;

use App\Http\Controllers\Controller;
use App\Http\Resources\groupsResource;
use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GroupsController extends Controller
{
    public function index()
    {

        $groups = Groups::all();
        return response()->json(['success' => true, 'groups' => $groups], 200);
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
