<?php

namespace App\Http\Controllers\API\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RolesResource;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index(Request $request)
    {
        $roles = Role::all();
        return response()->json(['success'=>true,'roles'=>RolesResource::collection($roles)],200);
    }


    public function create()
    {
        $permission = Permission::all();
        return response()->json(['success'=>true,'permission'=> PermissionResource::collection($permission)],200);
    }

    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        if($validator->fails()){

            return response()->json(['success'=>false ,'message'=>$validator->errors()],200);

        }

        return response()->json($request->input('permission'));

        $role = Role::create(['name' => $request->input('name')]);

        $count = collect($request->input('permission'))->toArray()->count();

        for($i = 0 ; $i < $count ; $i++ ){
            foreach ($request->permission[$i] as $singlePermition){
                $role->syncPermissions($singlePermition['name']);

            }
        }


        return response()->json(['success'=>true,'message'=>'Role created successfully','role'=>new RolesResource($role)],200);
    }



    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return response()->json(['success'=>true,'data'=>[

            'role'  => $role,
            'allPermissionRelatedThisRole' =>$rolePermissions
        ]]);
    }


    public function update(Request $request, $id)
    {

        $validator = validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$request->id,
            'permission' => 'required',
        ]);



        if($validator->fails()){

            return response()->json(['success'=>false ,'message'=>$validator->errors()],200);

        }


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return response()->json(['success'=>true,'message'=>'Role updated successfully'],200);

    }


    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return response()->json(['success'=> true,'message' => 'Role deleted successfully'],200);
    }

}
