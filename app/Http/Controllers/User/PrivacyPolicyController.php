<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingPrivacyPolicie;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Help;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $privacyPolicy = PrivacyPolicy::get();
        return view('user.app.privacyPolicy.index', compact('privacyPolicy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('user.app.privacyPolicy.create');
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
        $privacyPolicy = new PrivacyPolicy();
        $privacyPolicy->description = $request->description;
        $privacyPolicy->save();
        if ($privacyPolicy) {
            return redirect()->route('privacy_policy.index',RolePrefix())->with(['alert' => 'success', 'message' => 'Description has been created successfully!']);
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
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        return view('user.app.privacyPolicy.edit', compact('privacyPolicy'));
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
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        $privacyPolicy->description = $request->description;
        $privacyPolicy->save();
        if ($privacyPolicy) {
            return redirect()->route('privacy_policy.index',RolePrefix())->with(['success' => 'Description has been updated successfully!']);
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
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        $privacyPolicy->delete();
        if ($privacyPolicy) {
            return response()->json(['message'=>'Description has been deleted successfully!','status'=>'success']);
        } else {
            return response()->json(['message'=> 'Description delete error','status'=>'error']);
        }
    }
}
