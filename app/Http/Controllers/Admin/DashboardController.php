<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.dashboard');
    }


    // admin profile updated
    public function profileIndex()
    {
        $data = Auth::guard('admin')->user();
        return view("admin.profile", compact('data'));
    }

    public function profileUpdate(Request $request)
    {
        try {
            $admin = Auth::guard('admin')->user();
            if (!empty($request->old_password) || !empty($request->new_password) || !empty($request->confrim_password)) {
                $validator = Validator::make($request->all(), [
                    "name"             => "required",
                    "username"         => "required|unique:admins,username," . $admin->id,
                    "email"            => "required|unique:admins,email," . $admin->id,
                    "old_password"     => "required",
                    "new_password"     => "required",
                    'confirm_password' => 'required_with:new_password|same:new_password'
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    "name"     => "required",
                    "username" => "required|unique:admins,username," . $admin->id,
                    "email"    => "required|unique:admins,email," . $admin->id,
                ]);
            }

            if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);

            $data = Admin::find($admin->id);
            if (!empty($request->old_password) || !empty($request->new_password) || !empty($request->confrim_password)) {
                if (Hash::check($request->old_password, $admin->password)) {
                    $data->password = Hash::make($request->new_password);
                } else {
                    return send_error("Error message", ["old_password" => "Old password does not match"], 422);
                }
            }
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->save();
            return send_response("Admin Profile Updated", null);
        } catch (\Throwable $e) {
            return send_error("Something went wrong", $e->getMessage(), $e->getCode());
        }
    }

    public function imageUpdate(Request $request)
    {
        try {

            $admin = Auth::guard('admin')->user();

            $validator = Validator::make($request->all(), [
                "image" => "mimes:jpg,png,jpeg|dimensions:width=200,height=200"
            ], ["image.dimensions" => "Image dimension must be (200 x 200)"]);

            if ($validator->fails()) return send_error("Validation Error", $validator->errors(), 422);
            $data = Admin::find($admin->id);
            $old = $data->image;

            if (!empty($old) && isset($old)) {
                if (File::exists($old)) {
                    File::delete($old);
                }
            }
            $data->image = imageUpload($request, 'image', 'uploads/admins') ?? '';

            $data->save();
            return send_response("Image Upload successfully", null);
        } catch (\Throwable $e) {
            return send_error("Something went wrong", $e->getMessage(), $e->getCode());
        }
    }



    // admin logout
    public function Logout(Request $request)
    {
        try {
            Auth::guard('admin')->logout();
            return send_response("Admin logout successfully", null, 200);
        } catch (\Throwable $e) {
            return send_error('Something went wrong', $e->getMessage(), $e->getCode());
        }
    }
}
