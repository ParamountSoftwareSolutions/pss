<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingFile;
use App\Models\BuildingFloor;
use App\Models\BuildingInventory;
use App\Models\Project;
use App\Models\Size;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $project = get_all_projects('building');
        $buildings = Building::with('project', 'building_file')->whereIn('project_id', $project->pluck('id')->toArray())->latest()->get();
        return view('user.building.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $building = Building::findOrFail($id);
        return view('user.building.floor_index', compact('building'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $building = Building::with('project', 'building_file')->findOrFail($id);
        $floor = BuildingFloor::get();
        $unit = Unit::where('name', 'bed')->get();
        $size = Size::where('project_type_id', project_type('building'))->whereIn('unit_id', $unit->pluck('id')->toArray())->get();
        return view('user.building.edit', compact('floor', 'building', 'size'));
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
            'floor_list' => 'required',
            'type' => 'required',
            //'main_image' => 'required',
        ]);
        $building = Building::findOrFail($id);
        $building->floor_list = json_encode($request->floor_list);
        $building->type = json_encode($request->type);
        $building->apartment_size = json_encode($request->apartment_size);
        $building->address = $request->address;
        $building->total_area = $request->total_area;
        $building->save();
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
            $file->move('images/building/logo/', $filename);
            $logo = asset('images/building/logo/' . $filename);
            BuildingFile::create([
                'building_id' => $building->id,
                'file' => $logo,
                'type' => 'logo',
            ]);
        }
        if ($request->file('main_image')) {
            $file = $request->file('main_image');
            $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
            $file->move('images/building/logo/', $filename);
            $main_image = asset('images/building/logo/' . $filename);
            BuildingFile::create([
                'building_id' => $building->id,
                'file' => $main_image,
                'type' => 'main_image',
            ]);
        }
        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('images/building/', $filename);
                $image = asset('images/building/' . $filename);
                BuildingFile::create([
                    'building_id' => $building->id,
                    'file' => $image,
                    'type' => 'image',
                ]);
            }
        }


        if ($building) {
            return redirect()->route('building.index', ['RolePrefix' => RolePrefix()])->with($this->message('Building has created SuccessFully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Building has not created, something went wrong. Try again", 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
