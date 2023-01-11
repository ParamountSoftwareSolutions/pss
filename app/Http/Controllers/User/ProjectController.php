<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Block;
use App\Models\Building;
use App\Models\BuildingDetail;
use App\Models\BuildingDetailFile;
use App\Models\BuildingFloor;
use App\Models\BuildingInventory;
use App\Models\Category;
use App\Models\Country;
use App\Models\Farmhouse;
use App\Models\Feature;
use App\Models\NocType;
use App\Models\Project;
use App\Models\ProjectAssignUser;
use App\Models\ProjectType;
use App\Models\Property;
use App\Models\Size;
use App\Models\Society;
use App\Models\SocietyInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $projects = get_all_projects();
        return view('user.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
//        $i=1;
//        $x=0;
//        $n=0;
//        while($i<10){
//            if($i<=5){
//                echo $i."<br>";
//            }
//            $i++;
//            if($i>5){
//                $x=$x+2;
//                $n = $i-$x;
//                echo $n."<br>";
//            }
//        }
//        die();
        $project = Project::get();
        $project_type = ProjectType::latest()->get();
        $floor = BuildingFloor::get();
        $building_category = Category::where('project_type_id', project_type('building'))->get();
        $building_size = Size::where('project_type_id', project_type('building'))->where('unit', 'bed')->get();

        $society_size = Size::where('project_type_id', project_type('society'))->get();
        $society_category = Category::where('project_type_id', project_type('society'))->get();
        $noc = NocType::get();
        $society_block = Block::where('project_type_id', project_type('society'))->get();

        $formhouse_block = Block::where('project_type_id', project_type('farm_house'))->get();
        $formhouse_category = Category::where('project_type_id', project_type('farm_house'))->get();

        $plot_features = Feature::where('key','plot')->get();
        $communication_features = Feature::where('key','communication')->get();
        $community_features = Feature::where('key','community')->get();
        $health_features = Feature::where('key','health')->get();
        $other_features = Feature::where('key','other')->get();
        return view('user.project.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
////        dd($request->all());
//        dd(json_encode($request->apartment_size));
        $request->validate([
            'project_type_id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'total_area' => 'required',
        ]);
        if($request->project_type_id == 4){
            return redirect()->back()->with($this->message('Project Type is not defined', 'warning'));
        }

        $project_limit = Project::get();
        if (Auth::user()->project == count($project_limit)) {
            return redirect()->back()->with($this->message('Project Limit Complete. Please Contact Super Admin', 'warning'));
        } else {
            $project = new Project();
            $project->name = $request->name;
            $project->type_id = $request->project_type_id;
            $project->save();

            $project_assign_user = new ProjectAssignUser();
            $project_assign_user->project_id = $project->id;
            $project_assign_user->user_id = Auth::user()->id;
            $project_assign_user->save();

            $type = ProjectType::findOrFail($request->project_type_id)->name;


            if ($type == 'society') {
                $request->validate([
                    'noc_type_id' => 'required',
                    'society_type' => 'required',
                    'society_block' => 'required',
                ]);
                $society = [
                    'project_id' => $project->id,
                    'address' => $request->address,
                    'area' => $request->total_area,
                    'developer' => $request->developer,
                    'noc_type_id' => $request->noc_type_id,
                    'type' => json_encode($request->society_type),
                    'block' => json_encode($request->society_block),
                    'created_by' => Auth::user()->id,
                    ];
                $response = Society::create($society);
                $data = [];
                if(!empty($request->society)){
                    foreach ($request->society as $key => $detail){
                        $size = [];
                        foreach ($detail['sizes'] as $key1 => $val){
                            $size[$key1 ] = ['size'=>$val['size'],'price'=>$val['price']];
                        }
                        $data[$key] = ['price' => $detail['price'], 'sizes' => $size];
                    }
                }
                $data = json_encode($data);
            } elseif ($type == 'building') {
                $request->validate([
                    'floor_list' => 'required',
                    'apartment_size' => 'required',
                    'building_type' => 'required',
                ]);
                $building = [
                    'project_id' => $project->id,
                    'address' => $request->address,
                    'area' => $request->total_area,
                    'developer' => $request->developer,
                    'type' => json_encode($request->building_type),
                    'floor_list' => json_encode($request->floor_list),
                    'apartment_size' => json_encode($request->apartment_size),
                    'created_by' => Auth::user()->id,
                ];
                $response = Building::create($building);
                $data = [];
                if(!empty($request->detail)){
                    foreach ($request->detail as $key => $detail){
                        $data['bed'][$key] = ['building' => $detail['building'], 'area' => $detail['area'], 'bed' => $key, 'bath' => $detail['bath'], 'price' => $detail['price']];
                    }
                    foreach ($request->shop_detail as $key => $detail){
                        $data[$key] = ['floor' => $detail['floor'], 'area' => $detail['floor_area'], 'price' => $detail['floor_price']];
                    }
                }
                $data = json_encode($data);
            } elseif ($type == 'farm_house') {
                $request->validate([
                    'farmhouse_type' => 'required',
                    'farmhouse_block' => 'required',
                ]);
                $farmhouse = [
                    'project_id' => $project->id,
                    'address' => $request->address,
                    'area' => $request->total_area,
                    'developer' => $request->developer,
                    'type' => json_encode($request->farmhouse_type),
                    'block' => json_encode($request->farmhouse_block),
                    'created_by' => Auth::user()->id,
                ];
                $response = Farmhouse::create($farmhouse);
                $data = [];
                if(!empty($request->farmhouse)){
                    foreach ($request->farmhouse as $key => $detail){
                        $data[$key] = ['area' => $detail['area'],'price' => $detail['price']];
                    }
                }
                $data = json_encode($data);
            }
            $plot_feature = isset($request->plot_feature) ? json_encode($request->plot_feature) : null;
            $communication_feature = isset($request->communication_feature) ? json_encode($request->communication_feature) : null;
            $community_feature = isset($request->community_feature) ? json_encode($request->community_feature) : null;
            $health_feature = isset($request->health_feature) ? json_encode($request->health_feature) : null;
            $other_feature = isset($request->other_feature) ? json_encode($request->other_feature) : null;
            $extra_detail = [
                'project_id' => $project->id,
                'address' => $request->address,
                'price' => $request->price,
                'developer' => $request->developer,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'description' => $request->description,
                'property_type' => $data,
                'plot_feature' => $plot_feature,
                'communication_feature' => $communication_feature,
                'community_feature' => $community_feature,
                'health_feature' => $health_feature,
                'other_feature' => $other_feature,
                'created_by' => Auth::user()->id,
            ];
            $building_detail = BuildingDetail::create($extra_detail);

            if ($request->has('logo_images')) {
                foreach ($request->file('logo_images') as $file) {
                    $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                    $file->move('public/images/building_detail/logo', $filename);
                    $file = 'images/building_detail/logo/' . $filename;
                    BuildingDetailFile::create([
                        'building_detail_id' => $building_detail->id,
                        'file' => $file,
                        'type' => 'logo'
                    ]);
                }
            }
            if ($request->has('images')) {
                foreach ($request->file('images') as $file) {
                    $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                    $file->move('public/images/building_detail/payment', $filename);
                    $file = 'images/building_detail/payment/' . $filename;
                    BuildingDetailFile::create([
                        'building_detail_id' => $building_detail->id,
                        'file' => $file,
                        'type' => 'payment_plan'
                    ]);
                }
            }

            if ($request->project_type_id == 1 && $request->has('floor_images')) {
                foreach ($request->file('floor_images') as $file) {
                    $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                    $file->move('public/images/building_detail/floor/', $filename);
                    $file = 'images/building_detail/floor/' . $filename;
                    BuildingDetailFile::create([
                        'building_detail_id' => $building_detail->id,
                        'file' => $file,
                        'type' => 'floor_plan'
                    ]);
                }
            }
            if ($response) {
                return redirect()->route('project.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Project has created successfully', 'alert' => 'success']);
            } else {
                return redirect()->back()->with(['message' => 'Project create delete', 'alert' => 'success']);
            }
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
    public function edit($id)
    {
        $project = Project::with('building_detail')->findOrFail($id);
        if($project->type_id == 1){
            $project_detail = Building::where('project_id',$id)->first();
        }
        elseif($project->type_id == 2){
            $project_detail = Society::where('project_id',$id)->first();
        }
        elseif($project->type_id == 3){
            $project_detail = Farmhouse::where('project_id',$id)->first();
        }else{
            $project_detail = Property::where('project_id',$id)->first();
        }

        $floor = BuildingFloor::get();
        $building_category = Category::where('project_type_id', project_type('building'))->get();
        $building_size = Size::where('project_type_id', project_type('building'))->where('unit', 'bed')->get();

        $society_size = Size::where('project_type_id', project_type('society'))->get();
        $society_category = Category::where('project_type_id', project_type('society'))->get();
        $noc = NocType::get();
        $society_block = Block::where('project_type_id', project_type('society'))->get();

        $formhouse_block = Block::where('project_type_id', project_type('farm_house'))->get();
        $formhouse_category = Category::where('project_type_id', project_type('farm_house'))->get();

        $plot_features = Feature::where('key','plot')->get();
        $communication_features = Feature::where('key','communication')->get();
        $community_features = Feature::where('key','community')->get();
        $health_features = Feature::where('key','health')->get();
        $other_features = Feature::where('key','other')->get();
        return view('user.project.edit', get_defined_vars());

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
            'address' => 'required',
            'total_area' => 'required',
        ]);
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->save();
        $type = ProjectType::findOrFail($project->type_id)->name;

        if ($type == 'society') {
            $request->validate([
                'noc_type_id' => 'required',
                'society_type' => 'required',
                'society_block' => 'required',
            ]);
            $society = [
                'project_id' => $project->id,
                'address' => $request->address,
                'area' => $request->total_area,
                'developer' => $request->developer,
                'noc_type_id' => $request->noc_type_id,
                'type' => json_encode($request->society_type),
                'block' => json_encode($request->society_block),
                'created_by' => Auth::user()->id,
            ];
            $response = Society::where('project_id',$id)->first()->update($society);
            $data = [];
            foreach ($request->society as $key => $detail){
                $size = [];
                foreach ($detail['sizes'] as $key1 => $val){
                    $size[$key1 ] = ['size'=>$val['size'],'price'=>$val['price']];
                }
                $data[$key] = ['price' => $detail['price'], 'sizes' => $size];
            }
            $data = json_encode($data);
        } elseif ($type == 'building') {
            $request->validate([
                'floor_list' => 'required',
                'apartment_size' => 'required',
                'building_type' => 'required',
            ]);
            $building = [
                'project_id' => $project->id,
                'address' => $request->address,
                'area' => $request->total_area,
                'developer' => $request->developer,
                'type' => json_encode($request->building_type),
                'floor_list' => json_encode($request->floor_list),
                'apartment_size' => json_encode($request->apartment_size),
                'created_by' => Auth::user()->id,
            ];
            $response = Building::where('project_id',$id)->first()->update($building);
            $data = [];
            foreach ($request->detail as $key => $detail){
                $data['bed'][$key] = ['building' => $detail['building'], 'area' => $detail['area'], 'bed' => $key, 'bath' => $detail['bath'], 'price' => $detail['price']];
            }
            foreach ($request->shop_detail as $key => $detail){
                $data[$key] = ['floor' => $detail['floor'], 'area' => $detail['floor_area'], 'price' => $detail['floor_price']];
            }
            $data = json_encode($data);
        } elseif ($type == 'farm_house') {
            $request->validate([
                'farmhouse_type' => 'required',
                'farmhouse_block' => 'required',
            ]);
            $farmhouse = [
                'project_id' => $project->id,
                'address' => $request->address,
                'area' => $request->total_area,
                'developer' => $request->developer,
                'type' => json_encode($request->farmhouse_type),
                'block' => json_encode($request->farmhouse_block),
                'created_by' => Auth::user()->id,
            ];
            $response = Farmhouse::where('project_id',$id)->first()->update($farmhouse);
            $data = [];
            foreach ($request->farmhouse as $key => $detail){
                $data[$key] = ['area' => $detail['area'],'price' => $detail['price']];
            }
            $data = json_encode($data);
        }

        $plot_feature = isset($request->plot_feature) ? json_encode($request->plot_feature) : null;
        $communication_feature = isset($request->communication_feature) ? json_encode($request->communication_feature) : null;
        $community_feature = isset($request->community_feature) ? json_encode($request->community_feature) : null;
        $health_feature = isset($request->health_feature) ? json_encode($request->health_feature) : null;
        $other_feature = isset($request->other_feature) ? json_encode($request->other_feature) : null;
        $extra_detail = [
            'project_id' => $project->id,
            'address' => $request->address,
            'price' => $request->price,
            'developer' => $request->developer,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'property_type' => $data,
            'plot_feature' => $plot_feature,
            'communication_feature' => $communication_feature,
            'community_feature' => $community_feature,
            'health_feature' => $health_feature,
            'other_feature' => $other_feature,
            'created_by' => Auth::user()->id,
        ];
        $building_detail = BuildingDetail::where('project_id',$id)->first()->update($extra_detail);
        if($building_detail){
            if ($request->has('logo_images')) {
                foreach ($request->file('logo_images') as $file) {
                    $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                    $file->move('public/images/building_detail/logo', $filename);
                    $file = 'images/building_detail/logo/' . $filename;
                    BuildingDetailFile::create([
                        'building_detail_id' => $project->building_detail->id,
                        'file' => $file,
                        'type' => 'logo'
                    ]);
                }
            }
            if ($request->has('images')) {
                foreach ($request->file('images') as $file) {
                    $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                    $file->move('public/images/building_detail/payment', $filename);
                    $file = 'images/building_detail/payment/' . $filename;
                    BuildingDetailFile::create([
                        'building_detail_id' => $project->building_detail->id,
                        'file' => $file,
                        'type' => 'payment_plan'
                    ]);
                }
            }

            if ($project->type_id == 1 && $request->has('floor_images')) {
                foreach ($request->file('floor_images') as $file) {
                    $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                    $file->move('public/images/building_detail/floor/', $filename);
                    $file = 'images/building_detail/floor/' . $filename;
                    BuildingDetailFile::create([
                        'building_detail_id' => $project->building_detail->id,
                        'file' => $file,
                        'type' => 'floor_plan'
                    ]);
                }
            }
        }
        if ($response) {
            return redirect()->route('project.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Project has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Project create delete', 'alert' => 'success']);
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
        $project = Project::findOrFail($id);
        $project->delete();
        if ($project) {
            return response()->json(['message' => 'Project has deleted successfully', 'status' => 'success']);
        } else {
            return response()->json(['message' => 'Project has not deleted, something went wrong. Try again', 'status' => 'error']);
        }
    }

    public function get_project($id)
    {
        $projects = Project::where('type_id',$id)->get();
        return response()->json($projects);
    }

    public function get_inventories($id)
    {
        $project = Project::where('id',$id)->first();
        if($project->type_id == 1){
            $inventories = BuildingInventory::where('project_id',$id)->get();
        }
        elseif($project->type_id == 2){
            $inventories = SocietyInventory::where('project_id',$id)->get();
        }
        elseif($project->type_id == 3){
            $inventories = Farmhouse::where('project_id',$id)->get();
        }else{
            $inventories = null;
        }
        return response()->json($inventories);
    }
    public function get_floor_block($project_id)
    {
        $project = Project::where('id',$project_id)->first();
        if($project->type_id == 1){
            $building = Building::where('project_id',$project_id)->first();
            $block_id = json_decode($building->floor_list,true);
            $floors = BuildingFloor::whereIn('id',$block_id)->get();
        }
        elseif($project->type_id == 2){
            $society = Society::where('project_id',$project_id)->first();
            $block_id = json_decode($society->block,true);
            $floors = Block::whereIn('id',$block_id)->get();
        }else{
            $floors = null;
        }
        return response()->json($floors);
    }
}
