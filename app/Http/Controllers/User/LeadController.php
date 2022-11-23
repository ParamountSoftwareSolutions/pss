<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadStoreRequest;
use App\Models\lead;
use App\Models\Project_assign_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use DataTables;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        // if ($request->ajax()) {
        $sales = lead::orderBy('id', 'desc')->paginate($request->limit)->appends(request()->query());
        //     return datatables()->of($datas)->toJson();
        // }
        // if ($request->ajax()) {
        //     $data = lead::select('id', 'name', 'email')->get();
        //     return datatables()::of($data)->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
        //             return $btn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

        // return view('users');
        return view('user.lead.index', get_defined_vars());
        // $building = Project_assign_user::with('user')->get();
        // $saless = get_leads_from_user_auth();
        // $sales = $saless->paginate(5);
        // $sale_person = Helpers::sales_person();
        // $sale_manager = Helpers::sales_manager();
        // return view('user.lead.index', get_defined_vars());
    }
    // Fetch DataTable data
    public function getEmployees(Request $request)
    {

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Custom search filter 
        $searchCity = $request->get('searchCity');
        $searchGender = $request->get('searchGender');
        $searchName = $request->get('searchName');

        // Total records
        $records = get_leads_from_user_auth();
        // $records = lead::select('count(*) as allcount');

        ## Add custom filter conditions
        if (!empty($searchCity)) {
            $records->where('city', $searchCity);
        }
        if (!empty($searchGender)) {
            $records->where('gender', $searchGender);
        }
        if (!empty($searchName)) {
            $records->where('name', 'like', '%' . $searchName . '%');
        }
        $totalRecords = $records->count();

        // Total records with filter
        // $records = lead::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%');

        ## Add custom filter conditions
        if (!empty($searchCity)) {
            $records->where('city', $searchCity);
        }
        if (!empty($searchGender)) {
            $records->where('gender', $searchGender);
        }
        if (!empty($searchName)) {
            $records->where('name', 'like', '%' . $searchName . '%');
        }
        $totalRecordswithFilter = $records->count();

        // Fetch records
        // $records = lead::orderBy($columnName, $columnSortOrder)
        //     ->select('users_4.*')
        //     ->where('users_4.name', 'like', '%' . $searchValue . '%');
        ## Add custom filter conditions
        if (!empty($searchCity)) {
            $records->where('city', $searchCity);
        }
        if (!empty($searchGender)) {
            $records->where('gender', $searchGender);
        }
        if (!empty($searchName)) {
            $records->where('name', 'like', '%' . $searchName . '%');
        }
        $employees = $records->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($employees as $employee) {

            $name = $employee->name;
            $email = $employee->email;
            $number = $employee->number;

            $data_arr[] = array(
                "name" => $name,
                "email" => $email,
                "number" => $number,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $country = Country::get();
        // $sale_person = Helpers::sales_person();
        // $building = Helpers::building_detail();
        return view('user.lead.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadStoreRequest $request)
    {
        $data = [
            'project_id' => $request->building_id,
            'user_id' => $request->sale_person_id,
            'created_by' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->sale_person_id,
            'number' => $request->phone_number,
            'cnic' => $request->cnic,
            'father_name' => $request->father_name,
            'interested_in' => $request->interested_in,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'budget' => $request->budget,
            'location' => $request->building_id,
            'source' => $request->building_id,
            'location' => $request->address,
            'source' => $request->source,
            'status' => 'new',
            'type' => 'lead',
        ];
    
        $response = lead::create($data);
        if ($response) {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('success', 'Lead Insert Successfully');
        } else {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(lead $lead)
    {
        $lead->with('user')->first();
        return view('user.lead.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lead $lead)
    {
        $data = [
            'project_id' => $request->building_id,
            'user_id' => $request->sale_person_id,
            'created_by' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->sale_person_id,
            'number' => $request->phone_number,
            'cnic' => $request->cnic,
            'father_name' => $request->father_name,
            'password' => $request->password,
            'interested_in' => $request->interested_in,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'budget' => $request->budget,
            'location' => $request->building_id,
            'source' => $request->building_id,
            'location' => $request->address,
            'source' => $request->source,
        ];

        $response = lead::where('id',$lead->id)->update($data);
        if ($response) {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('success', 'Lead Update Successfully');
        } else {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(lead $lead)
    {
        //
    }
}
