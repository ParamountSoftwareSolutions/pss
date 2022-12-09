<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use App\Models\Type;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::get();
        return view('user.inventory_extra_data.features.index', compact('features'));
    }

    public function create()
    {
        $project_type = ProjectType::get();
        return view('user.inventory_extra_data.type.create', compact('project_type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
        ]);
        $type = new Type();
        $type->project_type_id = $request->type_id;
        $type->name = $request->name;
        $type->save();
        if ($type) {
            return redirect()->route('type.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Type has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Type has not created, something went wrong. Try again', 'alert' => 'error']);
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

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        $project_type = ProjectType::get();
        return view('user.inventory_extra_data.type.edit', compact('type', 'project_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $type = Type::findOrFail($id);
        $type->project_type_id = $request->type_id;
        $type->name = $request->name;
        $type->save();
        if ($type){
            return redirect()->route('type.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Type has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Type has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        if ($type){
            return response()->json(['message'=>'Type has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Type has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
