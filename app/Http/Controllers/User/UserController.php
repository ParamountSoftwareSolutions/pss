<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        // $role = Role::create(['guard_name' => 'user','name' => 'property_admin']);
        // $role = Role::create(['guard_name' => 'user','name' => 'employee']);
        // $role = Role::create(['guard_name' => 'user','name' => 'property_manager']);
        // // $role =  Role::where('id','16')->get();
        // // $user =  User::where('id','1')->first();
        // // $role9 = Role::create(['name' => 'property_manager', 'guard_name' => 'web']);
        // $user = \App\Models\User::create([
        //     'name' => 'property manger',
        //     'email' => 'property_manger@demo.com',
        //     'password' => Hash::make(12345678),
        // ]);
        // $user->assignRole($role);
   
        return view('user.index');
    }
}
