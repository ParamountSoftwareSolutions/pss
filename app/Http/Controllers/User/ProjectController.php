<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Block;
use App\Models\Building;
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
        $projects = Project::latest()->get();
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
        $request->validate([
            'project_type_id' => 'required',
            'project_type_id' => 'required',
            'project_type_id' => 'required',
            'project_type_id' => 'required',
            'project_type_id' => 'required',
            'project_type_id' => 'required',
        ]);

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
                Society::create(['project_id' => $project->id]);
            } elseif ($type == 'building') {
                Building::create(['project_id' => $project->id]);
            }
            if ($project) {
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
        $project = Project::findOrFail($id);
        $project_type = ProjectType::latest()->get();
        return view('user.project.edit', compact('project', 'project_type'));

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
            'type_id' => 'required',
        ]);
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->type_id = $request->type_id;
        $project->save();
        if ($project) {
            return redirect()->route('project.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Project has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Project has not updated, something went wrong. Try again', 'alert' => 'error']);
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
