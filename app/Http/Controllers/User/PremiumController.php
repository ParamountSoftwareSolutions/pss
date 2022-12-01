<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Premium;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    public function index()
    {
        $premiums = Premium::latest()->get();
        return view('user.inventory_extra_data.premium.index', compact('premiums'));
    }

    public function create()
    {
        $project_type = ProjectType::latest()->get();
        return view('user.inventory_extra_data.premium.create', compact('project_type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
        ]);
        $premium = new Premium();
        $premium->project_type_id = $request->type_id;
        $premium->name = $request->name;
        $premium->save();
        if ($premium) {
            return redirect()->route('premium.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Premium Type has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Premium Type has not created, something went wrong. Try again', 'alert' => 'error']);
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
        $premium = Premium::findOrFail($id);
        $project_type = ProjectType::latest()->get();
        return view('user.inventory_extra_data.premium.edit', compact('premium', 'project_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
        ]);
        $premium = Premium::findOrFail($id);
        $premium->project_type_id = $request->type_id;
        $premium->name = $request->name;
        $premium->save();
        if ($premium){
            return redirect()->route('premium.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Premium Type has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Premium Type has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $premium = Premium::findOrFail($id);
        $premium->delete();

        if ($premium){
            return response()->json(['message'=>'Premium Type has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Premium Type has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
    public function get_premium($type_id)
    {
        $premiums = Premium::where('project_type_id',$type_id)->get();
        return response()->json($premiums);
    }
}
