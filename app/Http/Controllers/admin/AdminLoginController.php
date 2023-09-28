<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return View('admin.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

                $admin = Auth::guard('admin')->user();
                if ($admin->role == 3) {
                    return redirect()->route('admin.dashboard');
                } else {
                    $admin = Auth::guard('admin')->logout();
                    return redirect()->route('login')->with('error', 'You are not an admin');
                }

            } else {
                return back()->with('errors', 'Wrong credentials');

            }
            ;
        } else {

            return back()->with('errors', 'Wrong credentials');
        }

    }
}