<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Block::latest()->get();
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
        $block = new Block();
        $block->name = $request->name;
        $block->save();
        if ($block) {
            return redirect()->route('block.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Society Block has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Block has not created, something went wrong. Try again', 'alert' => 'error']);
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
        $block = Block::findOrFail($id);
        return view('user.inventory_extra_data.block.edit', compact('block'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $block = Block::findOrFail($id);
        $block->name = $request->name;
        $block->save();        if ($block){
            return redirect()->route('block.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Block has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Block has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $block = Block::findOrFail($id);
        $block->delete();

        if ($block){
            return response()->json(['message'=>'Block has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Block has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
