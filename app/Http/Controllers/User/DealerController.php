<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\BuildingAbout;
use App\Models\Dealer;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $dealers = Dealer::get();
        return view('user.dealer.index', compact('dealers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $types = ProjectType::get();
        return view('user.dealer.create',get_defined_vars());
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
            'email' => 'required|unique:dealers',
            'cnic' => 'required|unique:dealers',
            'number' => 'required|unique:dealers',
        ]);
        $dealer = new Dealer();
        $dealer->name = $request->name;
        $dealer->email = $request->email;
        $dealer->cnic = $request->cnic;
        $dealer->number = $request->number;
        $dealer->alt_number = $request->alt_number;
        $dealer->address = $request->address;
        $dealer->project_id = $request->project_id;
        $dealer->save();
        if ($dealer) {
            return redirect()->route('dealer.index',RolePrefix())->with(['alert' => 'success', 'message' => 'Dealer has been created successfully!']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Dealer create error']);
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
        $dealer = Dealer::findOrFail($id);
        $inventories = get_inventory_by_project($dealer->project_id);
        dd($inventories);
        return view('user.dealer.show', get_defined_vars());
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
        return view('user.dealer.edit', compact('about'));
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
