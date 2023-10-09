<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function showAdminLoginForm()
    {
        return view("auth.backend.login");
    }

    public function AdminLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "username" => "required",
                "password" => "required"
            ], ["username.required" => "Username or Email required"]);

            if ($validator->fails()) {
                return send_error("Validation Error", $validator->errors(), 422);
            }
            if (Auth::guard('admin')->attempt(credentials($request->username, $request->password))) {
                return send_response("Successfully Login", Auth::guard('admin')->user(), 200);
            } else {
                return send_error("Unauthorized", ['username' => 'Username/email not valid'], 401);
            }
        } catch (\Throwable $e) {
            return send_error("Something went wrong", $e->getMessage(), $e->getCode());
        }
    }
}
