<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Project;
use App\Models\BuildingDetail;
use App\Models\BuildingDetailFile;
use App\Models\Floor;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingExtraDetailController extends Controller
{
    public function index()
    {
        $project = get_all_projects('building');
        $buildings = Building::with('project', 'building_file')->whereIn('project_id', $project->pluck('id')->toArray())->latest()->get();
        dd($buildings);
        return view('user.building_detail.index', compact('buildings'));
    }

    public function create($id)
    {
        $plot_features = Feature::where('key','plot')->get();
        $communication_features = Feature::where('key','communication')->get();
        $community_features = Feature::where('key','community')->get();
        $health_features = Feature::where('key','health')->get();
        $other_features = Feature::where('key','other')->get();
        return view('user.building_detail.create', compact('id','plot_features','communication_features','community_features','health_features','other_features'));
    }

    public function store(Request $request,$id)
    {
        $project = Project::findOrFail($id);
        $building_detail_check = BuildingDetail::where('project_id', $project->id)->first();
        if ($building_detail_check == null){
            $building_detail = new BuildingDetail();
        } else {
            return redirect()->back()->with($this->message("Building Extra Detail already create", 'error'));
        }
        $data = json_encode([
            'shop_detail' => ['floor' => $request->floor, 'area' => $request->area, 'price' => $request->price],
            'single_bed_flat' => ['building' => $request->building_1bed, 'area' => $request->area_1bed, 'bed' => $request->bed_1bed, 'bath' => $request->bath_1bed, 'price' => $request->price_1bed],
            'double_bed_flat' => ['building' => $request->building_2bed, 'area' => $request->area_2bed, 'bed' => $request->bed_2bed, 'bath' => $request->bath_2bed, 'price' => $request->price_2bed],
            'studio_bed_flat' => ['building' => $request->building_studio, 'area' => $request->area_studio, 'bed' => $request->studio, 'bath' => $request->bath_studio, 'price' => $request->price_studio],
        ]);
        $building_detail->project_id = $project->id;
        $building_detail->address = $request->address;
        $building_detail->developer = $request->developer;
        $building_detail->price = $request->price;
        $building_detail->latitude = $request->latitude;
        $building_detail->longitude = $request->longitude;
        $building_detail->description = $request->description;
        $building_detail->property_type = $data;
        $building_detail->plot_feature = isset($request->plot_feature) ? json_encode($request->plot_feature) : null;
        $building_detail->communication_feature = isset($request->communication_feature) ? json_encode($request->communication_feature) : null;
        $building_detail->community_feature = isset($request->community_feature) ? json_encode($request->community_feature) : null;
        $building_detail->health_feature = isset($request->health_feature) ? json_encode($request->health_feature) : null;
        $building_detail->other_feature = isset($request->other_feature) ? json_encode($request->other_feature) : null;
        $building_detail->save();

        if ($request->has('logo_images')) {
            foreach ($request->file('logo_images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/logo', $filename);
                $file = 'images/building_detail/logo/' . $filename;
                BuildingDetailFile::create([
                    'building_detail_id' => $building_detail->id,
                    'file' => $file,
                    'type' => 'logo'
                ]);
            }
        }
        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/payment', $filename);
                $file = 'images/building_detail/payment/' . $filename;
                BuildingDetailFile::create([
                    'building_detail_id' => $building_detail->id,
                    'file' => $file,
                    'type' => 'payment_plan'
                ]);
            }
        }
        if ($request->has('floor_images')) {
            foreach ($request->file('floor_images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/floor/', $filename);
                $file = 'images/building_detail/floor/' . $filename;
                BuildingDetailFile::create([
                    'building_detail_id' => $building_detail->id,
                    'file' => $file,
                    'type' => 'floor_plan'
                ]);
            }
        }
        if($project->type_id == 1){
            $type = 'building';
        }elseif ($project->type_id == 2){
            $type = 'society';
        }elseif ($project->type_id == 3){
                $type = 'farm_house';
        }else{
            $type = 'property';
        }
        if ($building_detail) {
            return redirect()->route('project_extra_detail',['RolePrefix'=>RolePrefix(),'project_type'=>$type])->with($this->message('Building extra detail has created successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Building extra detail has not created, something went wrong. Try again", 'error'));
        }
    }

    public function edit($project_id,$building_detail_id)
    {
        $project = Project::findOrFail($project_id);
        $building_detail = BuildingDetail::with('floor_plan_image','payment_plan_image')->findOrFail($building_detail_id);
        $plot_features = Feature::where('key','plot')->get();
        $communication_features = Feature::where('key','communication')->get();
        $community_features = Feature::where('key','community')->get();
        $health_features = Feature::where('key','health')->get();
        $other_features = Feature::where('key','other')->get();
        return view('user.building_detail.edit', compact('project', 'building_detail','plot_features','communication_features','community_features','health_features','other_features'));
    }

    public function update(Request $request,$project_id,$building_detail_id)
    {
        $project = Project::findOrFail($project_id);
        $building_detail_check = BuildingDetail::where('project_id', $project->id)->first();
        if ($building_detail_check == null){
            return redirect()->back()->with($this->message("Building Extra Detail not exist", 'error'));
        } else {
            $building_detail = BuildingDetail::findOrFail($building_detail_id);
        }

        $data = json_encode([
            'shop_detail' => ['floor' => $request->floor, 'area' => $request->area, 'price' => $request->price],
            'single_bed_flat' => ['building' => $request->building_1bed, 'area' => $request->area_1bed, 'bed' => $request->bed_1bed, 'bath' => $request->bath_1bed, 'price' => $request->price_1bed],
            'double_bed_flat' => ['building' => $request->building_2bed, 'area' => $request->area_2bed, 'bed' => $request->bed_2bed, 'bath' => $request->bath_2bed, 'price' => $request->price_2bed],
            'studio_bed_flat' => ['building' => $request->building_studio, 'area' => $request->area_studio, 'bed' => $request->studio, 'bath' => $request->bath_studio, 'price' => $request->price_studio],
        ]);
        $building_detail->project_id = $project->id;
        $building_detail->address = $request->address;
        $building_detail->developer = $request->developer;
        $building_detail->price = $request->price;
        $building_detail->latitude = $request->latitude;
        $building_detail->longitude = $request->longitude;
        $building_detail->description = $request->description;
        $building_detail->plot_feature = isset($request->plot_feature) ? json_encode($request->plot_feature) : null;
        $building_detail->communication_feature = isset($request->communication_feature) ? json_encode($request->communication_feature) : null;
        $building_detail->community_feature = isset($request->community_feature) ? json_encode($request->community_feature) : null;
        $building_detail->health_feature = isset($request->health_feature) ? json_encode($request->health_feature) : null;
        $building_detail->other_feature = isset($request->other_feature) ? json_encode($request->other_feature) : null;
        $building_detail->property_type = $data;
        $building_detail->save();

        if ($request->has('logo_images')) {
            foreach ($request->file('logo_images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/logo', $filename);
                $file = 'images/building_detail/logo/' . $filename;
                BuildingDetailFile::create([
                    'building_detail_id' => $building_detail->id,
                    'file' => $file,
                    'type' => 'logo'
                ]);
            }
        }
        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/payment', $filename);
                $file = 'images/building_detail/payment/' . $filename;
                BuildingDetailFile::create([
                    'building_detail_id' => $building_detail->id,
                    'file' => $file,
                    'type' => 'payment_plan'
                ]);
            }
        }
        if ($request->has('floor_images')) {
            foreach ($request->file('floor_images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/floor/', $filename);
                $file = 'images/building_detail/floor/' . $filename;
                BuildingDetailFile::create([
                    'building_detail_id' => $building_detail->id,
                    'file' => $file,
                    'type' => 'floor_plan'
                ]);
            }
        }
        if($project->type_id == 1){
            $type = 'building';
        }elseif ($project->type_id == 2){
            $type = 'society';
        }elseif ($project->type_id == 3){
            $type = 'farm_house';
        }else{
            $type = 'property';
        }
        if ($building_detail) {
            return redirect()->route('project_extra_detail',['RolePrefix'=>RolePrefix(),'project_type'=>$type])->with($this->message('Building extra detail has updated successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Building extra detail has not created, something went wrong. Try again", 'error'));
        }
    }

    public function destroy($id)
    {
        //
    }
    public function image_remove(Request $request)
    {
        $building_detail_file = BuildingDetailFile::where([
            'id' => $request->id,
            'building_detail_id' => $request->building_detail_id,
            'type' => $request->type
        ])->first();
        $building_detail_file->delete();
        if($building_detail_file){
            if($building_detail_file->file){
                $file = 'public/'.$building_detail_file->file;
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $building_detail_file->delete();
        }
        return json_encode('success');
    }


    public function project_extra_detail($type)
    {
        $project = get_all_projects($type);
        return view('user.building_detail.index', compact('project'));
    }

}
