<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\BuildingFloor;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\NocType;
use App\Models\Project;
use App\Models\Size;
use App\Models\Society;
use App\Models\SocietyFile;
use App\Models\State;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocietyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $societies = Society::with('project')->whereHas('project', function ($q) {
                $q->whereHas('type', function ($q) {
                    $q->where('name', 'society');
                });
            })->latest()->get();
        return view('user.society.index', compact('societies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $society_block = Society::findOrFail($id);
        return view('user.society.show', compact('society_block'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $society = Society::whereHas('project', function ($q) {
                $q->whereHas('type', function ($q) {
                    $q->where('name', 'society');
                });
            })
            ->findOrFail($id);
        $category = Category::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->get();
        $size = Size::whereHas('project_type', function ($q) {
            $q->where('name', 'society');
        })->whereIn('unit', ['marla', 'kanal'])->get();
        $noc = NocType::get();
        $country = Country::get();
        $block = Block::whereHas('project_type', function ($q){
            $q->where('name', 'society');
        })->get();
        return view('user.society.edit', compact('society', 'category', 'size', 'noc', 'country', 'block'));
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
            'type' => 'required',
            'noc_type_id' => 'required',
        ]);
        $society = Society::findOrFail($id);
        $society->noc_type_id = $request->noc_type_id;
        $society->developer = $request->developer;
        $society->type = json_encode($request->type);
        $society->block = json_encode($request->block);
        $society->address = $request->address;
        $society->country_id = $request->country;
        $society->state_id = $request->state;
        $society->city_id = $request->city;
        $society->area = $request->area;
        $society->created_by = Auth::id();
        $society->save();
        if ($request->file('logo')) {
            $file = $request->file('logo');
            $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
            $file->move('images/society/logo/', $filename);
            $logo = asset('images/society/logo/' . $filename);
            SocietyFile::create([
                'society_id' => $society->id,
                'file' => $logo,
                'type' => 'logo',
            ]);
        }
        if ($request->file('main_image')) {
            $file = $request->file('main_image');
            $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
            $file->move('images/society/logo/', $filename);
            $main_image = asset('images/society/logo/' . $filename);
            SocietyFile::create([
                'society_id' => $society->id,
                'file' => $main_image,
                'type' => 'main_image',
            ]);
        }
        if ($request->file('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('images/society/', $filename);
                $image = asset('images/society/' . $filename);
                SocietyFile::create([
                    'society_id' => $society->id,
                    'file' => $image,
                    'type' => 'image',
                ]);
            }
        }


        if ($society) {
            return redirect()->route('society.index', ['RolePrefix' => RolePrefix()])->with($this->message('Building has created SuccessFully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Building has not created, something went wrong. Try again", 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
