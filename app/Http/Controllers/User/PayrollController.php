<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmployeePayroll;
use App\Models\User;
use DB;
use App\Models\StaffSalary;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;
use Rap2hpoutre\FastExcel\FastExcel;

class PayrollController extends Controller
{
    // payroll Items
    public function payrollItems()
    {
        $payroll = EmployeePayroll::all();
        return view('user.payroll.index', compact('payroll'));
    }

    public function editPayroll($id)
    {
        $employee = EmployeePayroll::findOrFail($id);
        return view('user.payroll.edit', compact('employee'));
    }
    public function updatePayroll(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required',
        ]);

        $employee_payroll = EmployeePayroll::updateOrCreate(['id' => $id], [
            'amount' => $request->amount,
            'commission' => $request->commission,
            'working_days' => $request->working_days,
            'present_days' => $request->present_days,
            'absent_days' => $request->absent_days,
            'total_leaves' => $request->total_leaves,
            'leaves_approved' => $request->leaves_approved,
            'advance' => $request->advance,
            'comments' => $request->comments,
            'payment_method' => $request->payment_mode,
        ]);
        if ($employee_payroll) {
            return redirect()->route('payroll.form/payroll/items', ['RolePrefix' => RolePrefix(), $id])->with($this->message('Employee Pay Update Successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Employee Pay Update Error', 'danger'));
        }
    }
    public function viewPayroll($id)
    {
        $employee = EmployeePayroll::findOrFail($id);
        return view('user.payroll.view', compact('employee'));
    }

    public function exportPayroll()
    {
        $employee = EmployeePayroll::all();
        $storage = [];
        foreach ($employee as $item) {
            $storage[] = [
                'name' => $item['name'] ?? [],
                'user_id' => $item['user_id'] ?? [],
                'salary_amount' => $item['amount'] ?? [],
                'commission' => $item['commission'] ?? [],
                'working_days' => $item['working_days'] ?? [],
                'present_days' => $item['present_days'] ?? [],
                'absent_days' => $item['absent_days'] ?? [],
                'total_amount' => $item['total_amount'] ?? [],
                'advance' => $item['advance'] ?? [],
                'total_leaves' => $item['total_leaves'] ?? [],
                'leaves_approved' => $item['leaves_approved'] ?? [],
                'payment_method' => $item['payment_method'] ?? [],
            ];
        }
        return (new FastExcel($storage))->download('/public/assets/employee_payrolls.xlsx');
    }
    public function importPayroll()
    {
        return view('user.payroll.import');
    }

    public function bulk_import_payroll(Request $request)
    {
        try {
            $collections = (new FastExcel)->import($request->file('employee_payrolls_file'));
        } catch (\Exception $exception) {
            return back()->with($this->message('You have uploaded a wrong format file, please upload the right file.', 'error'));
        }

        foreach ($collections as $key => $collection) {
            if ($collection['salary_amount'] == ""  && !is_numeric($collection['salary_amount'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: salary_amount', 'error'));
            } elseif ($collection['commission'] == "" && !is_numeric($collection['commission'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: commission', 'error'));
            } elseif ($collection['working_days'] == "" && !is_numeric($collection['working_days'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: working_days', 'error'));
            } elseif ($collection['present_days'] == "" && !is_numeric($collection['present_days'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: present_days', 'error'));
            } elseif ($collection['absent_days'] == "" && !is_numeric($collection['absent_days'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: absent_days', 'error'));
            } elseif ($collection['advance'] == "" && !is_numeric($collection['advance'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: advance', 'error'));
            } elseif ($collection['leaves_approved'] == "" && !is_numeric($collection['leaves_approved'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: leaves_approved', 'error'));
            } elseif ($collection['total_leaves'] == "" && !is_numeric($collection['total_leaves'])) {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: total_leaves', 'error'));
            } elseif ($collection['payment_method'] == "") {
                return back()->with($this->message('Please fill row:' . ($key + 2) . ' field: payment_method', 'error'));
            }
        }

        foreach ($collections as $key => $collection) {
            $employee = EmployeePayroll::where('user_id', $collection['user_id'])->get();
            if ($employee) {
                $employee_payroll = EmployeePayroll::updateOrCreate(['user_id' => $collection['user_id']], [
                    'amount' => $collection['salary_amount'],
                    'commission' => $collection['commission'],
                    'working_days' => $collection['working_days'],
                    'present_days' => $collection['present_days'],
                    'absent_days' => $collection['absent_days'],
                    'advance' => $collection['advance'],
                    'total_leaves' => $collection['total_leaves'],
                    'leaves_approved' => $collection['leaves_approved'],
                    'payment_method' => $collection['payment_method'],
                ]);
            } else {
                return back()->with($this->message('File with this uername not found.', 'error'));
            }
        }
        return back()->with($this->message('Payroll imported successfully!', 'success'));
    }










    // view page salary
    public function salary()
    {

        $users = FacadesFacadesDB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            ->select('users.*', 'staff_salaries.*')
            ->get();
        $userList = FacadesFacadesDB::table('users')->get();
        // $permission_lists = FacadesDB::table('permission_lists')->get();
        return view('user.payroll.employeesalary', compact('users', 'userList'));
    }

    // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'salary'       => 'required|string|max:255',
            'basic' => 'required|string|max:255',
            'da'    => 'required|string|max:255',
            'hra'    => 'required|string|max:255',
            'conveyance' => 'required|string|max:255',
            'allowance'  => 'required|string|max:255',
            'medical_allowance' => 'required|string|max:255',
            'esp' => 'required|string|max:255',
            'pf'  => 'required|string|max:255',
            'leave'    => 'required|string|max:255',
            'prof_tax' => 'required|string|max:255',
            'labour_welfare' => 'required|string|max:255',
        ]);

        FacadesFacadesDB::beginTransaction();
        try {
            $salary = StaffSalary::updateOrCreate(['user_id' => $request->user_id]);
            $salary->name              = $request->name;
            $salary->user_id            = $request->user_id;
            $salary->salary            = $request->salary;
            $salary->basic             = $request->basic;
            $salary->da                = $request->da;
            $salary->hra               = $request->hra;
            $salary->conveyance        = $request->conveyance;
            $salary->allowance         = $request->allowance;
            $salary->medical_allowance = $request->medical_allowance;
            $salary->esp               = $request->esp;
            $salary->pf                = $request->pf;
            $salary->leave             = $request->leave;
            $salary->prof_tax          = $request->prof_tax;
            $salary->labour_welfare    = $request->labour_welfare;
            $salary->save();

            FacadesDB::commit();
            //Toastr::success('Create new Salary successfully :)','Success');
            return redirect()->back();
        } catch (\Exception $e) {
            FacadesDB::rollback();
            //Toastr::error('Add Salary fail :)','Error');
            return redirect()->back();
        }
    }

    // salary view detail
    public function salaryView($user_id)
    {
        $users = FacadesDB::table('users')
            ->join('staff_salaries', 'users.id', '=', 'staff_salaries.user_id')
            //->join('profile_information', 'users.id', '=', 'profile_information.user_id')
            ->select('users.*', 'staff_salaries.*')
            ->where('staff_salaries.user_id', $user_id)
            ->where('users.id', $user_id)
            ->first();
        return view('user.payroll.salaryview', compact('users'));
    }

    // update record
    public function updateRecord(Request $request)
    {
        FacadesDB::beginTransaction();
        try {
            $update = [

                'id'      => $request->id,
                'name'    => $request->name,
                'salary'  => $request->salary,
                'basic'   => $request->basic,
                'da'      => $request->da,
                'hra'     => $request->hra,
                'conveyance' => $request->conveyance,
                'allowance'  => $request->allowance,
                'medical_allowance'  => $request->medical_allowance,
                'tds'  => $request->tds,
                'esi'  => $request->esi,
                'pf'   => $request->pf,
                'leave'     => $request->leave,
                'prof_tax'  => $request->prof_tax,
                'labour_welfare'  => $request->labour_welfare,
            ];


            StaffSalary::where('id', $request->id)->update($update);
            FacadesDB::commit();
            //Toastr::success('Salary updated successfully :)','Success');
            return redirect()->back();
        } catch (\Exception $e) {
            FacadesDB::rollback();
            //Toastr::error('Salary update fail :)','Error');
            return redirect()->back();
        }
    }

    // delete record
    public function deleteRecord(Request $request)
    {
        FacadesDB::beginTransaction();
        try {

            StaffSalary::destroy($request->id);

            FacadesDB::commit();
            //Toastr::success('Salary deleted successfully :)','Success');
            return redirect()->back();
        } catch (\Exception $e) {
            FacadesDB::rollback();
            //Toastr::error('Salary deleted fail :)','Error');
            return redirect()->back();
        }
    }
}
