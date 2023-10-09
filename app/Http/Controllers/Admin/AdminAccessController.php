<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\AdminAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->role->name != 'SuperAdmin') {
            $access = AdminAccess::where('admin_id', Auth::guard('admin')->user()->id)
                ->pluck('permissions')
                ->toArray();
            if (!in_array("userEntry", $access)) {
                return view("admin.unauthorize");
            }
        }

        $roles = Role::latest()->get();

        return view("admin.user.create", compact('roles'));
    }

    public function index($id = null)
    {
        if ($id == null) {
            if (Auth::guard('admin')->user()->role->name == 'SuperAdmin') {
                $data = Admin::where([["id", "!=", 1], ["id", "!=", Auth::guard('admin')->user()->id]])->with('role')->latest()->get();
            } else {
                $data = Admin::where("id", "!=", 1)->with('role')->latest()->get();
            }
        } else {
            $data = Admin::where("id", $id)->with('role')->first();
        }
        return send_response("User Data", $data, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:3|max:30',
            'username' => 'required|string|min:3|max:20|unique:admins',
            'email'    => 'required|email:rfc,dns|unique:admins',
            'role_id'  => 'required',
            'image'    => 'nullable|mimes:jpeg,png,jpg,gif',
            'password' => 'required|min:5|max:20',
        ]);

        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);

        try {
            $data           = new Admin();
            $data->name     = $request->name;
            $data->username = $request->username;
            $data->email    = $request->email;
            $data->role_id  = $request->role_id;
            $data->password = Hash::make($request->password);
            if ($request->hasFile('image')) {
                $data->image    = $this->imageUpload($request, 'image', 'uploads/admins');
            }
            $data->save();

            return send_response("Yea! User Added Successfully", null);
        } catch (\Exception $e) {
            return send_error("Something went wrong", $e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|min:3|max:30',
            'username' => 'required|string|min:3|max:20|unique:admins,username,' . $request->id,
            'email'    => 'required|email:rfc,dns|unique:admins,email,' . $request->id,
            'role_id'     => 'required',
        ]);

        if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);

        try {
            $data = Admin::find($request->id);

            $data->name     = $request->name;
            $data->username = $request->username;
            $data->email    = $request->email;
            $data->role_id     = $request->role_id;
            if ($request->role_id == 1) {
                AdminAccess::where('admin_id', $request->id)->delete();
            }
            if (!empty($request->password)) {
                $data->password = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {
                if (File::exists($data->image)) {
                    File::delete($data->image);
                }
                $data->image    = $this->imageUpload($request, 'image', 'uploads/admins');
            }
            $data->update();

            return send_response("Yea! User Updated Successfully", null);
        } catch (\Exception $e) {
            return send_error("Something went wrong", $e->getMessage(), $e->getCode());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = Admin::find($request->id);
            if (File::exists($data->image)) {
                File::delete($data->image);
            }
            $data->delete();
            return send_response("User Delete successfully", null);
        } catch (\Throwable $e) {
            return send_error("Something went wrong", $e->getMessage(), $e->getCode());
        }
    }

    // permission edit
    public function permissionEdit($id)
    {
        $user = Admin::find($id);

        if (Auth::guard('admin')->user()->role->name != 'SuperAdmin') {
            if (empty($user)) {
                return back();
            } else if ($user->id == 1) {
                return back();
            }

            $accesss = AdminAccess::where('admin_id', Auth::guard('admin')->user()->id)
                ->pluck('permissions')
                ->toArray();
            if (!in_array("userAccess", $accesss)) {
                return view("admin.unauthorize");
            }
        }

        $userAccess = AdminAccess::where('admin_id', $id)->pluck('permissions')->toArray();
        $access = AdminAccess::where('admin_id', $id)->get();
        $groups = Permission::groupBy('group_name')->orderBy('id', 'asc')->get();
        foreach ($groups as $key => $item) {
            $item->permissionArr = Permission::where('group_name', $item->group_name)->get();
        }

        return view('admin.user.useraccess', compact('user', 'access', 'userAccess', 'groups'));
    }

    public function permissionStore(Request $request)
    {
        try {
            $admin = Admin::find($request->admin_id);
            if ($admin->role == 'SuperAdmin') {
                return redirect()->route('admin.manager.create')->with('error', 'This user super admin already');
            }
            AdminAccess::where('admin_id', $request->admin_id)->delete();
            $permissions = Permission::all();

            if (empty($request->permissions)) {
                return redirect()->route('admin.user.create')->with('error', 'Permissions remove all');
            }
            foreach ($permissions as $value) {
                if (in_array($value->id, $request->permissions)) {
                    AdminAccess::create([
                        'admin_id'    => $request->admin_id,
                        'group_name'  => $value->group_name,
                        'permissions' => $value->permission,
                    ]);
                }
            }

            return redirect()->route('admin.user.create')->with('success', 'Permissions added successfullly');
        } catch (\Throwable $e) {
            return redirect()->route('admin.user.create')->with('error', $e->getMessage());
        }
    }
}
