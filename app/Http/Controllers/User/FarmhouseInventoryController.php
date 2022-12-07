<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\FarmhouseFile;
use App\Models\Premium;
use App\Models\Farmhouse;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Size;
use Illuminate\Http\Request;

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
        $farmhouses = Farmhouse::where('project_id',$id)->get();
        return view('user.farmhouse.index', compact('farmhouses','id'));
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
        return view('user.farmhouse.create', compact('project','sizes','premiums','project_type_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request,$id)
    {
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
                $farmhouse->project_id = $id;
                $farmhouse->unit_no = $unit;
                $farmhouse->size_id = $request->size_id;
                $farmhouse->premium_id = $request->premium_id;
                $farmhouse->payment_plan_id = $request->payment_plan_id;
                $farmhouse->save();
            }
        }else{
            $farmhouse = new Farmhouse();
            $farmhouse->project_id = $id;
            $farmhouse->unit_no = $request->simple_unit_no;
            $farmhouse->size_id = $request->size_id;
            $farmhouse->premium_id = $request->premium_id;
            $farmhouse->payment_plan_id = $request->payment_plan_id;
            $farmhouse->save();
        }
        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('images/farmhouse/', $filename);
                $file = 'images/farmhouse/' . $filename;
                FarmhouseFile::create([
                    'farmhouse_id' => $farmhouse->id,
                    'file' => $file,
                ]);
            }
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
    public function edit($project_id,$farmhouse_id)
    {
        $project = Project::findOrFail($project_id);
        $farmhouse = Farmhouse::with('files')->where('project_id',$project_id)->findOrFail($farmhouse_id);
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
