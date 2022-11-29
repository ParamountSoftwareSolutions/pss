<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $blocks = SocietyBlock::get();
        return view('user.inventory_extra_data.block.index', compact('blocks'));
    }

    public function create()
    {
        return view('user.inventory_extra_data.block.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $block = new SocietyBlock();
        $block->name = $request->name;
        $block->save();
        if ($block) {
            return redirect()->route('block.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Size has created successfully', 'alert' => 'success']);
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
        $block = SocietyBlock::findOrFail($id);
        return view('user.inventory_extra_data.block.edit', compact('block'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $block = SocietyBlock::findOrFail($id);
        $block->name = $request->name;
        $block->save();
        if ($block){
            return redirect()->route('block.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Size has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Size has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $block = SocietyBlock::findOrFail($id);
        $block->delete();

        if ($block){
            return response()->json(['message'=>'Size has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Size has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
