<?php

namespace App\Http\Controllers\API\user;

use QRCode;
use App\Models\User;
use Faker\Core\File;
use http\Env\Response;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResource;
use App\Http\Resources\UsersResource;
use Spatie\Permission\Models\Permission;
use App\Models\members_extra_information;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserToRoleResource;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $data = User::role('admin')->get();
        return response()->json(['success' => true, 'admins' => UsersResource::collection($data)], 200);
    }



    public function getUserToChatIgnoreMe($email)
    {

        $data = User::role(['staff', 'admin', 'owner'])
            ->where('email', '!=', $email)
            ->with('messageTeamRelationTo', function ($query) {

                $query->where('to', '=', auth()->user()->id)
                    ->where('read', '=', false);
            })
            ->get();



        return response()->json(['success' => true, 'admins' => UsersResource::collection($data)], 200);
    }




    public function getAllPersonToAttendance()
    {

        $users = User::role(['admin','staff'])->select('name', 'RF_code')->get();
        $members = members_extra_information::select('name', 'RF_code')->get();

        $users =  array_merge(($users)->toArray(), ($members)->toArray());


        return response()->json(['success' => true, 'users' => $users], 200);
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'owner')->get();


        return response()->json(['success' => true, 'roles' => RolesResource::collection($roles)], 200);
    }


    public function store(Request $request)
    {



        $request['role'] = json_decode($request['role'], true);


        $validator = validator::make($request->all(), [
            'name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required',
            'role' => 'required',
            'isActive' => 'required',

        ]);




        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()], 200);
        }



        try {

            DB::beginTransaction();
            if ($request->file('profile_picture')) {

                $file = $request->file('profile_picture');
                $extension = $file->extension();

                $fileName = md5(time() . now() . rand(1, 10)) . '.' . $extension;

                $file->move('profile_pictures/', $fileName);
            }
            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
        }


        $input = $request->all();
        $input['password']  = bcrypt($input['password']);
        $input['profile_picture'] = $input['profile_picture'] ? $fileName : null;
        $input['isActive'] =  $input['isActive'] == 'true' || true || 1 || '1' ? true : false;




        $user =  User::create($input);

        $role = [];


        foreach ($request['role'] as $k => $v) {

            $role[] = $v['name'];
        }


        $user->assignRole($role); // بيحطها في جدول الرل

        $dataQR =  $user['Personal_uuid'];
        $QRName = 'profile_QR/' . md5($user['Personal_uuid']) . '.png';
        $qr =  QRCode::text($dataQR)->setOutfile(($QRName))->png();
        $update = User::find($user->id);
        $update->update(['qr_code' =>  $QRName]);



        return response()->json(['success' => true, 'message' => 'User created successfully', 'user' => new UsersResource($user)], 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['success' => true, 'user' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $input['role'] = json_decode($input['role'], true);

        if ($input['password']) {

            $required = true;
        } else {

            $required = false;
        }

        $validator = validator::make($request->all(), [
            'name'     => 'required',
            'user_name' => 'required',
            'email'    => 'required', 'email|unique:users,' . $id,
            'phone' => 'required',
            'password' => 'same:confirm_password',
            'confirm_password' => Rule::requiredIf($required),
            'role' => 'required',
            'isActive' => 'required'

        ]);



        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()], 200);
        }



        if ($request->file('profile_picture')) {

            $oldImg = User::where('id', '=', $id)->pluck('profile_picture');

            $path =  public_path('profile_pictures\\' . $oldImg[0]);
            if ($oldImg[0]) {
                if (file_exists($path)) {

                    unlink($path);
                }
            }


            $file = $request->file('profile_picture');
            $extension = $file->extension();

            $fileName = md5(time() . now() . rand(1, 10)) . '.' . $extension;

            $file->move('profile_pictures/', $fileName);

            $input['profile_picture'] = $input['profile_picture'] ? $fileName : null;
        } else {
            $input =  Arr::except($input, array('profile_picture'));
        }




        if (!empty($input['password'])) {

            $input['password'] = bcrypt($input['password']);
        } else {

            $input = Arr::except($input, array('password'));
        }
        $input['isActive'] =  $input['isActive'] == 'true' || true || 1 || '1' ? true : false;
        $user = User::find($id);
        $user->update($input);

        DB::table('model_has_roles')->where([['model_id', '=', $id], ['model_type', '=', 'APP\Models\User']])->delete();

        $role = [];

        foreach ($input['role'] as $k => $v) {

            $role[] = $v['name'];
        }
        $user->assignRole($role);

        return response()->json(['success' => true, 'message' => 'updated successfully', 'user' => new UsersResource($user)], 200);
    }


    public function getUserById($id)
    {

        $user = User::find($id);
        $roles = RolesResource::collection($user['roles']);

        $role = [];


        return response()->json(['success' => true, 'data' =>  new UserToRoleResource($user), 'role' => RolesResource::collection($roles)], 200);
    }


    public function updateProfileInfo(Request $request, $id)
    {

        $input = $request->all();



        $validator = validator::make($request->all(), [
            'name'     => 'required',
            'user_name' => 'required',
            'email'    => 'required', 'email|unique:users,' . $id,
            'phone' => 'required',

        ]);



        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()], 200);
        }

        if (isset($input['password']) && isset($input['confirm_Password'])) {

            if ($input['password'] != $input['confirm_Password']) {

                return response()->json(['success' => false, 'message' => ['confirm_Password' => 'the confirm password felid must same password felid']]);
            }
        }



        if ($request->file('profile_picture')) {

            $oldImg = User::where('id', '=', $id)->pluck('profile_picture');

            $path =  'profile_pictures\\' . $oldImg[0];
            if ($oldImg[0]) {
                if (file_exists($path)) {

                    unlink($path);
                }
            }


            $file = $request->file('profile_picture');
            $extension = $file->extension();

            $fileName = md5(time() . now() . rand(1, 10)) . '.' . $extension;

            $file->move('profile_pictures/', $fileName);

            $input['profile_picture'] = $input['profile_picture'] ? $fileName : null;
        } else {
            $input =  Arr::except($input, array('profile_picture'));
        }




        if (!empty($input['password'])) {

            $input['password'] = bcrypt($input['password']);
        } else {

            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);

        return response()->json(['success' => true, 'message' => 'updated successfully', 'user' => new UsersResource($user)], 200);
    }

    public function destroy($id)
    {
        $oldImg = User::where('id', '=', $id)->pluck('profile_picture');

        $path =  public_path('profile_pictures\\' . $oldImg[0]);
        if ($oldImg[0]) {
            if (file_exists($path)) {

                unlink($path);
            }
        }
        $user =  User::find($id);
        $user->delete();
        return response()->json(['success' => true, 'message' => 'deleted successfully'], 200);
    }
}
