<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use App\Models\Type;

class FeatureController extends Controller
{
    public function index($key)
    {
        $arr = ['plot','communication','community','health','other'];
        if(!in_array($key,$arr)){
            return redirect()->back()->with(['message' => 'Features not found, something went wrong. Try again', 'alert' => 'error']);
        }
        $features = Feature::where('key',$key)->get();
        return view('user.inventory_extra_data.features.index', compact('features','key'));
    }

    public function create($key)
    {
        $arr = ['plot','communication','community','health','other'];
        if(!in_array($key,$arr)) {
            return redirect()->back()->with(['message' => 'Feature not found, something went wrong. Try again', 'alert' => 'error']);
        }
        return view('user.inventory_extra_data.features.create',compact('key'));
    }

    public function store(Request $request,$key)
    {
        $arr = ['plot','communication','community','health','other'];
        if(!in_array($key,$arr)){
            return redirect()->back()->with(['message' => 'Feature not found, something went wrong. Try again', 'alert' => 'error']);
        }
        $request->validate([
            'name' => 'required',
        ]);
        $feature = new Feature();
        $feature->name = $request->name;
        $feature->key = $key;
        $feature->save();
        if ($feature) {
            return redirect()->route('feature.index', ['RolePrefix' => RolePrefix(),'key'=>$key])->with(['message' => 'Feature has created successfully', 'alert' => 'success']);
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
    public function show($key)
    {

    }

    public function edit($key,$id)
    {
        $arr = ['plot','communication','community','health','other'];
        if(!in_array($key,$arr)){
            return redirect()->back()->with(['message' => 'Feature not found, something went wrong. Try again', 'alert' => 'error']);
        }
        $feature = Feature::findOrFail($id);
        return view('user.inventory_extra_data.features.edit', compact('key', 'feature'));
    }

    public function update(Request $request,$key, $id)
    {
        $arr = ['plot','communication','community','health','other'];
        if(!in_array($key,$arr)){
            return redirect()->back()->with(['message' => 'Features not found, something went wrong. Try again', 'alert' => 'error']);
        }
        $request->validate([
            'name' => 'required',
        ]);
        $feature = Feature::findOrFail($id);
        $feature->name = $request->name;
        $feature->save();
        if ($feature) {
            return redirect()->route('feature.index', ['RolePrefix' => RolePrefix(),'key'=>$key])->with(['message' => 'Feature has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Feature has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($key,$id)
    {
        $arr = ['plot','communication','community','health','other'];
        if(!in_array($key,$arr)){
            return response()->json(['message' => 'Feature not found, something went wrong. Try again', 'status' => 'error']);
        }
        $feature = Feature::findOrFail($id);
        $feature->delete();

        if ($feature){
            return response()->json(['message'=>'Feature has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Feature has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
