<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Size;
use Illuminate\Http\Request;

class FarmhouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $projects = Project::where('type_id',3)->get();
        return view('user.farmhouse.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $project_type = ProjectType::get();
        $sizes = Size::get();
        return view('user.farmhouse.create', compact('project_type','sizes'));
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
        $project->type_id = 3;
        $project->save();
        if ($project){
            return redirect()->route('farmhouse.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Farmhouse has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Farmhouse has not created, something went wrong. Try again', 'alert' => 'error']);
        }




        if ($request->simple_unit_no == null){
            $request->validate([
                'bulk_unit_no' => 'required',
                'start_unit_no' => 'required',
                'end_unit_no' => 'required',
            ], [
                'end_unit_no' => 'Bulck Fields is required'
            ]);
        }

        if ($request->simple_unit_no == null && $request->bulk_unit_no !== null){
            $length = $request->end_unit_no - $request->start_unit_no;
            for ($i = 0; $length >= $i; $i++){
                $unit = $request->bulk_unit_no . $request->start_unit_no++;
                $inventory = new BuildingInventory();
                $inventory->building_id = $request->building_id;
                $inventory->block_id = $request->block_id;
                $inventory->unit_no = $unit;
                $inventory->size_id = $request->size_id;
                $inventory->category_id = $request->category_id;
                $inventory->nature = $request->nature;
                $inventory->type = $request->type;
                $inventory->purchased_price = $request->purchased_price;
                $inventory->sold_price = $request->sold_price;
                $inventory->down_payment = $request->down_payment;
                $inventory->status = $request->status;
                $inventory->save();
            }
        }else{
            $formhouse = new Farmhouse();
            $formhouse->name = $request->name;
            $formhouse->unit_no = $request->simple_unit_no;
            $formhouse->down_payment = $request->down_payment;
            $formhouse->nature = $request->nature;
            $formhouse->type = $request->type;
            $formhouse->size_id = $request->size_id;
            $formhouse->status = $request->status;
            $formhouse->save();
        }
        if ($inventory) {
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
        $project_type = ProjectType::get();
        $sizes = Size::get();
        return view('user.farmhouse.edit', compact('project', 'project_type','sizes'));

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
