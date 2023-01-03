<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\BuildingAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $about = About::get();
        return view('user.app.about.index', compact('about'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('user.app.about.create');
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
            'description' => 'required',
        ]);
        $about = new About();
        $about->description = $request->description;
        $about->save();
        if ($about) {
            return redirect()->route('about.index',RolePrefix())->with(['alert' => 'success', 'message' => 'Description has been created successfully!']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Description create error']);
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
        $about = About::findOrFail($id);
        return view('user.app.about.edit', compact('about'));
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
        $about = About::findOrFail($id);
        $about->description = $request->description;
        $about->save();
        if ($about) {
            return redirect()->route('about.index',RolePrefix())->with(['success' => 'Description has been updated successfully!']);
        } else {
            return redirect()->back()->with(['error' => 'Description update error']);
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
        $about = About::findOrFail($id);
        $about->delete();
        if ($about) {
            return response()->json(['message'=>'Description has been deleted successfully!','status'=>'success']);
        } else {
            return response()->json(['message'=> 'Description delete error','status'=>'error']);
        }
    }
}
