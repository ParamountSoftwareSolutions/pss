<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SocietyBlock;
use Illuminate\Http\Request;

class BlockController extends Controller
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
            return redirect()->route('block.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Society Block create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Society Block create error', 'alert' => 'error']);
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
            return redirect()->route('block.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Society Block update successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Society Block update error', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $block = SocietyBlock::findOrFail($id);
        $block->delete();

        if ($block){
            return redirect()->route('block.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Block create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Block create error', 'alert' => 'error']);
        }
    }
}
