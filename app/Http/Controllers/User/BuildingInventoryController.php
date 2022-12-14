<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingFloor;
use App\Models\BuildingInventory;
use App\Models\BuildingInventoryFile;
use App\Models\Category;
use App\Models\Farmhouse;
use App\Models\FloorDetailFile;
use App\Models\PaymentPlan;
use App\Models\Premium;
use App\Models\Project;
use App\Models\Size;
use App\Models\Type;
use App\Models\InventoryHistory;
use Egulias\EmailValidator\Result\InvalidEmail;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($building_id, $floor_id)
    {
//        return view('form_new');
        $building_floor = BuildingFloor::findOrFail($floor_id);
        $building_inventory = BuildingInventory::with('file')->where(['building_id' => $building_id, 'building_floor_id' => $floor_id])->latest()->get();
        return view('user.building_inventory.index', compact('building_inventory', 'building_id', 'floor_id', 'building_floor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create($building_id, $floor_id)
    {
        $building = Building::with('project')->findOrFail($building_id);
        $payment_plan = PaymentPlan::whereHas('type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $category = Category::whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $premium = Premium::whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $bed = Size::where('unit', 'bed')->whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $bath = Size::where('unit', 'bath')->whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $nature = Type::whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        return view('user.building_inventory.create', compact('building_id', 'floor_id', 'building', 'payment_plan', 'category', 'premium', 'bed', 'bath', 'nature'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $building_id, $floor_id)
    {
        $building = Building::with('project')->findOrFail($building_id);
        $request->validate([
            'payment_plan_id' => 'required',
            'category_id' => 'required',
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
                $inventory = new BuildingInventory();
                $inventory->building_id = $building_id;
                $inventory->project_id = $building->project->id;
                $inventory->building_floor_id = $floor_id;
                $inventory->payment_plan_id = $request->payment_plan_id;
                $inventory->unit_id = $unit;
                $inventory->area = $request->area;
                $inventory->category_id = $request->category_id;
                $inventory->premium_id = $premium;
                $inventory->type_id = $request->nature_id;
                $inventory->bed_id = $request->bed;
                $inventory->bath_id = $request->bath;
                $inventory->created_by = Auth::id();
                $inventory->status = 'available';
                $inventory->save();

                $category = Category::findOrFail($request->category_id)->name;
                if ($category == 'Shop') {
                    BuildingInventoryFile::Create(
                        [
                            'building_inventory_id' => $inventory->id,
                            'file' => 'images/building/shop.jpg',
                            'type' => 'image',
                        ]);
//                    }
                } else if ($category == 'Apartment') {
                    BuildingInventoryFile::Create(
                        [
                            'building_inventory_id' => $inventory->id,
                            'file' => 'images/building/flat.jpg',
                            'type' => 'image',
                        ]);
                } elseif ($category == 'Office') {
                    BuildingInventoryFile::Create(
                        [
                            'building_inventory_id' => $inventory->id,
                            'file' => 'images/building/office.jpg',
                            'type' => 'image',
                        ]);
                } elseif ($category == 'Pent House') {
                    BuildingInventoryFile::Create(
                        [
                            'building_inventory_id' => $inventory->id,
                            'file' => 'images/building/pent_house.jpg',
                            'type' => 'image',
                        ]);
                } elseif ($category == 'Studio') {
                    BuildingInventoryFile::Create(
                        [
                            'building_inventory_id' => $inventory->id,
                            'file' => 'images/building/single_bed.jpg',
                            'type' => 'image',
                        ]);
                } elseif ($category == 'Flats') {
                    BuildingInventoryFile::Create(
                        [
                            'building_inventory_id' => $inventory->id,
                            'file' => 'images/building/flat.jpg',
                            'type' => 'image',
                        ]);
                } else {
                    BuildingInventoryFile::Create(
                        [
                            'building_inventory_id' => $inventory->id,
                            'file' => 'images/building/pent_house.jpg',
                            'type' => 'image',
                        ]);
                }
            }
            return redirect()->route('building.floor.building_inventory.index', ['RolePrefix' => RolePrefix(), 'building' => $building_id, 'floor' => $floor_id])->with($this->message('Building inventory created successfully', 'success'));
        }catch (Exception $e) {
            return redirect()->back()->with($this->message($e->getMessage(), 'error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($building_id, $floor_id, $id)
    {
        $building = Building::findOrFail($building_id);
        $project = Project::where('type_id',1)->findOrFail($building->project_id);
        $inventory = BuildingInventory::where(['building_id'=>$building_id,'project_id'=>$project->id,'building_floor_id'=>$floor_id])->findOrFail($id);
        $inventory_histories = InventoryHistory::where('project_type_id',1)->where('inventory_id',$id)->latest('updated_at')->get();
        return view('user.farmhouse.show', compact('inventory','inventory_histories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($building_id, $floor_id, $id)
    {
        $building = Building::with('project')->findOrFail($building_id);
        $category = Category::whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $premium = Premium::whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $bed = Size::where('unit_id', 'bed')->whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $bath = Size::where('unit_id', 'bath')->whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $nature = Type::whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $inventory = BuildingInventory::with('file')->findOrFail($id);
        return view('user.building_inventory.edit', compact('building_id', 'floor_id', 'building', 'category', 'premium', 'bed', 'bath', 'nature', 'inventory'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $building_id, $floor_id, $id)
    {
        $inventory = BuildingInventory::findOrFail($id);
        $inventory->building_id = $building_id;
        $inventory->building_floor_id = $floor_id;
        $inventory->payment_plan_id = $request->payment_plan_id;
        $inventory->unit_id = $request->unit_id;
        $inventory->area = $request->area;
        $inventory->category_id = $request->category_id;
        if(isset($request->premium_id) && $request->premium_id !== 'regular'){
            $inventory->premium_id = $request->premium_id;
        }
        $inventory->type_id = $request->nature_id;
        $inventory->bed_id = $request->bed;
        $inventory->bath_id = $request->bath;
        $inventory->created_by = Auth::id();
        $inventory->status = 'available';
        $inventory->save();

        $category = Category::findOrFail($request->category_id)->name;
        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building/', $filename);
                $file = 'images/building/' . $filename;
                BuildingInventoryFile::Create(
                    [
                        'building_inventory_id' => $inventory->id,
                        'file' => $file,
                        'type' => 'image',
                    ]);
            }
        }
        if ($inventory) {
            return redirect()->route('building.floor.building_inventory.index', ['RolePrefix' => RolePrefix(), 'building' => $building_id, 'floor' => $floor_id])->with
            ($this->message('Building inventory delete successfully', 'success'));
        } else {
            return redirect()->route('building.floor.building_inventory.index', ['RolePrefix' => RolePrefix(), 'building' => $building_id, 'floor' => $floor_id])->with
            ($this->message('Building inventory delete error', 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($building_id, $floor_id, $id)
    {
        $building_inventory = BuildingInventory::where(['building_id' => $building_id, 'building_floor_id' => $floor_id, 'id' => $id])->first();
        $building_inventory->delete();
        if ($building_inventory) {
            return response()->json(['message'=>'Building inventory has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Building inventory has not deleted, something went wrong. Try again','status'=> 'error']);
        }

    }

    public function image_remove(Request $request)
    {
        $building_inventory_file = BuildingInventoryFile::where(['id' => $request->id, 'building_inventory_id' => $request->inventory_id])->first();
        if ($building_inventory_file !== null) {
            $building_inventory_file->delete();
            unlink('public'.$building_inventory_file->file);
            return json_encode('success');
        } else {
            return json_encode('error');
        }
    }
    public function change_status(Request $request, $project_type_id)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);
        $inventory = get_inventory($project_type_id,$request->id);
        if(!$inventory){
            return response()->json(['message'=>'Inventory not found, something went wrong! try again...','status'=>'error']);
        }
        $status_arr = ['hold','sold'];
        if(in_array($request->status,$status_arr)){
            $request->validate([
//                'name' => 'required',
//                'email' => 'required',
//                'cnic' => 'required',
//                'phone_number' => 'required',
                'amount' => 'required',
            ]);
            $inventory_history = [
                'project_type_id'=>$project_type_id,
                'inventory_id' => $request->id,
                'status' => $request->status,
                'name' => $request->name,
                'email' => $request->email,
                'cnic' => $request->cnic,
                'phone_number' => $request->phone_number,
                'amount' => $request->amount,
                'comment' => $request->comment,
            ];
        }else{
            $inventory_history = [
                'project_type_id'=>$project_type_id,
                'inventory_id' => $request->id,
                'status' => $request->status,
                'comment' => $request->comment,
            ];
        }
        $response = InventoryHistory::create($inventory_history);
        if($response){
            $inventory->status = $request->status;
            $inventory->save();
            return response()->json(['message'=>'Inventory status has been updated successfully!','status'=>'success']);
        }else{
            return response()->json(['message'=>'Inventory status not changed, something went wrong! try again...','status'=>'error']);
        }
    }
}
