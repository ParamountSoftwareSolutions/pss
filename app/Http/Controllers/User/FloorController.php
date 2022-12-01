<?php

namespace App\Http\Controllers\PropertyManager;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index($panel, $id)
    {
        $building = Helpers::building_detail_single($id);
        $floor = Floor::whereIn('id', json_decode($building->floor_list))->get();
        return view('property_manager.floor.index', compact('floor', 'building'));
    }
}
