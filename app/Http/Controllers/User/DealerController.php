<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\BuildingAbout;
use App\Models\BuildingInventory;
use App\Models\Dealer;
use App\Models\DealerHistory;
use App\Models\DealerProject;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\SocietyInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $dealers = Dealer::with('project')->get();
        return view('user.dealer.index', compact('dealers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $projects = Project::get();
        return view('user.dealer.create',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => 'required',
            'cnic' => 'required|unique:dealers',
            'number' => 'required|unique:dealers',
            'address' => 'required',
            'agency' => 'required',
            'actual_amount' => 'required|numeric',
            'rebate' => 'required',
            'category' => 'required',
            'project_id' => 'required',
        ]);
        if(isset($request->email)){
            $request->validate([
                'email' => 'required|unique:dealers',
            ]);
        }
        if($request->category == 'floor'){
            $request->validate([
                'floor_id' => 'required',
            ]);
            $inventory_id = get_inventory_by_floor_project($request->project_id,$request->floor_id)->where('status','available')->pluck('id')->toArray();
        }
        elseif($request->category == 'bulk'){
            $request->validate([
                'bulk_unit_no' => 'required',
                'start_unit_no' => 'required',
                'end_unit_no' => 'required',
            ]);
            $bulk_unit_no = $request->bulk_unit_no;
            $start_unit_no = $request->start_unit_no;
            $end_unit_no = $request->end_unit_no;
            $count = count($bulk_unit_no);
            $bulk_arr = [];
            for($i = 0; $i < $count; $i++){
                $bulk_arr[] = [
                    'bulk_unit_no' => reset($bulk_unit_no),
                    'start_unit_no' => reset($start_unit_no),
                    'end_unit_no' => reset($end_unit_no),
                ];
                array_shift($bulk_unit_no);
                array_shift($start_unit_no);
                array_shift($end_unit_no);

            }
            $inventory_id = [];
            foreach ($bulk_arr as $bulk){
                if($bulk['start_unit_no'] > $bulk['end_unit_no']){
                    return redirect()->back()->with(['alert' => 'error', 'message' => 'End unit no must be greater than start unit no.']);
                }
                for($i = $bulk['start_unit_no'];$i <= $bulk['end_unit_no']; $i++){
                    $unit_id = $bulk['bulk_unit_no'].' '.$i;
                    $id = get_inventory_by_project($request->project_id)->where('unit_id',$unit_id)->where('status','available')->first()->id;
                    $inventory_id[] = $id;
                }
            }
        }elseif($request->category == 'project'){
            $inventory_id = get_inventory_by_project($request->project_id)->where('status','available')->pluck('id')->toArray();
        }

        $dealer = new Dealer();
        $dealer->name = $request->name;
        $dealer->email = $request->email;
        $dealer->cnic = $request->cnic;
        $dealer->number = $request->number;
        $dealer->alt_number = $request->alt_number;
        $dealer->address = $request->address;
        $dealer->agency = $request->agency;
        $dealer->actual_amount = $request->actual_amount;
        $dealer->rebate = $request->rebate;
        $dealer->token = $request->received;
        $dealer->received = $request->received;
        $dealer->pending = $request->pending;
        $dealer->save();
        if ($dealer) {
            $dealer_id = $dealer->id;
            if($dealer_id < 10){
                $dealer_id = '0'.$dealer->id;
            }
            $x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $string = substr(str_shuffle(str_repeat($x,ceil(2/strlen($x)) )),1,2);
            $code = $string.$dealer_id;
            $dealer->code = $code;
            $dealer->save();

            $dealer_project = new DealerProject();
            $dealer_project->dealer_id = $dealer->id;
            $dealer_project->project_id = $request->project_id;
            $dealer_project->inventory_list = json_encode($inventory_id,true);
            $dealer_project->save();


            $history = [
                'dealer_id'=>$dealer->id,
                'code'=>$dealer->code,
                'amount'=>$dealer->token,
                'key'=>'token',
                'comment'=>'Dealer Created',
            ];
            DealerHistory::create($history);
            get_inventory_by_project($request->project_id)->whereIn('id',$inventory_id)->update(['status'=>'hold']);
            return redirect()->route('dealer.index',RolePrefix())->with(['alert' => 'success', 'message' => 'Dealer has been created successfully!']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Dealer create error']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dealer = Dealer::findOrFail($id);
        $dealer_projects = DealerProject::where('dealer_id',$id)->groupBy('project_id')->get();
        return view('user.dealer.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $dealer = Dealer::withSum('received','amount')->findOrFail($id);
        $projects = Project::get();
        return view('user.dealer.edit',get_defined_vars());
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
        $dealer = Dealer::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'cnic' => 'required|unique:dealers,cnic,'.$dealer->id,
            'number' => 'required|unique:dealers,number,'.$dealer->id,
            'address' => 'required',
            'agency' => 'required',
            'actual_amount' => 'required|numeric',
            'rebate' => 'required',
        ]);
        if(isset($request->email)){
            $request->validate([
                'email' => 'required|unique:dealers,email,'.$dealer->id,
            ]);
        }
        $dealer->name = $request->name;
        $dealer->email = $request->email;
        $dealer->cnic = $request->cnic;
        $dealer->number = $request->number;
        $dealer->alt_number = $request->alt_number;
        $dealer->address = $request->address;
        $dealer->agency = $request->agency;
        $dealer->actual_amount = $request->actual_amount;
        $dealer->rebate = $request->rebate;
        $dealer->token = $request->received;
        $dealer->received = $request->received;
        $dealer->pending = $request->pending;
        $dealer->save();
        if ($dealer) {
            return redirect()->route('dealer.index',RolePrefix())->with(['alert' => 'success', 'message' => 'Dealer has been updated successfully!']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Dealer update error']);
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
        $dealer = Dealer::findOrFail($id);
        $projects = DealerProject::where('dealer_id',$id)->groupBy('project_id')->get();
        $project_arr = [];
        foreach($projects as $val){
            $dealer_project = DealerProject::where('dealer_id',$id)->where('project_id',$val->project_id)->get();
            $inventory = [];
            foreach ($dealer_project as $val){
                $list = json_decode($val->inventory_list);
                $inventory = array_merge($inventory,$list);
            }
            $project_arr[$val->project_id] = $inventory;
        }
        foreach ($project_arr as $key => $val){
            $project = Project::where('id',$key)->first();
            if($project){
                if($project->type_id == 1){
                    $inventories = BuildingInventory::where('project_id',$key)->whereIn('id',$val);
                }elseif($project->type_id == 2){
                    $inventories = SocietyInventory::where('project_id',$key)->whereIn('id',$val);
                }elseif($project->type_id == 3){
                    $inventories = Farmhouse::where('project_id',$key)->whereIn('id',$val);
                }else{
                    $inventories = BuildingInventory::where('id',0);
                }
                $response = $inventories->where('status','hold')->update(['status'=>'available']);
            }
        }
        $dealer->delete();
        if ($dealer) {
            return response()->json(['message'=>'Dealer has been deleted successfully!','status'=>'success']);
        } else {
            return response()->json(['message'=> 'Dealer delete error','status'=>'error']);
        }
    }

    public function add_new($id)
    {
        $dealer = Dealer::findOrFail($id);
        $projects = Project::get();
        return view('user.dealer.add_new', get_defined_vars());
    }

    public function add_new_store(Request $request,$id)
    {
        $dealer = Dealer::findOrFail($id);
        $request->validate([
            'category' => 'required',
            'project_id' => 'required',
        ]);
        if($request->category == 'floor'){
            $request->validate([
                'floor_id' => 'required',
            ]);
            $inventory_id = get_inventory_by_floor_project($request->project_id,$request->floor_id)->where('status','available')->pluck('id')->toArray();
        }
        elseif($request->category == 'bulk'){
            $request->validate([
                'bulk_unit_no' => 'required',
                'start_unit_no' => 'required',
                'end_unit_no' => 'required',
            ]);
            $bulk_unit_no = $request->bulk_unit_no;
            $start_unit_no = $request->start_unit_no;
            $end_unit_no = $request->end_unit_no;
            $count = count($bulk_unit_no);
            $bulk_arr = [];
            for($i = 0; $i < $count; $i++){
                $bulk_arr[] = [
                    'bulk_unit_no' => reset($bulk_unit_no),
                    'start_unit_no' => reset($start_unit_no),
                    'end_unit_no' => reset($end_unit_no),
                ];
                array_shift($bulk_unit_no);
                array_shift($start_unit_no);
                array_shift($end_unit_no);

            }
            $inventory_id = [];
            foreach ($bulk_arr as $bulk){
                if($bulk['start_unit_no'] > $bulk['end_unit_no']){
                    return redirect()->back()->with(['alert' => 'error', 'message' => 'End unit no must be greater than start unit no.']);
                }
                for($i = $bulk['start_unit_no'];$i <= $bulk['end_unit_no']; $i++){
                    $unit_id = $bulk['bulk_unit_no'].' '.$i;
                    $id = get_inventory_by_project($request->project_id)->where('unit_id',$unit_id)->where('status','available')->first()->id;
                    $inventory_id[] = $id;
                }
            }
        }elseif($request->category == 'project'){
            $inventory_id = get_inventory_by_project($request->project_id)->where('status','available')->pluck('id')->toArray();
        }

        $dealer_project = new DealerProject();
        $dealer_project->dealer_id = $dealer->id;
        $dealer_project->project_id = $request->project_id;
        $dealer_project->inventory_list = json_encode($inventory_id,true);
        $dealer_project->save();

        if ($dealer_project) {
            $history = [
                'dealer_id'=>$dealer->id,
                'code'=>$dealer->code,
                'comment'=>'Dealer add new project',
            ];
            DealerHistory::create($history);
            get_inventory_by_project($request->project_id)->whereIn('id',$inventory_id)->update(['status'=>'hold']);
            return redirect()->route('dealer.index',RolePrefix())->with(['alert' => 'success', 'message' => 'Dealer has been created successfully!']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Dealer create error']);
        }
    }
    public function dealer_project($dealer_id,$project_id)
    {
        $arr = $this->dealer_project_detail($dealer_id,$project_id);
        $dealer = $arr['dealer'];
        $project = $arr['project'];
        $project_array = $arr['project_array'];
        return view('user.dealer.view', get_defined_vars());
    }
    protected function dealer_project_detail($dealer_id,$project_id)
    {
        $dealer = Dealer::findOrFail($dealer_id);
        $project = Project::findOrFail($project_id);
        $projects = DealerProject::where(['dealer_id'=>$dealer_id,'project_id'=>$project_id])->get();
        $inventory = [];
        foreach ($projects as $val){
            $list = json_decode($val->inventory_list);
            $inventory = array_merge($inventory,$list);
        }
        $controller = new ProjectController();
        $floors = $controller->get_floor_block($project->id)->getData();
        $project_array = [];
        $floor_id_arr = array_column($floors,'id');
        foreach($floors as $floor){
            if($project->type_id == 1){
                $inventories = BuildingInventory::whereIn('id',$inventory)->where('project_id',$project->id)->where('building_floor_id',$floor->id)->get();
                $project_array[$floor->name] = $inventories;
            }elseif($project->type_id == 2){
                $inventories = SocietyInventory::whereIn('id',$inventory)->where('project_id',$project->id)->where('block_id',$floor->id)->get();
                $project_array[$floor->name] = $inventories;
            }elseif($project->type_id == 3){
                $inventories = Farmhouse::whereIn('id',$inventory)->where('project_id',$project->id)->where('block_id',$floor->id)->get();
                $project_array[$floor->name] = $inventories;
            }
        }
        if($project->type_id == 1){
            $inventories = BuildingInventory::where('project_id',$project->id)->whereNotIn('building_floor_id',$floor_id_arr)->whereIn('id',$inventory)->get();
        }elseif($project->type_id == 2){
            $inventories = SocietyInventory::where('project_id',$project->id)->whereNotIn('block_id',$floor_id_arr)->whereIn('id',$inventory)->get();
        }elseif($project->type_id == 3){
            $inventories = Farmhouse::where('project_id',$project->id)->whereNotIn('block_id',$floor_id_arr)->whereIn('id',$inventory)->get();
        }
        if($inventories->count()){
            $project_array['Inventory without Blocks/Floors'] = $inventories;
        }
        return get_defined_vars();
    }

    public function generatePDF($dealer_id,$project_id)
    {
        $arr = $this->dealer_project_detail($dealer_id,$project_id);
        $dealer = $arr['dealer'];
        $project = $arr['project'];
        $project_array = $arr['project_array'];
        $pdf = PDF::loadView('user.dealer.pdf-inventries', compact('dealer','project','project_array'))->setOptions(['defaultFont' => 'sans-serif','isRemoteEnabled' => true]);
        return $pdf->download($project->name.'.pdf');
    }
}
