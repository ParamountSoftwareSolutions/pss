<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Premium;
use App\Models\Farmhouse;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Size;
use Illuminate\Http\Request;

class SocietyController extends Controller
{
    private $project_type_id;

    public function __construct()
    {
        $id = ProjectType::where('name','society')->first()->id;
        $this->project_type_id = $id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $project_id = get_all_projects()->pluck('project_id')->toArray();
        $projects = Project::whereIn('id',$project_id)->where('type_id',$this->project_type_id)->get();
        return view('user.society.show', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
//        dd($id);
        $sizes = Size::get();
        $project_type_id = $this->project_type_id;
        $premiums = Premium::where('project_type_id',$project_type_id)->get();
        return view('user.society.create', compact('sizes','premiums','project_type_id'));
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
            'name' => 'required',
        ]);
        $project = new Project();
        $project->name = $request->name;
        $project->type_id = $this->project_type_id;
        $project->save();
        if ($request->simple_unit_no == null){
            $request->validate([
                'bulk_unit_no' => 'required',
                'start_unit_no' => 'required',
                'end_unit_no' => 'required',
            ], [
                'end_unit_no' => 'Bulk Fields is required'
            ]);
        }

        if ($request->simple_unit_no == null && $request->bulk_unit_no !== null){
            $length = $request->end_unit_no - $request->start_unit_no;
            for ($i = 0; $length >= $i; $i++){
                $unit = $request->bulk_unit_no . $request->start_unit_no++;
                $farmhouse = new Farmhouse();
                $farmhouse->name = $request->name;
                $farmhouse->project_id = $project->id;
                $farmhouse->unit_no = $unit;
                $farmhouse->size_id = $request->size_id;
                $farmhouse->nature = $request->nature;
                $farmhouse->status = $request->status;
                $farmhouse->premium_id = $request->premium_id;
                $farmhouse->payment_plan_id = $request->payment_plan_id;
                $farmhouse->save();
            }
        }else{
            $farmhouse = new Farmhouse();
            $farmhouse->name = $request->name;
            $farmhouse->project_id = $project->id;
            $farmhouse->unit_no = $request->simple_unit_no;
            $farmhouse->nature = $request->nature;
            $farmhouse->size_id = $request->size_id;
            $farmhouse->status = $request->status;
            $farmhouse->premium_id = $request->premium_id;
            $farmhouse->payment_plan_id = $request->payment_plan_id;
            $farmhouse->save();
        }
        if ($farmhouse) {
            return redirect()->route('farmhouse.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Farmhouse has created successfully', 'alert' => 'success']);
        } else {
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
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $farmhouse = Farmhouse::where('project_id',$id)->first();
        $sizes = Size::get();
        $project_type_id = $this->project_type_id;
        $premiums = Premium::where('project_type_id',$project_type_id)->get();
        return view('user.farmhouse.edit', compact('project','farmhouse', 'sizes','premiums','project_type_id'));

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
        ]);
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->save();
        if ($project){
            return redirect()->route('farmhouse.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Farmhouse has updated successfully', 'alert' => 'success']);
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
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        if ($project){
            return response()->json(['message'=>'Farmhouse has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Farmhouse has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
