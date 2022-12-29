<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::get();
        return view('user.app.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $type = ProjectType::all();
        return view('user.app.banner.create',get_defined_vars());
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
            'project_type_id' => 'required',
            'project_id' => 'required',
            'image' => 'required',
        ]);
        $project = Project::where('id',$request->project_id)->first();
        if(!$project){
            return redirect()->back()->with($this->message('Project Not Found', 'error'));
        }
        $banner = new Banner();
        $banner->project_id = $request->project_id;
        $banner->type = 'banner';
        if ($request->has('image')) {
            $image = $request->image;
            $filename = hexdec(uniqid()) . '.' . strtolower($image->getClientOriginalExtension());
            $image->move('public/images/banner/', $filename);
            $file = 'images/banner/' . $filename;
            $banner->file = $file;
        }
        $banner->save();
        if ($banner) {
            return redirect()->route('banner.index',RolePrefix())->with($this->message('Banner has been created successfully!', 'success'));
        } else {
            return redirect()->back()->with($this->message('Banner Create Error', 'danger'));
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
        $type = ProjectType::all();
        $banner = Banner::with('project')->findOrFail($id);
        return view('user.app.banner.edit', get_defined_vars());
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
            'project_type_id' => 'required',
            'project_id' => 'required',
//            'images' => 'required',
        ]);
        $banner = Banner::findOrFail($id);
        $project = Project::where('id',$request->project_id)->first();
        if(!$project){
            return redirect()->back()->with($this->message('Project Not Found', 'error'));
        }
        if(empty($request->image)){
            if(!($banner->file && file_exists('public/'.$banner->file))){
                $request->validate([
                    'image' => 'required',
                ]);
            }
        }
        $banner->project_id = $request->project_id;
        $banner->type = 'banner';
        if ($request->has('image')) {
            $image = $request->image;
            $filename = hexdec(uniqid()) . '.' . strtolower($image->getClientOriginalExtension());
            $image->move('public/images/banner/', $filename);
            $file = 'images/banner/' . $filename;
            $banner->file = $file;
        }
        $banner->save();
        if ($banner) {
            return redirect()->route('banner.index',RolePrefix())->with($this->message('Banner has been updated successfully!', 'success'));
        } else {
            return redirect()->back()->with($this->message('Banner Update Error', 'danger'));
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
        $banner = Banner::findOrFail($id);
        $file = 'public/'.$banner->file;
        if($banner->file && file_exists($file)) {
            unlink($file);
        }
        $banner->delete();
        if ($banner) {
            return response()->json(['message'=>'Banner has been deleted successfully!','status'=>'success']);
        } else {
            return response()->json(['message'=>'Banner Delete Error','status'=>'error']);
        }
    }

    public function image_remove(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $file = 'public/'.$banner->file;
        if($banner->file && file_exists($file)) {
            unlink($file);
            return json_encode('success');
        }
        return json_encode('error');
    }
}
