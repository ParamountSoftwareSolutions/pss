<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Building;
use App\Models\BuildingInventory;
use App\Models\BuildingInventoryFile;
use App\Models\Category;
use App\Models\FarmhouseFile;
use App\Models\FarmhouseInventory;
use App\Models\FarmhouseInventoryFile;
use App\Models\InventoryHistory;
use App\Models\Premium;
use App\Models\Farmhouse;
use App\Models\Block;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Size;
use App\Models\Type;
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
    public function index($farmhouse_id,$block_id)
    {
        $farmhouse = Farmhouse::findOrFail($farmhouse_id);
        $block = Block::findOrFail($block_id);
        $inventories = FarmhouseInventory::where(['farmhouse_id'=>$farmhouse_id,'block_id'=>$block_id])->latest('updated_at')->get();
        return view('user.farmhouse_inventory.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($farmhouse_id,$block_id)
    {
        $farmhouse = Farmhouse::findOrFail($farmhouse_id);
        $block = Block::findOrFail($block_id);
        $type_id = json_decode($farmhouse->type);
        $category = Category::whereIn('id',$type_id)->get();
        $sizes = Size::where('project_type_id',project_type('farm_house'))->get();
        $premiums = Premium::where('project_type_id',project_type('farm_house'))->get();
        $plot_size = Size::where('project_type_id',project_type('farm_house'))->get();
        $nature = Type::where('project_type_id',project_type('farm_house'))->get();
        return view('user.farmhouse_inventory.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request,$farmhouse_id,$block_id)
    {
        $farmhouse = Farmhouse::findOrFail($farmhouse_id);
        $block = Block::findOrFail($block_id);
        $project = Project::findOrFail($farmhouse->project_id);
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
                $farmhouse_inventory = new FarmhouseInventory();
                $farmhouse_inventory->project_id = $project->id;
                $farmhouse_inventory->farmhouse_id = $farmhouse_id;
                $farmhouse_inventory->block_id = $block_id;
                $farmhouse_inventory->unit_id = $unit;
                $farmhouse_inventory->category_id = $request->category_id;
                $farmhouse_inventory->size_id = $request->size_id;
                $farmhouse_inventory->type_id = $request->nature_id;
                $farmhouse_inventory->bed = $request->bed;
                $farmhouse_inventory->bath = $request->bath;
                $farmhouse_inventory->premium_id = $premium;
                $farmhouse_inventory->payment_plan_id = $request->payment_plan_id;
                $farmhouse_inventory->created_by = Auth::id();
                $farmhouse_inventory->save();
                if ($request->has('images')) {
                    foreach ($request->file('images') as $file) {
                        $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                        $file->move('public/images/farmhouse/', $filename);
                        $file = 'images/farmhouse/' . $filename;
                        FarmhouseInventoryFile::create([
                            'farmhouse_inventory_id' => $farmhouse_inventory->id,
                            'file' => $file,
                            'type' => 'image',
                        ]);
                    }
                }
            }
            return redirect()->route('farmhouse.block.inventory.index', ['RolePrefix' => RolePrefix(),'farmhouse'=>$farmhouse_id,'block'=>$block_id])->with(['message' => 'Farmhouse inventory has created successfully', 'alert' => 'success']);
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
    public function show($project_id,$inventory_id)
    {
        $project = Project::where('type_id',3)->findOrFail($project_id);
        $inventory = Farmhouse::where('project_id',$project_id)->findOrFail($inventory_id);
        $inventory_histories = InventoryHistory::where('project_type_id',3)->where('inventory_id',$inventory_id)->latest('updated_at')->get();
        return view('user.farmhouse.show', compact('inventory','inventory_histories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($project_id,$inventory_id)
    {
        $project = Project::findOrFail($project_id);
        $farmhouse = Farmhouse::with('files')->where('project_id',$project_id)->findOrFail($inventory_id);
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
