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
        $unit = Unit::latest()->get();
        return view('user.inventory_extra_data.size.create', compact('project_type', 'unit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
            'unit_id' => 'required',
        ]);
        $size = new Size();
        $size->project_type_id = $request->type_id;
        $size->name = $request->name;
        $size->unit_id = $request->unit_id;
        $size->save();
        if ($size) {
            return redirect()->route('size.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Size create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Size create error', 'alert' => 'error']);
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
        $unit = Unit::latest()->get();
        return view('user.inventory_extra_data.size.edit', compact('size', 'project_type', 'unit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
        ]);
        $size = Size::findOrFail($id);
        $size->project_type_id = $request->type_id;
        $size->name = $request->name;
        $size->save();
        if ($size){
            return redirect()->route('size.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Size update successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Size update error', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        if ($size){
            return redirect()->route('size.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Size create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Size create error', 'alert' => 'error']);
        }
    }
}
