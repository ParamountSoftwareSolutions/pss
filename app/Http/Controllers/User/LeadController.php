<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadStoreRequest;
use App\Models\Country;
use App\Models\lead;
use App\Models\LeadHistory;
use App\Models\Project_assign_user;
use App\Models\ProjectAssignUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\HttpCache\Ssi;
use Illuminate\Support\Facades\Validator;
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
        $building = get_all_projects();
        $users = get_user_by_projects();
        $lead = get_leads_from_user($users);
        // $leads = $leads->where('country_id','=', 4);
        // $leads->when($request->country, function ($query) use ($request) {
        //     return $query->where('country_id', $request->country);
        // })->get();
        // $leads->where(
        //     function ($query) {
        //         return $query->country_id == 4;
        //     }
        // );
        // $leadss = $leads->when($request->country, function($query) use ($request){
        //     return $query->where('country_id', $request->country);
        // });

        // $collection = new Collection($lead);
        // $lead = $lead->filter(function ($q) use ($request) {
        //     return $q->country_id == $request->country;
        // });
        // $lead->where(function ($query) use ($request) {
        // $collection->where('country_id', 4);
        // });
        // $lead->filter(function ($filter, $key) {
        //     echo '<pre>';
        //     print_r($filter);
        //     echo '<pre>';
        //     die();
        //     return $filter->country_id != null;
        // });
        /**
         * Filters.
         */
        //Search By Project
        if ($request->project) {
            $lead->where('project_id', $request->project);
        }

        //Search By Date From/To
        if ($request->from && $request->to) {
            $from = $request->from;
            $to = $request->to;
            $lead->whereBetween('created_at', [$from, $to]);
        }

        //Search By Country
        if ($request->country) {

            $lead->where('country_id', $request->country);
        }

        //Table searchRequest
        if ($request->searchRequest) {
            $lead->where('id', $request->searchRequest);
            $lead->orWhere('name', $request->searchRequest);
            $lead->orWhere('number', $request->searchRequest);
        }
        //Table today_followup

        if ($request->today_followup) {
            $current_date = Carbon::now();
            $lead->where('status', 'follow_up')->whereDate('created_at', $current_date);
        }
        //Table statusFilter

        if ($request->statusFilter) {
            $lead->where('status', $request->statusFilter);
        }
        //Table salePersonFilter

        if ($request->salePersonFilter) {
            $lead->where('user_id', $request->salePersonFilter);
        }
        //Table search

        if ($request->search) {

            $lead->where('id', $request->search);
            $lead->orWhere('name', $request->search);
            $lead->orWhere('number', $request->search);
        }
        //Facebook Leads

        if ($request->facebook) {
            $lead->where('type', 'facebook_lead');
        }
        //Facebook Leads

        if ($request->facebook) {
            $lead->where('type', 'facebook_lead');
        }
        //Table deadlineFilter

        if ($request->deadlineFilter) {
            if ($request->deadlineFilter == 'withInTwoDay') {
                $lead->with('lead_histories')->where(['type' => 'lead'])->where('status', 'follow_up')->whereDate('updated_at', Carbon::now()->addDay());
                if (Auth::user()->hasRole('sale_person')) {
                    $lead->where('user_id', Auth::id());
                }
                $sales = $lead->latest('updated_at')->get();
            }
            if ($request->deadlineFilter == 'afterTwoDay') {
                $current_date = Carbon::now();
                $tomorrow = $current_date->addDay();
                $lead->with('lead_histories')->where(['type' => 'lead'])->where('status', 'follow_up')->whereDate('updated_at', '>', Carbon::now()->addDay());
                if (Auth::user()->hasRole('sale_person')) {
                    $lead->where('user_id', Auth::id());
                }
                $sales = $lead->latest('updated_at')->get();
            }
            if ($request->deadlineFilter == 'oneDay') {
                $current_date = Carbon::now();
                $lead->with('lead_histories')->where(['type' => 'lead'])->where('status', 'follow_up')->whereDate('updated_at', Carbon::now());
                if (Auth::user()->hasRole('sale_person')) {
                    $lead->where('user_id', Auth::id());
                }
                $sales = $lead->latest('updated_at')->get();
            }
            if ($request->deadlineFilter == 'overdue') {

                // $sale_history = BuildingSaleHistory::latest()
                //     ->where('data->status', 'follow_up')
                //     ->get()
                //     ->unique('building_sale_id');
                // foreach ($sale_history as $item) {
                //     if (json_decode($item->data)->date <= Carbon::today()) {

                //         $newarray[] = $item->toArray()['building_sale_id'];
                //     }
                // }
                // $sales_details = BuildingSale::with('building_sale_history')->whereIn('id', $newarray)->whereIn('building_id', $building->pluck('id')->toArray())->where('order_status', 'follow_up');
                // if (Auth::user()->hasRole('sale_person')) {
                //     $sales_details->where('user_id', Auth::id());
                // }
                // $sales = $sales_details->latest('updated_at')->get();
                $lead_history = LeadHistory::latest()
                    ->where('status', 'follow_up')
                    ->get()
                    ->unique('lead_id');
                foreach ($lead_history as $item) {
                    if ($item->date <= Carbon::today()) {
                        $newarray[] = $item->toArray()['lead_id'];
                    }
                }
                $lead->with('lead_histories')->whereIn('id', $newarray)->where('status', 'follow_up');
                if (Auth::user()->hasRole('sale_person')) {
                    $lead->where('user_id', Auth::id());
                }
                $sales = $lead->latest('updated_at')->get();
            }
        }
        //Table filter_date

        if ($request->filter_date) {
            if ($request->filter_date == 'today') {
                $current_date = Carbon::now();
                $lead->whereDate('created_at', $current_date);
            } else if ($request->filter_date == 'yesterday') {
                $date = Carbon::now()->subDay();
                $lead->whereDate('created_at', $date);
            } else if ($request->filter_date == 'this_week') {
                $current_date = Carbon::now();
                $date = Carbon::now()->subDays(7);
                $lead->whereBetween('created_at', [$date, $current_date]);
            } else if ($request->filter_date == 'this_month') {
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $lead->whereMonth('created_at', $month)->whereYear('created_at', $year);
            } else {
                $last_month = Carbon::now()->subMonth();
                $month = $last_month->format('m');
                $year = $last_month->format('Y');
                $lead->whereMonth('created_at', $month)->whereYear('created_at', $year);
            }
        }
        /**
         * Filters.
         */
        $sales = $lead->whereNot('status', 'lost')->whereNot('status', 'mature')->orderBy('updated_at', 'desc')->paginate($request->limit)->appends(request()->query());
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();
        $country = Country::get();
        // $sales = lead::orderBy('id', 'desc')->paginate($request->limit)->appends(request()->query());


        // if ($request->ajax()) {
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

        $response = lead::where('id', $lead->id)->update($data);
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

    public function changePriority($priority, $id)
    {
        $data = [
            'priority' => $priority,
        ];
        $response = lead::where('id', $id)->update($data);
        if ($response) {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('success', 'Priority Update Successfully');
        } else {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }
    public function changeStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'comment' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        $lead_data = [
            'status' => $request->status,
        ];
        lead::where('id', $request->id)->update($lead_data);
        $lead_histories_data = [
            'lead_id' => $request->id,
            'status' => $request->status,
            'date' => $request->date,
            'comment' => $request->comment,
            'call_status' => $request->call_status,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'call_time' => $request->call_time,
            'is_read' => 0,
        ];

        $response = LeadHistory::create($lead_histories_data);
        if ($response) {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('success', 'Lead Update Successfully');
        } else {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }
    public function comments($id)
    {

        $comments = LeadHistory::where('lead_id', $id)->orderBy('id', 'desc')->get();
        return view('user.lead.comments', get_defined_vars());
    }
    public function lead_assign(Request $request)
    {
        if ($request->sale_id !== null) {
            $sale_id_arr = explode(',', $request->sale_id);
            if (in_array('on', $sale_id_arr)) {
                $arr = array_diff($sale_id_arr, ['on']);
            } else {
                $arr = $sale_id_arr;
            }
            $response = lead::whereIn('id', $arr)
                ->update([
                    'user_id' => $request->sale_person_id,
                ]);
            if ($response) {
                return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('success', 'Lead Update Successfully');
            } else {
                return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
            }
        } else {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'Please select first any lead');
        }
    }
    public function matured(Request $request)
    {
        $building = get_all_projects();
        $users = get_user_by_projects();
        $lead = get_leads_from_user($users);
        $lead->where('status', 'mature');
        //Table searchRequest
        if ($request->searchRequest) {
            $lead->where('id', $request->searchRequest);
            $lead->orWhere('name', $request->searchRequest);
            $lead->orWhere('number', $request->searchRequest);
        }
        $sales = $lead->where('status', 'mature')->orderBy('id', 'desc')->paginate($request->limit)->appends(request()->query());
        return view('user.lead.mature', get_defined_vars());
    }
    public function closed(Request $request)
    {
        $building = get_all_projects();
        $users = get_user_by_projects();
        $lead = get_leads_from_user($users);
        $lead->where('status', 'lost');
        $sales = $lead->where('status', 'lost')->orderBy('id', 'desc')->paginate($request->limit)->appends(request()->query());
        return view('user.lead.closed', get_defined_vars());
    }
    public function facebook(Request $request)
    {
        $building = get_all_projects();
        $users = get_user_by_projects();
        $lead = Lead::with('sale_person', 'building')->where('type', 'facebook_lead');
        $sales = $lead->orderBy('id', 'desc')->paginate($request->limit)->appends(request()->query());
        return view('user.lead.facebook', get_defined_vars());
    }

    public function employees()
    {
        $users = get_user_by_projects();
        $persons = User::whereIn('id', $users)->get();
        return view('user.lead.employee', get_defined_vars());
    }

    public function employees_report(Request $request)
    {

        $current_date = Carbon::now();
        // daily
        if ($request->range == 'daily') {
            $sales = Lead::with('lead_histories')->where('user_id', $request->id)->whereDate('updated_at', Carbon::today())->orderBy('updated_at', 'asc')->get();
        }
        //Monthlty
        if ($request->range == 'weekly') {
            $sales = Lead::with('lead_histories')->where('user_id', $request->id)->whereMonth('updated_at', date('m'))->orderBy('updated_at')->get();
        }
        //Weekly
        if ($request->range == 'monthly') {
            $sales = Lead::with('lead_histories')->where('user_id', $request->id)->whereBetween('updated_at', [
                $current_date->subDays($current_date->dayOfWeek)->subWeek(),
                Carbon::now(),
            ])->orderBy('updated_at')->get();
        }
        //$sales = BuildingSale::with('building_sale_history')->where('user_id', $request->id)->whereDate('updated_at', Carbon::today())->get();
        // $followup = BuildingSale::with('customer')->where(['order_status' => 'follow_up'])->whereHas('building_sale_history', function ($q) use ($current_date) {
        //     $q->whereDate('data->date', $current_date);
        // });
        // $followup_counts = ($followup->count());
        // if ($followup_counts > 0) {
        //     $shadow = true;
        // } else {
        //     $shadow = false;
        // }
        return view('user.lead.employee_reports', get_defined_vars());
    }
}
