<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\Project_assign_user;
use App\Models\Project;
use App\Models\User;
use App\Models\EmployeePayroll;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index()
    {
        //$building = Helpers::custom_building_detail();
        //$employee_list = Employee::whereIn('building_id', $building->pluck('id')->toArray())->get()->pluck('user_id')->toArray();
        $employee = User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['sale_person', 'office_staff', 'accountant']);
            })->get();
        //->whereIn('id', $employee_list)->get();
        return view('user.employee.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        //$building = Helpers::custom_building_detail();
        $job = JobTitle::get();
        $sale_manager = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->Where('name', 'sale_manager');
            })
            //->where('property_admin_id', Helpers::user_admin())
            ->get();
        $projects = Project::all();
        return view('user.employee.create', compact('sale_manager', 'job', 'projects'));
    }
    public function getSaleManagers()
    {
        $sale_manager = User::where('project', request('project_id'))->with('roles')
            ->whereHas('roles', function ($q) {
                $q->Where('name', 'sale_manager');
            })
            //->where('property_admin_id', Helpers::user_admin())
            ->get();
        return response()->json(['sale_manager' => $sale_manager]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'cnic' => 'required|unique:users,cnic',
            'job_title' => 'required',
            'phone_number' => 'required|unique:users,phone_number',
            'working_days' => 'required|max:31'
        ]);
        if ($request->job_title == 'sale_person') {
            $request->validate([
                'sale_manager_id' => 'required',
            ]);
        }
        
        $employee = new User();
        $employee->name = $request->name;
        $employee->email = $request->email;
        if ($request->password == null) {
            $employee->password = Hash::make(12345678);
        } else {
            $employee->password = Hash::make($request->password);
        }
        $employee->phone_number = $request->phone_number;
        $employee->cnic = $request->cnic;
        $employee->project = $request->building_id;
        $employee->sale_manager_id = $request->sale_manager_id;
        $employee->cnic = $request->cnic;
        $employee->address = $request->address;
        $employee->account_no = $request->account_no;
        $employee->salary = $request->salary;
        $employee->commission = $request->commission;
        //picture
        if ($request->file('document')) {
            $document = $request->file('document');
            $document_name = hexdec(uniqid()) . '.' . strtolower($document->getClientOriginalExtension());
            $document->move('public/images/employee/', $document_name);
            $employee->document = asset('public/images/employee/' . $document_name);
        }
        $employee->save();
        $payroll = new EmployeePayroll();
        $payroll->name = $employee->name;
        $payroll->working_days = $request->working_days;
        $payroll->user_id = $employee->id;
        $payroll->amount = $employee->salary;
        $payroll->save();
        Project_assign_user::create([
            'user_id' => $employee->id,
            'project_id' => $request->building_id,
        ]);
        $employee->assignRole($request->job_title);
        if ($employee) {
            //NotificationHelper::web_panel_notification('employee_create', 'employee_id', 'employee', $employee->id);
            return redirect()->route('employee.index', ['RolePrefix' => RolePrefix()])->with($this->message('Employee Create Successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Employee Create Error', 'danger'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        //$building = Helpers::custom_building_detail();
        //$employee_list = User::whereIn('building_id', $building->pluck('id')->toArray())->get()->pluck('user_id')->toArray();
        $employee = User::where('id', $id)->first();
        $sale_manager = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->Where('name', 'sale_manager');
            })
            //->where('property_admin_id', Helpers::user_admin())
            ->get();
            $projects = Project::all();
            $job = JobTitle::get();
        return view('user.employee.edit', compact('projects','employee', 'sale_manager', 'job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'cnic' => 'required|unique:users,cnic,' . $id,
            'job_title' => 'required',
            'phone_number' => 'required|unique:users,phone_number,' . $id,
            'working_days' => 'required|max:31'
        ]);
        if ($request->job_title == 'sale_person') {
            $request->validate([
                'sale_manager_id' => 'required',
            ]);
        }
        $employee = User::findOrFail($id);
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone_number = $request->phone_number;
        $employee->project = $request->building_id;
        $employee->sale_manager_id = $request->sale_manager_id;
        $employee->cnic = $request->cnic;
        $employee->address = $request->address;
        $employee->account_no = $request->account_no;
        $employee->salary = $request->salary;
        $employee->commission = $request->commission;
        if ($request->file('document')) {
            $document = $request->file('document');
            $document_name = hexdec(uniqid()) . '.' . strtolower($document->getClientOriginalExtension());
            $document->move('public/images/employee/', $document_name);
            $employee->document = asset('public/images/employee/' . $document_name);
        }
        $employee->save();
        $payroll = EmployeePayroll::where('user_id',$id)->first();
        $payroll->name = $employee->name;
        $payroll->working_days = $request->working_days;
        $payroll->user_id = $employee->id;
        $payroll->amount = $employee->salary;
        $payroll->save();
        $assign = Project_assign_user::where('user_id', $employee->id)->first();

        if (!empty($assign->building_id) == $request->building_id) {
            $assign->update(
                [
                    'user_id' => $employee->id,
                    'project_id' => $request->building_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        } else {
            Project_assign_user::create(
                [
                    'user_id' => $employee->id,
                    'project_id' => $request->building_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        $employee->assignRole($request->job_title);
        if ($employee) {
            return redirect()->route('employee.index', ['RolePrefix' => RolePrefix()])->with($this->message('Employee Update Successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Employee Update Error', 'danger'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //$building = Helpers::custom_building_detail();
        // $employee_detail = Employee::whereIn('building_id', $building->pluck('id')->toArray())->where('user_id', $id)->first();
        // $employee_payroll = EmployeePayRoll::where('user_id', $employee_detail->id)->first();
        $employee = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->whereIn('name', ['sale_person', 'office_staff', 'accountant']);
            })
            ->findOrFail($id);

        $employee->forceDelete();
        //$employee_detail->forceDelete();
        if ($employee !== null) {
            $employee->delete();
        }

        $payroll = EmployeePayroll::where('user_id',$id);
        $payroll->forceDelete();
        if ($payroll !== null) {
            $payroll->delete();
        }
        if ($employee) {
            return redirect()->route('employee.index', ['RolePrefix' => RolePrefix()])->with($this->message('Employee Deleted Successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Employee Delete Error', 'danger'));
        }
    }
}
