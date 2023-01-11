<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminPermission;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
   public function index()
   {
      return view('admin/index');
   }
   public function permission()
   {
      $check = AdminPermission::first();
      return view('admin/permission',get_defined_vars());
   }
   public function permission_store(Request $request)
   {
      $check = AdminPermission::first();
      if ($check) {
         $response =  AdminPermission::where('id', '1')->update($request['key']);
      } else {
         $response = AdminPermission::insert($request['key']);
      }
   
      return redirect()->back()->with('success', 'Permission Update Successfully');
   }
}
