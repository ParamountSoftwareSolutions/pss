<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Building;
use App\Models\BuildingInventory;
use App\Models\BuildingInventoryFile;
use App\Models\Category;
use App\Models\FarmhouseFile;
use App\Models\Premium;
use App\Models\Farmhouse;
use App\Models\Block;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Size;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmhouseInventoryController extends Controller
{
    private $project_type_id;

    public function __construct()
    {
        $id = ProjectType::where('name','farm_house')->first()->id;
        $this->project_type_id = $id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($id)
    {
        $project = Project::findOrFail($id);
        $farmhouses = Farmhouse::where('project_id',$id)->latest('updated_at')->get();
        return view('user.farmhouse.index', compact('farmhouses','project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($id)
    {
        $project = Project::findOrFail($id);
        $sizes = Size::get();
        $project_type_id = $this->project_type_id;
        $premiums = Premium::where('project_type_id',$project_type_id)->get();
        $blocks = Block::where('project_type_id',$project_type_id)->get();
        return view('user.farmhouse.create', compact('project','sizes','premiums','project_type_id','blocks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request,$id)
    {
        $project = Project::findOrFail($id);
        $request->validate([
            'payment_plan_id' => 'required',
        ]);
        if ($request->simple_unit_no) {
            $length = 0;
        }else {
            $request->validate([
                'bulk_unit_no' => 'required',
                'start_unit_no' => 'required',
                'end_unit_no' => 'required',
            ], [
                'end_unit_no' => 'Bulk Fields is required'
            ]);
            $length = $request->end_unit_no - $request->start_unit_no;
        }
        $premium = null;
        if ($request->premium_id !== 'regular') {
            $premium = $request->premium_id;
        }
        try {
            for ($i = 0; $length >= $i; $i++) {
                $unit = $request->simple_unit_no;
                if (!$unit) {
                    $unit_no = $request->start_unit_no + $i;
                    $unit = $request->bulk_unit_no . ' ' . $unit_no;
                }
                $farmhouse = new Farmhouse();
                $farmhouse->project_id = $id;
                $farmhouse->block_id = $request->block_id;
                $farmhouse->unit_no = $unit;
                $farmhouse->size_id = $request->size_id;
                $farmhouse->premium_id = $premium;
                $farmhouse->payment_plan_id = $request->payment_plan_id;
                $farmhouse->save();
                if ($request->has('images')) {
                    foreach ($request->file('images') as $file) {
                        $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                        $file->move('public/images/farmhouse/', $filename);
                        $file = 'images/farmhouse/' . $filename;
                        FarmhouseFile::create([
                            'farmhouse_id' => $farmhouse->id,
                            'file' => $file,
                        ]);
                    }
                }
            }
            return redirect()->route('farmhouse.inventory.index', ['RolePrefix' => RolePrefix(),'farmhouse'=>$id])->with(['message' => 'Farmhouse has created successfully', 'alert' => 'success']);
        }catch (Exception $e) {
            return redirect()->back()->with($this->message($e->getMessage(), 'error'));
            return redirect()->back()->with(['message' => 'Farmhouse has not created, something went wrong. Try again', 'alert' => 'error']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($project_id,$farmhouse_id)
    {
        $project = Project::findOrFail($project_id);
        $farmhouse = Farmhouse::with('files')->where('project_id',$project_id)->findOrFail($farmhouse_id);
        $sizes = Size::get();
        $project_type_id = $this->project_type_id;
        $premiums = Premium::where('project_type_id',$project_type_id)->get();
        $blocks = Block::where('project_type_id',$project_type_id)->get();
        return view('user.farmhouse.edit', compact('project','farmhouse', 'sizes','premiums','project_type_id','blocks'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $project_id,$farmhouse_id)
    {
        $request->validate([
            'unit_no' => 'required',
        ]);
        $project = Project::findOrFail($project_id);
        $farmhouse = Farmhouse::findOrFail($farmhouse_id);
        $farmhouse->block_id = $request->block_id;
        $farmhouse->unit_no = $request->unit_no;
        $farmhouse->size_id = $request->size_id;
        $farmhouse->status = $request->status;
        if(isset($request->premium_id) && $request->premium_id !== 'regular'){
            $farmhouse->premium_id = $request->premium_id;
        }
        $farmhouse->payment_plan_id = $request->payment_plan_id;
        $farmhouse->save();
        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/farmhouse/', $filename);
                $file = 'images/farmhouse/' . $filename;
                FarmhouseFile::create([
                    'farmhouse_id' => $farmhouse->id,
                    'file' => $file,
                ]);
            }
        }
        if ($farmhouse) {
            return redirect()->route('farmhouse.inventory.index', ['RolePrefix' => RolePrefix(),'farmhouse'=>$project_id])->with(['message' => 'Farmhouse has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Farmhouse has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($farmhouse_id,$project_id)
    {
        $project = Project::findOrFail($project_id);
        $farmhouse = Farmhouse::findOrFail($farmhouse_id);
        $farmhouse->delete();
        if ($farmhouse){
            return response()->json(['message'=>'Farmhouse Inventory has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Farmhouse Inventory has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
