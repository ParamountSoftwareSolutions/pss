<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{
    public function my_targets()
    {
        $targets = Target::where('assign_to',Auth::user()->id)->get();
        return view('user.task_targets.index',compact('targets'));
    }

    public function staff_targets()
    {
        $targets = TaskTarget::where('user_id',Auth::user()->id)->get();
        return view('property.task_targets.staff',compact('targets'));
    }

    public function assign_target()
    {
        return view('property.task_targets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'assign_to' => 'required',
            'type' => 'required',
            'target' => 'required',
            'date' => 'required',
        ]);

        $date = explode(" - ",$request->date);
        $from = $date[0];
        $to = $date[1];

        $assign_to = $request->assign_to;
        $assign_to_list = Helpers::check_target_assign($assign_to);
        if(is_array($assign_to_list)){
            foreach ($assign_to_list as $assign_to_id){
                $target = new TaskTarget();
                $target->user_id = Auth::user()->id;
                $target->assign_to = $assign_to_id;
                $target->type = $request->type;
                $target->target = $request->target;
                $target->from = $from;
                $target->to = $to;
                $target->save();
                $target_arr[] = $target;
            }
            $url = 'property.staff_targets';
            if(Helpers::isEmployee()){
                $url = 'property.my_targets';
            }
            return redirect()->route($url,Helpers::user_login_route())->with($this->message('Target Assign Successfully', 'success'));
        }else{
            return redirect()->back()->with($this->message('Target Assign Error', 'error'));
        }
    }
    public function edit_task($panel,$id)
    {
        $target = TaskTarget::findOrFail($id);
        return view('property.task_targets.edit',compact('target'));
    }
    public function update_task(Request $request,$panel,$id)
    {
        $request->validate([
            'type' => 'required',
            'target' => 'required',
            'date' => 'required',
        ]);
        $date = explode(" - ",$request->date);
        $from = $date[0];
        $to = $date[1];

        $target = TaskTarget::findOrFail($id);
        $target->type = $request->type;
        $target->target = $request->target;
        $target->from = $from;
        $target->to = $to;
        $target->save();
        if($target){
            return redirect()->route('property.staff_targets',Helpers::user_login_route())->with($this->message('Target Updated Successfully', 'success'));
        }else{
            return redirect()->back()->with($this->message('Target Updated Error', 'error'));
        }
    }
    public function get_role_list($panel,$role)
    {
        $buildings = Helpers::building_detail()->pluck('id')->toArray();
        $users = BuildingAssignUser::whereIn('building_id',$buildings)->pluck('user_id')->toArray();
        $manager = User::select('id','username')->whereIn('id',$users)->with('roles')
            ->whereHas('roles', function ($q) use ($role) {
                $q->Where('name', $role);
            })
            ->get();
        return response()->json($manager);
    }
    public function task_reports($panel)
    {
        $date = Carbon::now()->format('Y-m-d');
        $target_failed = TaskTarget::where('to','<',$date)->get();
        if($target_failed->count()){
            foreach($target_failed as $target){
                $target->status = 'failed';
                $target->save();
            }
        }
        $targets = TaskTarget::where('user_id',Auth::user()->id)->groupBy('assign_to')->get();
        return view('property.task_targets.reports',compact('targets'));
    }
    public function get_report($panel,$id)
    {
        $user = User::findOrFail($id);
        $data['name'] = $user->username;

        $overdue = TaskTarget::where(['assign_to'=>$id,'user_id'=>Auth::user()->id,'status'=>'failed'])->get();
        $data['overdue'] = $overdue->count();

        $targets = TaskTarget::where(['assign_to'=>$id,'user_id'=>Auth::user()->id])->whereDate('from',Carbon::now())->get();
        $data['total_tasks'] = $targets->count();

        $achieved = $targets->where('status','success');
        $data['achieved'] = $achieved->count();

        $client = $targets->where('type','client')->first();
        if($client){
            $data['total_clients'] = $client->target;
            $data['client'] = $client->achieved;
        }else{
            $data['total_clients'] = 0;
            $data['client'] = 0;
        }

        $lead = $targets->where('type','lead')->first();
        if($lead){
            $data['total_leads'] = $lead->target;
            $data['lead'] = $lead->achieved;
        }else{
            $data['total_leads'] = 0;
            $data['lead'] = 0;
        }

        $meeting = $targets->where('type','meeting')->first();
        if($meeting){
            $data['total_meetings'] = $meeting->target;
            $data['meeting'] = $meeting->achieved;
        }else{
            $data['total_meetings'] = 0;
            $data['meeting'] = 0;
        }

        $call = $targets->where('type','call')->first();
        if($call){
            $data['total_calls'] = $call->target;
            $data['call'] = $call->achieved;
        }else{
            $data['total_calls'] = 0;
            $data['call'] = 0;
        }

        return response()->json($data);
    }
}
