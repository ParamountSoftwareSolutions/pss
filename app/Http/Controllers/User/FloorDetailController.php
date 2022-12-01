<?php

namespace App\Http\Controllers\PropertyManager;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingCustomer;
use App\Models\BuildingPaymentPlan;
use App\Models\BuildingSale;
use App\Models\BuildingSaleHistory;
use App\Models\Country;
use App\Models\Floor;
use App\Models\FloorDetail;
use App\Models\FloorDetailFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FloorDetailController extends Controller
{
    public function index($panel,$building_id, $floor_id)
    {
        $country = Country::all();
        $floor = Floor::findOrFail($floor_id);
        $floor_detail = FloorDetail::with('payment_plan','building_sale')->where(['building_id' => $building_id, 'floor_id' => $floor_id])->get();
        $sale_person = Helpers::sales_person();
        $client_id = BuildingCustomer::where('property_admin_id', Helpers::user_admin())->get()->pluck('customer_id');
        $client = User::whereIn('id', $client_id)->get();
        return view('property_manager.floor_detail.index', compact('floor_detail', 'floor', 'floor_id', 'building_id','country','client','sale_person'));
    }

    public function create($panel,$building_id, $floor_id)
    {
        $payment_plan = BuildingPaymentPlan::where('property_admin_id', Helpers::user_admin())->get();
        return view('property_manager.floor_detail.create', compact('building_id', 'floor_id','payment_plan'));
    }

    public function store(Request $request,$panel, $building_id, $floor_id)
    {
        $request->validate([
            'unit_id' => 'required',
            'payment_plan_id' => 'required',
            'area' => 'required',
            'status' => 'required',
        ]);

        $floor_detail = new FloorDetail();
        $floor_detail->building_id = $building_id;
        $floor_detail->floor_id = $floor_id;
        $floor_detail->unit_id = $request->unit_id;
        $floor_detail->area = $request->area;
        $floor_detail->payment_plan_id = $request->payment_plan_id;
        $floor_detail->size = $request->size;
        $floor_detail->bath = $request->bath;
        $floor_detail->type = $request->type;
        $floor_detail->status = $request->status;
        if(isset($request->premium) && $request->premium == 'on'){
            $floor_detail->premium = 1;
        }
        $floor_detail->save();
        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building/floor/', $filename);
                $file = 'public/images/building/floor/' . $filename;
                FloorDetailFile::Create(
                    [
                        'floor_detail_id' => $floor_detail->id,
                        'image' => $file,
                    ]);
            }
        } else{
            FloorDetailFile::Create(
                [
                    'floor_detail_id' => $floor_detail->id,
                    'image' => 'public/images/building/floor/apartment.png',
                ]);
        }
        if ($floor_detail) {
            return redirect()->route('property_manager.floor_detail.index', ['panel' => Helpers::user_login_route()['panel'],'building_id' => $building_id, 'floor_id' => $floor_id])->with($this->message('Data Create SuccessFully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Data Create Error", 'error'));
        }

    }

    public function edit($panel,$building_id, $floor_id, $id)
    {
        $floor_detail = FloorDetail::where(['id' => $id, 'building_id' => $building_id, 'floor_id' => $floor_id])->first();
        $payment_plan = BuildingPaymentPlan::where('property_admin_id', Helpers::user_admin())->get();
        return view('property_manager.floor_detail.edit', compact('building_id', 'floor_id', 'floor_detail','payment_plan'));
    }

    public function update(Request $request,$panel, $building_id, $floor_id, $id)
    {
        $request->validate([
            'unit_id' => 'required',
            'area' => 'required',
            'payment_plan_id' => 'required',
            'status' => 'required',
        ]);
        $floor_detail = FloorDetail::where(['id' => $id, 'building_id' => $building_id, 'floor_id' => $floor_id])->first();
        $floor_detail->building_id = $building_id;
        $floor_detail->floor_id = $floor_id;
        $floor_detail->payment_plan_id = $request->payment_plan_id;
        $floor_detail->unit_id = $request->unit_id;
        $floor_detail->area = $request->area;
        $floor_detail->size = $request->size;
        $floor_detail->bath = $request->bath;
        $floor_detail->type = $request->type;
        $floor_detail->status = $request->status;
        if(isset($request->premium) && $request->premium == 'on'){
            $floor_detail->premium = 1;
        }else{
            $floor_detail->premium = 0;
        }
        $floor_detail->save();
        if ($request->has('images')) {
            foreach ($request->file('images') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/building/floor/', $filename);
                $file = 'public/images/building/floor/' . $filename;
                FloorDetailFile::Create(
                    [
                        'floor_detail_id' => $floor_detail->id,
                        'image' => $file,
                    ]);
            }
        }
        if ($floor_detail) {
            return redirect()->route('property_manager.floor_detail.index', ['panel' => Helpers::user_login_route()['panel'],'building_id' => $building_id, 'floor_id' => $floor_id])->with($this->message('Data Update SuccessFully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Data Update Error", 'error'));
        }

    }

    public function destroy($panel,$building_id, $floor_id, $id)
    {
        $floor_detail = FloorDetail::where(['id' => $id, 'building_id' => $building_id, 'floor_id' => $floor_id])->first();
        $floor_detail->delete();
        if ($floor_detail) {
            return response()->json(['status' => 'success', 'message' => 'Data Delete SuccessFully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data Delete Error']);
        }
    }

    public function remove_image(Request $request)
    {
        //$filename = explode('/', $request->name);dd($filename);
        $floor_detail_file = FloorDetailFile::where(['floor_detail_id' => $request->floor_detail_id, 'id' => $request->id])->first();

        $floor_detail_file->delete();
        if($floor_detail_file !== null){
            unlink($floor_detail_file->image);
        }

        return json_encode($request->name);
    }
    public function filter(Request $request, $panel,$building_id, $floor_id)
    {
        $building = Building::findOrFail($building_id);
        $floor = Floor::findOrFail($floor_id);
        $floor_detail = FloorDetail::where(['building_id' => $building_id, 'floor_id' => $floor_id]);
        $corner = $request->corner;
        $sales_person = $request->sales_person;
        $status = $request->status;
        $filter_date = $request->filter_date;
        if ($sales_person) {
            $floor_detail->whereHas('building_sale',function ($q) use ($sales_person){
                $q->where('user_id',$sales_person);
            });
        }
        if ($status) {
            $floor_detail->where('status', $request->status);
        }
        if ($corner == 1) {
            $floor_detail->where('premium', 1);
        }
        if ($filter_date) {
            $current_date = Carbon::now();
            if ($filter_date == 'today') {
                $floor_detail->whereDate('created_at',$current_date);
            } else if ($filter_date == 'yesterday') {
                $date = Carbon::now()->subDay();
                $floor_detail->whereDate('created_at',$date);
            } else if ($filter_date == 'this_week') {
                $date = Carbon::now()->subDays(7);
                $floor_detail->whereBetween('created_at',[$date,$current_date]);

            } else if ($filter_date == 'this_month') {
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $floor_detail->whereMonth('created_at',$month)->whereYear('created_at', $year);
            } else {
                $last_month = Carbon::now()->subMonth();
                $month = $last_month->format('m');
                $year = $last_month->format('Y');
                $floor_detail->whereMonth('created_at',$month)->whereYear('created_at', $year);
            }
        }
        $floor_detail = $floor_detail->get();
        $sale_person = Helpers::sales_person();
        $client_id = BuildingCustomer::where('property_admin_id', Helpers::user_admin())->get()->pluck('customer_id');
        $client = User::whereIn('id', $client_id)->get();
        $country = Country::get();
        return view('property_manager.floor_detail.index', compact('floor_detail', 'floor', 'floor_id', 'building_id','country','client','sale_person'));
    }

    public function search(Request $request,$panel, $building_id, $floor_id)
    {
        $building = Building::findOrFail($building_id);
        $floor = Floor::findOrFail($floor_id);
        $floor_detail = FloorDetail::where(['building_id' => $building_id, 'floor_id' => $floor_id]);
        $id = $request->id;
        $client_id = $request->client_id;
        if ($id) {
            $floor_detail->where('unit_id', $request->id);
        }
        if ($client_id) {
            $floor_detail->whereHas('building_sale',function ($q) use ($client_id){
                $q->where('customer_id',$client_id);
            });
        }
        $floor_detail = $floor_detail->get();
        $sale_person = Helpers::sales_person();
        $client_id = BuildingCustomer::where('property_admin_id', Helpers::user_admin())->get()->pluck('customer_id');
        $client = User::whereIn('id', $client_id)->get();
        $country = Country::get();
        return view('property_manager.floor_detail.index', compact('floor_detail', 'floor', 'floor_id', 'building_id','country','client','sale_person'));
    }
    public function get_sale_person($id)
    {
        $client_list = BuildingSale::with('sale_person')->where(['customer_id' => $id, 'order_status' => 'active','order_type' => 'sale'])->pluck('user_id')->toArray();
        $users = User::whereIn('id',$client_list)->get();
        /*dd($users);*/
        return response()->json($users);

    }

    public function change_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $floor_detail = FloorDetail::findOrFail($request->id);
        if($request->status == 'sold' || $request->status == 'hold' || $request->status == 'token'){
            if($floor_detail->status == 'sold' && ($request->status == 'hold' || $request->status == 'token')){
                return response()->json(['status' => 'error', 'message' => 'You Have To First Cancelled the Status..']);
            }
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'sale_person_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
            }
            $user = User::findOrFail($request->client_id);
            if(isset($request->father_name)){
                $user->father_name = $request->father_name;
            }
            if(isset($request->cnic)){
                $validator = Validator::make($request->all(), [
                    'cnic' => 'required|unique:users,cnic,'.$user->id,
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
                }
                $user->cnic = $request->cnic;
            }
            if(isset($request->email)){
                $validator = Validator::make($request->all(), [
                    'email' => 'required|unique:users,email,'.$user->id,
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
                }
                $user->email = $request->email;
            }
            if(isset($request->phone_number)){
                $validator = Validator::make($request->all(), [
                    'phone_number' => 'required|unique:users,phone_number,'.$user->id,
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
                }
                $user->phone_number = $request->phone_number;
            }
            if(isset($request->password)){
                $user->address = Hash::make($request->password);
            }
            if(isset($request->address)){
                $user->address = $request->address;
            }
            if(isset($request->dob)){
                $user->dob = $request->dob;
            }
            if(isset($request->country_id)){
                $user->country_id = $request->country_id;
            }
            $user->save();
            $building_sale = new BuildingSale();
            $building_sale->building_id = $floor_detail->building_id;
            $building_sale->floor_detail_id = $floor_detail->id;
            $building_sale->customer_id = $request->client_id;
            $building_sale->user_id = $request->sale_person_id;
            $building_sale->payment_plan_id = $floor_detail->payment_plan_id;
            if($request->status == 'sold'){
                $building_sale->order_status = 'active';
                $building_sale->order_type = 'sale';
            }
            elseif($request->status == 'hold'){
                $building_sale->order_status = 'mature';
                $building_sale->order_type = 'lead';
            }else{
                $building_sale->order_status = 'token';
                $building_sale->order_type = 'lead';
            }
            $building_sale->save();
        }
        if($request->status == 'cancelled' && $floor_detail->status == 'available'){
            return response()->json(['status' => 'error', 'message' => 'Cannot Cancelled when Available']);
        }
        if(!isset($building_sale)){
            $building_sale = BuildingSale::where('floor_detail_id',$floor_detail->id)->latest('id')->first();
        }
        $data = [
            'status' => $request->status,
            'date' => Carbon::now()->format('Y-m-d'),
        ];
        $building_sale_histories = new BuildingSaleHistory();
        $building_sale_histories->key = 'floor_detail';
        $building_sale_histories->building_sale_id = $building_sale->id;
        $building_sale_histories->data = json_encode($data);
        $building_sale_histories->comment = $request->comment;
        $building_sale_histories->save();

        $floor_detail->status = $request->status;
        $floor_detail->save();
        return response()->json(['status' => 'success', 'message' => 'Status Changed Successfully']);
    }

    public function change_type(Request $request)
    {
        $floor_detail = FloorDetail::findOrFail($request->id);
        $floor_detail->type = $request->type;
        $floor_detail->save();
        return response()->json(['status' => 'success', 'message' => 'Status Changed Successfully']);
    }

    public function comments($panel,$building_id, $floor_id, $floor_detail_id)
    {
        $building = Building::findOrFail($building_id);
        $floor = Floor::findOrFail($floor_id);
        $floor_detail = FloorDetail::findOrFail($floor_detail_id);
        $building_sale = BuildingSale::where('floor_detail_id',$floor_detail->id)->pluck('id')->toArray();
        $comments = BuildingSaleHistory::whereIn('building_sale_id',$building_sale)->where('key','floor_detail')->get();
        return view('property_manager.floor_detail.comments', compact('comments'));
    }

}
