<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Project;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $projects = Project::get();
        return view('user.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $project_type = ProjectType::get();
        return view('user.project.create', compact('project_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required',
        ]);
        $project = new Project();
        $project->name = $request->name;
        $project->type_id = $request->type_id;
        $project->save();
        if ($project){
            return redirect()->route('project.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Project has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Project has not created, something went wrong. Try again', 'alert' => 'error']);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $project_type = ProjectType::get();
        return view('user.project.edit', compact('project', 'project_type'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required',
        ]);
        $project = Project::findOrFail($id);
        $project->name = $request->name;
        $project->type_id = $request->type_id;
        $project->save();
        if ($project){
            return redirect()->route('project.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Project has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Project has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        if ($project){
            return response()->json(['message'=>'Project has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Project has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
