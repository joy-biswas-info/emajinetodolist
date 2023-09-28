<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return View('admin.user.index', compact('users'));
    }
    public function distroy($id, Request $request)
    {

        $user = User::find($id);
        if (empty($user)) {
            return back()->withErrors('error', 'No user exist');
        } else {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'User deleted');
        }

    }
}