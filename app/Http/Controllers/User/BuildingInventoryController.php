<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingFloor;
use App\Models\BuildingInventory;
use App\Models\BuildingInventoryFile;
use App\Models\Category;
use App\Models\FloorDetailFile;
use App\Models\PaymentPlan;
use App\Models\Premium;
use App\Models\Size;
use App\Models\Type;
use App\Models\Unit;
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
        $bed = Size::where('unit_id', 'bed')->whereHas('project_type', function ($q) {
            $q->where('name', 'building');
        })->get();
        $bath = Size::where('unit_id', 'bath')->whereHas('project_type', function ($q) {
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
        //dd($building_id, $floor_id, $request->all());
        $request->validate([
            'payment_plan_id' => 'required',
            'category_id' => 'required',
        ]);
        $request->validate([
            'bulk_unit_no' => 'required',
            'start_unit_no' => 'required',
            'end_unit_no' => 'required',
        ], [
            'end_unit_no' => 'Bulck Fields is required'
        ]);
        $building = Building::with('project')->findOrFail($building_id);

        try {
            foreach ($request->bulk_unit_no as $key => $data) {
                $length = $request->end_unit_no[$key] - $request->start_unit_no[$key];
                for ($i = 0; $i <= $length; $i++) {
                    $unit_no = $request->start_unit_no[$key] + $i;
                    $unit = $request->bulk_unit_no[$key] . $unit_no;
                    //print_r($unit. "<br>");
                    $inventory = new BuildingInventory();
                    $inventory->building_id = $building_id;
                    $inventory->project_id = $building->project->id;
                    $inventory->building_floor_id = $floor_id;
                    $inventory->payment_plan_id = $request->payment_plan_id[$key];
                    $inventory->unit_id = $unit;
                    $inventory->area = $request->area[$key];
                    $inventory->category_id = $request->category_id[$key];
                    $inventory->premium_id = $request->premium_id[$key];
                    $inventory->type_id = $request->nature_id[$key];
                    $inventory->bed_id = $request->bed[$key];
                    $inventory->bath_id = $request->bath[$key];
                    $inventory->created_by = Auth::id();
                    $inventory->status = 'available';
                    $inventory->save();

                    $category = Category::findOrFail($request->category_id[$key])->name;
                    if ($category == 'Shop') {
                        /*if ($request->has('images')) {
                            foreach ($request->file('images') as $file) {
                                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                                $file->move('images/building/', $filename);
                                $file = 'images/building/' . $filename;
                                BuildingInventoryFile::Create(
                                    [
                                        'building_inventory_id' => $inventory->id,
                                        'file' => $file,
                                        'type' => 'image',
                                    ]);
                            }
                        } else {*/
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
            }
            return redirect()->route('building.floor.building_inventory.index', ['RolePrefix' => RolePrefix(), 'building' => $building_id, 'floor' => $floor_id])->with($this->message('Building inventory created successfully', 'success'));
        } catch (Exception $e) {
            return redirect()->back()->with($this->message($e->getMessage(), 'error'));
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
        $payment_plan = PaymentPlan::whereHas('type', function ($q) {
            $q->where('name', 'building');
        })->get();
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
        return view('user.building_inventory.edit', compact('building_id', 'floor_id', 'building', 'payment_plan', 'category', 'premium', 'bed', 'bath', 'nature', 'inventory'));

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
        $inventory->premium_id = $request->premium_id;
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
        $building_inventory = BuildingInventory::where(['building-id' => $building_id, 'building_floor_id' => $floor_id, 'id' => $id])->first();
        $building_inventory->delete();
        if ($building_inventory) {
            return redirect()->back()->with($this->message('Building inventory delete successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Building inventory delete error', 'error'));
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
}
