<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->route('admin');
        }
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->route('dashboard', ['RolePrefix' => Auth::user()->roles->pluck('name')[0]]);
        }
        return redirect()->route('/')->with('error', '!Invalid Credential');
    }


    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            auth()->guard('admin')->logout();
            return redirect()->route('/');
        }
        if (Auth::guard('user')->check()) {
            auth()->guard('user')->logout();
            return redirect()->route('/');
        }
        return redirect()->route('/');
    }
}
