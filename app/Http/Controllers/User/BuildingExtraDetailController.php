<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Building;
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
        $building = Building::findOrFail($id);
        $building_detail_check = BuildingDetail::where('building_id', $building->id)->first();
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
        $building_detail->building_id = $building->id;
        $building_detail->address = $request->address;
        $building_detail->developer = $request->developer;
        $building_detail->price = $request->price;
        $building_detail->description = $request->description;
        $building_detail->property_type = $data;
        $building_detail->plot_feature = isset($request->plot_feature) ? json_encode($request->plot_feature) : null;
        $building_detail->communication_feature = isset($request->communication_feature) ? json_encode($request->communication_feature) : null;
        $building_detail->community_feature = isset($request->community_feature) ? json_encode($request->community_feature) : null;
        $building_detail->health_feature = isset($request->health_feature) ? json_encode($request->health_feature) : null;
        $building_detail->other_feature = isset($request->other_feature) ? json_encode($request->other_feature) : null;
        $building_detail->save();

        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/payment', $filename);
                $file = 'images/building_detail/payment/' . $filename;
                BuildingDetailFile::updateOrCreate([
                    'building_detail_id' => $building_detail->id],
                    [
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
                BuildingDetailFile::updateOrCreate([
                    'building_detail_id' => $building_detail->id],
                    [
                        'file' => $file,
                        'type' => 'floor_plan'
                    ]);
            }
        }
        if ($building_detail) {
            return redirect()->route('building_extra_detail',RolePrefix())->with($this->message('Building extra detail has created successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Building extra detail has not created, something went wrong. Try again", 'error'));
        }
    }

    public function edit($building_id,$building_detail_id)
    {
        $building = Building::findOrFail($building_id);
        $building_detail = BuildingDetail::findOrFail($building_detail_id);
        $plot_features = Feature::where('key','plot')->get();
        $communication_features = Feature::where('key','communication')->get();
        $community_features = Feature::where('key','community')->get();
        $health_features = Feature::where('key','health')->get();
        $other_features = Feature::where('key','other')->get();
        return view('user.building_detail.edit', compact('building', 'building_detail','plot_features','communication_features','community_features','health_features','other_features'));
    }

    public function update(Request $request,$building_id,$building_detail_id)
    {
        $building = Building::findOrFail($building_id);
        $building_detail_check = BuildingDetail::where('building_id', $building->id)->first();
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
        $building_detail->building_id = $building->id;
        $building_detail->address = $request->address;
        $building_detail->developer = $request->developer;
        $building_detail->price = $request->price;
        $building_detail->description = $request->description;
        $building_detail->plot_feature = isset($request->plot_feature) ? json_encode($request->plot_feature) : null;
        $building_detail->communication_feature = isset($request->communication_feature) ? json_encode($request->communication_feature) : null;
        $building_detail->community_feature = isset($request->community_feature) ? json_encode($request->community_feature) : null;
        $building_detail->health_feature = isset($request->health_feature) ? json_encode($request->health_feature) : null;
        $building_detail->other_feature = isset($request->other_feature) ? json_encode($request->other_feature) : null;
        $building_detail->property_type = $data;
        $building_detail->save();

        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building_detail/payment', $filename);
                $file = 'images/building_detail/payment/' . $filename;
                BuildingDetailFile::updateOrCreate([
                    'building_detail_id' => $building_detail->id],
                    [
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
                BuildingDetailFile::updateOrCreate([
                    'building_detail_id' => $building_detail->id],
                    [
                        'file' => $file,
                        'type' => 'floor_plan'
                    ]);
            }
        }
        if ($building_detail) {
            return redirect()->route('building_extra_detail',RolePrefix())->with($this->message('Building extra detail has updated successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Building extra detail has not created, something went wrong. Try again", 'error'));
        }
    }

    public function destroy($id)
    {
        //
    }

    public function remove_image_payment(Request $request)
    {
        $building_detail_file = BuildingDetailFile::where(['building_detail_id' => $request->building_detail_id, 'type' => $request->type])->first();

        $building_detail_file->delete();
        if($building_detail_file !== null){
            unlink($building_detail_file->image);
        }
        return json_encode($request->name);
    }

    public function building_extra_detail()
    {
        $project = get_all_projects('building');
        $buildings = Building::with('building_detail')->whereIn('project_id', $project->pluck('id')->toArray())->latest()->get();
        return view('user.building_detail.index', compact('buildings'));
    }
}
