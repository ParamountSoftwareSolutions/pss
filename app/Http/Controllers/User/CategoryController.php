<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('user.inventory_extra_data.category.index', compact('categories'));
    }

    public function create()
    {
        $project_type = ProjectType::latest()->get();
        return view('user.inventory_extra_data.category.create', compact('project_type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
        ]);
        $category = new Category();
        $category->project_type_id = $request->type_id;
        $category->name = $request->name;
        $category->save();
        if ($category) {
            return redirect()->route('category.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Category create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Category create error', 'alert' => 'error']);
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
        $category = Category::findOrFail($id);
        $project_type = ProjectType::latest()->get();
        return view('user.inventory_extra_data.category.edit', compact('category', 'project_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_id' => 'required',
            'name' => 'required',
        ]);
        $category = Category::findOrFail($id);
        $category->project_type_id = $request->type_id;
        $category->name = $request->name;
        $category->save();
        if ($category){
            return redirect()->route('category.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Category update successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Category update error', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category){
            return redirect()->route('category.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Category create successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Category create error', 'alert' => 'error']);
        }
    }
}
