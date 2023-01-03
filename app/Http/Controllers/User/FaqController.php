<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingFaq;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $faqs = Faq::get();
        return view('user.app.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('user.app.faq.create');
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
        $faq = new Faq();
        $faq->description = $request->description;
        $faq->save();
        if ($faq) {
            return redirect()->route('faq.index', RolePrefix())->with(['alert' => 'success', 'message' => 'Description has been created successfully!']);
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
        $faq = Faq::findOrFail($id);
        return view('user.app.faq.edit', compact('faq'));
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
            'description' => 'required',
        ]);
        $faq = Faq::findOrFail($id);
        $faq->description = $request->description;
        $faq->save();
        if ($faq) {
            return redirect()->route('faq.index', RolePrefix())->with(['success' => 'Description has been updated successfully!']);
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
        $faq = Faq::findOrFail($id);
        $faq->delete();
        if ($faq) {
            return response()->json(['message' => 'Description has been deleted successfully!', 'status' => 'success']);
        } else {
            return response()->json(['message' => 'Description delete error', 'status' => 'error']);
        }
    }
}
