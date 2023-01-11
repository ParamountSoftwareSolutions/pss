<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\LeavesAdmin;
use DB;
use DateTime;
use Illuminate\Http\Request;

class LeavesController extends Controller
{
    // leaves
    public function leaves()
    {
        $leaves = DB::table('leaves_admins')
            ->join('users', 'users.id', '=', 'leaves_admins.user_id')
            ->get();

        return view('user.form.leaves', compact('leaves'));
    }
    // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'leave_type'   => 'required|string|max:255',
            'from_date'    => 'required|string|max:255',
            'to_date'      => 'required|string|max:255',
            'leave_reason' => 'required|string|max:255',
        ]);
        $from_date = new DateTime($request->from_date);
        $to_date = new DateTime($request->to_date);
        $day     = $from_date->diff($to_date);
        $days    = $day->d;

        $leaves = new LeavesAdmin;
        $leaves->user_id        = $request->user_id;
        $leaves->leave_type    = $request->leave_type;
        $leaves->from_date     = $request->from_date;
        $leaves->to_date       = $request->to_date;
        $leaves->day           = $days;
        $leaves->leave_reason  = $request->leave_reason;
        $leaves->save();

        return redirect()->back();
    }

    // edit record
    public function editRecordLeave(Request $request)
    {

        $from_date = new DateTime($request->from_date);
        $to_date = new DateTime($request->to_date);
        $day     = $from_date->diff($to_date);
        $days    = $day->d;

        $update = [
            'id'           => $request->id,
            'leave_type'   => $request->leave_type,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date,
            'day'          => $days,
            'leave_reason' => $request->leave_reason,
        ];

        LeavesAdmin::where('id', $request->id)->update($update);
        return redirect()->back();
    }

    // delete record
    public function deleteLeave(Request $request)
    {
        LeavesAdmin::destroy($request->id);
        return redirect()->back();
    }

    // leaveSettings
    public function leaveSettings()
    {
        return view('user.form.leavesettings');
    }

    // attendance admin
    public function attendanceIndex()
    {
        return view('user.form.attendance');
    }

    // attendance employee
    public function AttendanceEmployee()
    {
        return view('user.form.attendanceemployee');
    }

    // leaves Employee
    public function leavesEmployee()
    {
        return view('user.form.leavesemployee');
    }

    // shiftscheduling
    public function shiftScheduLing()
    {
        return view('user.form.shiftscheduling');
    }

    // shiftList
    public function shiftList()
    {
        return view('user.form.shiftlist');
    }
}
