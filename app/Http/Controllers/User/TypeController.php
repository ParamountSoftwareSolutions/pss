<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectType;

class TypeController extends Controller
{
    public function index()
    {
        $types = ProjectType::get();
        return view('user.inventory_extra_data.type.index', compact('types'));
    }

    public function create()
    {
        return view('user.inventory_extra_data.type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $block = new ProjectType();
        $block->name = $request->name;
        $block->save();
        if ($block) {
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
        $type = ProjectType::findOrFail($id);
        return view('user.inventory_extra_data.type.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $block = ProjectType::findOrFail($id);
        $block->name = $request->name;
        $block->save();
        if ($block){
            return redirect()->route('type.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Type has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Type has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $block = ProjectType::findOrFail($id);
        $block->delete();

        if ($block){
            return response()->json(['message'=>'Type has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Type has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
