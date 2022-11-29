<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProjectType;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::get();
        return view('user.inventory_extra_data.unit.index', compact('units'));
    }

    public function create()
    {
        return view('user.inventory_extra_data.unit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->save();
        if ($unit) {
            return redirect()->route('unit.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Unit create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Unit create error', 'alert' => 'error']);
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
        $unit = Unit::findOrFail($id);
        return view('user.inventory_extra_data.unit.edit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $unit = Unit::findOrFail($id);
        $unit->name = $request->name;
        $unit->save();
        if ($unit){
            return redirect()->route('unit.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Unit update successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Unit update error', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        if ($unit){
            return redirect()->route('unit.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Unit create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Unit create error', 'alert' => 'error']);
        }
    }
}
