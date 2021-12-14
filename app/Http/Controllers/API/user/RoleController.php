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
use App\Models\model_has_permissions;
use App\Models\User;

class RoleController extends Controller
{


    //    public function __construct()
    //    {
    //
    //    }


    public function index(Request $request)
    {
        $roles = Role::where('name', '!=', 'owner')->get();
        $permission = [];


        foreach ($roles as $k => $v) {

            $permission[] = ['id' => $v->id, 'role' => $v->name, 'permission' => PermissionResource::collection(Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_has_permissions.role_id', $v->id)->get())];
        }

        return response()->json(['success' => true, 'RoleAndPermission' => $permission], 200);
    }


    public function getAllUserToCustomPermission()
    {

        $users =  User::role(['staff', 'admin'])->select('name', 'id')->get();

        return response()->json(['success' => true, 'users' => $users]);
    }

    public function create()
    {



        $permission = Permission::all();


        return response()->json(['success' => true, 'permission' => PermissionResource::collection($permission)], 200);
    }


    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()], 200);
        }



        $role = Role::create(['name' => $request->input('name')]);


        $per = $request->input('permission');
        $permission = [];
        foreach ($per as $k => $v) {

            $permission[] =  $v['name'];
        }

        $role->syncPermissions($permission);

        return response()->json(['success' => true, 'message' => 'Role created successfully', 'role' => new RolesResource($role), 'permission' => $permission], 200);
    }



    public function getRoleById($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return response()->json(['success' => true, 'data' => [

            'role'  => $role,
            'allPermissionRelatedThisRole' => PermissionResource::collection($rolePermissions)
        ]]);
    }


    public function update(Request $request)
    {

        $validator = validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $request->id,
            'permission' => 'required',
        ]);



        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()], 200);
        }


        $role = Role::find($request->id);
        $role->name = $request->input('name');
        $role->save();

        $per = $request->input('permission');
        $permission = [];
        foreach ($per as $k => $v) {

            $permission[] =  $v['name'];
        }

        $role->syncPermissions($permission);

        return response()->json(['success' => true, 'message' => 'Role Updated successfully', 'role' => new RolesResource($role), 'permission' => $permission], 200);
    }


    public function destroy($id)
    {


        $role = Role::find($id);
        $role->delete();
        return response()->json(['success' => true, 'message' => 'Role deleted successfully'], 200);
    }


    public function getOldCustomPermission($id)
    {

        $oldPermission = model_has_permissions::with('permissionRelassion')->where('model_id', '=', $id)->get();

        return response()->json(['success' => true, 'oldPermission' => $oldPermission]);
    }

    public function assignCustomPermissions(Request $request)
    {

        $request['user'] = json_decode($request['user'], true);
        $request['permissions'] = json_decode($request['permissions'], true);


        $user = User::find($request->user['id']);
        $user->syncPermissions($request->permissions);

        return response()->json(['success' => true, 'user' => $user]);
    }
}
