<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function state($id)
    {
        $state = State::where('country_id', $id)->get();
        return json_encode($state);
    }

    public function city($id)
    {
        $city = City::where('state_id', $id)->get();
        return json_encode($city);
    }
}
