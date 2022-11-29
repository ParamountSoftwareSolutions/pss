<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('user.inventory_extra_data.category.index', compact('categories'));
    }

    public function create()
    {
        return view('user.inventory_extra_data.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        if ($category) {
            return redirect()->route('category.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Category has created successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Category has not created, something went wrong. Try again', 'alert' => 'error']);
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
        return view('user.inventory_extra_data.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        if ($category){
            return redirect()->route('category.index', ['RolePrefix' => RolePrefix()])->with(['message' => 'Category has updated successfully', 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => 'Category has not updated, something went wrong. Try again', 'alert' => 'error']);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category){
            return response()->json(['message'=>'Category has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Category has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
}
