<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProjectType;
use App\Models\Size;
use App\Models\Unit;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->get();
        return view('user.inventory_extra_data.size.index', compact('sizes'));
    }

    public function create()
    {
        $project_type = ProjectType::latest()->get();
        return view('user.inventory_extra_data.size.create', compact('project_type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
            'unit' => 'required',
        ]);
        $size = new Size();
        $size->project_type_id = $request->type_id;
        $size->name = $request->name;
        $size->unit = $request->unit;
        $size->save();
        if ($size) {
            return redirect()->route('size.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Size has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Size has not created, something went wrong. Try again', 'alert' => 'error']);
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
        $size = Size::findOrFail($id);
        $project_type = ProjectType::latest()->get();
        return view('user.inventory_extra_data.size.edit', compact('size', 'project_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
            'unit' => 'required',
        ]);
        $size = Size::findOrFail($id);
        $size->project_type_id = $request->type_id;
        $size->name = $request->name;
        $size->unit = $request->unit;
        $size->save();
        if ($size){
            return redirect()->route('size.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Size has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Size has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        if ($size){
            return response()->json(['message'=>'Size has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Size has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
