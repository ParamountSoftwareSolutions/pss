<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadStoreRequest;
use App\Models\Block;
use App\Models\Country;
use App\Models\Building;
use App\Models\Premium;
use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\Project_assign_user;
use App\Models\ProjectAssignUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Rap2hpoutre\FastExcel\FastExcel;
use Symfony\Component\HttpKernel\HttpCache\Ssi;
use Illuminate\Support\Facades\Validator;
use App\Models\Size;
use App\Models\Unit;
use App\Models\BuildingFloor;
use App\Models\BuildingInventory;
use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Farmhouse;
use App\Models\LeadRefer;
use App\Models\Project;
use App\Models\Property;
use App\Models\Society;
use App\Models\SocietyInventory;
use App\Models\Type;

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
        //        dd($lead->get());
        /**
         * /////////////////////////////////////////////Filters/////////////////////////////////
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
            $lead->where('status', 'follow_up')->whereDate('updated_at', $current_date);
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
                $lead_history = LeadHistory::latest()
                    ->where('status', 'follow_up')
                    ->get()
                    ->unique('lead_id');
                if (!empty($lead_history)) {
                    $newarray = [];
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
         * ////////////////////////////////////Filters.
         */
        $sales = $lead->whereNot('status', 'lost')->whereNot('status', 'mature')->orderBy('updated_at', 'desc')->paginate($request->limit)->appends(request()->query());
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();
        $country = Country::get();

        /**
         *  //////////////////////// Meeting Or Pushed Meetings.
         */
        $salesCount = LeadHistory::selectRaw('lead_id, COUNT(lead_id) as "total"')
            ->whereIn('lead_id', $sales->pluck('id')->toArray())->where('status', 'arrange_meeting')->where('date', '>=', Carbon::now()->format('Y-m-d'))
            ->groupBy('lead_id')
            ->get();
        $arrange_data = [];
        $pushed_data = [];
        foreach ($salesCount as $key => $val) {
            if ($val->total == 1) {
                $arrange_data[] = $val->lead_id;
            } else {
                $pushed_data[] = $val->lead_id;
            }
        }
        $arrange = count($arrange_data);
        $pushed = count($pushed_data);
        //lead Count
        $lead_count = $lead->count();
        //Today FollowUp Count
        $today_follow_up_count = $lead->where('status', 'follow_up')->whereDate('updated_at', Carbon::now())->count();

        //Facebook lead Count
        $facebook_count = $lead->where('type', 'facebook_lead')->count();
        /**
         * /////////////////////////Meeting Or Pushed Meetings.
         */

        /**
         *  //////////////////////// project detail/////.
         */
        /**
         *  //////////////////////// project detail/////.
         */

        return view('user.lead.index', get_defined_vars());
    }
    // Fetch DataTable data

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $country = Country::get();
        $users = get_user_by_projects();
        $project = get_all_projects();
        $projects = Project::whereIn('id', $project->pluck('id')->toArray())->get();
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();

        return view('user.lead.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:leads,number',
            'phone_number' => 'unique:leads,alt_number',
            'email' => 'nullable|unique:leads,email',
            'cnic' => 'nullable|unique:leads,cnic',
        ]);
        $rpoject_id_val = (!empty(json_decode($request->building_id)->id)) ? json_decode($request->building_id)->id : Null;
        $data = [
            'project_id' => $rpoject_id_val,
            'building_floor_id' => $request->buildingFloor,
            'type_id' => $request->type,
            'size_id' => $request->size,
            'quantity' => $request->quantity,
            'premia_id' => $request->premium,
            'inventory_id' => $request->inventory_id,
            'interested' => $request->interested,

            'user_id' => ($request->sale_person_id) ? $request->sale_person_id : auth()->user()->id,
            'created_by' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'number' => $request->phone_number,
            'cnic' => $request->cnic,
            'father_name' => $request->father_name,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'budget_from' => $request->bugdetFrom,
            'budget_to' => $request->bugdetTo,
            'location' => $request->address,
            'source' => $request->source,
            'status' => 'new',
            'type' => 'lead',
        ];
        $response = Lead::create($data);
        task_count_increment('lead');
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
        $country = Country::get();
        $users = get_user_by_projects();
        $project = get_all_projects();
        $projects = Project::whereIn('id', $project->pluck('id')->toArray())->get();
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();
        $user = $lead->user;
        $project = $lead->project;
        $countrys = $lead->country;
        $state = $lead->state;
        $city = $lead->city;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'error', 'message' => $validator->errors()->first()]);
        }
        $data = [
            'project_id' => (!empty(json_decode($request->building_id)->id)) ? json_decode($request->building_id)->id : $request->building_id,
            'user_id' => $request->sale_person_id,
            'created_by' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'cnic' => $request->cnic,
            'father_name' => $request->father_name,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'budget_from' => $request->bugdetFrom,
            'budget_to' => $request->bugdetTo,
            'purpose' => $request->purpose,
            'location' => $request->address,
            'source' => $request->source,
            'status' => 'new',
            'type' => 'lead',
        ];
        $response = Lead::where('id', $lead->id)->update($data);
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
        $response = Lead::where('id', $id)->update($data);
        if ($response) {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('success', 'Priority Has Update Successfully');
        } else {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'Priority not updated successfully, something went wrong. Try again');
        }
    }
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'date' => 'required',
            'comment' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if ($request->status == 'mature') {

            $client = Lead::where('id', $request->id)->first();
            $client_data = [
                'project_id' => $client->project_id,
                //'project_type_id' => $request->project_type_id,
                //'inventory_id' => $request->inventory_id,
                'customer_id' => $client->id,
                'user_id' => $client->user_id,

                'name' => $client->name,
                'email' => $client->email,
                'password' => $client->password,
                'number' => $client->number,
                'alt_phone' => $client->alt_number,
                'address' => $client->address,
                'cnic' => $client->cnic,
                'father_name' => $client->father_name,
                'country_id' => $client->country_id,
                'state_id' => $client->state_id,
                'city_id' => $client->city_id,

                'registration_number' => rand(100, 100000),
                'hidden_file_number' => "",
                'comment' => $client->comment,
                'created_by' => auth()->user()->id,
                'status' => 'mature',
            ];
            Client::create($client_data);
        }


        $lead_data = [
            'status' => $request->status,
        ];
        Lead::where('id', $request->id)->update($lead_data);
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
        switch ($request->status) {
            case 'arrange_meeting':
                $type = 'meeting';
                break;
            case 'follow_up':
                $type = 'call';
                break;
            case 'mature':
                $type = 'conversion';
                break;
            default:
                $type = null;
        }
        if ($type) {
            task_count_increment($type);
        }
        if ($response) {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('success', 'Status has updated successfully');
        } else {
            return redirect()->route('leads.index', ['RolePrefix' => RolePrefix()])->with('error', 'Status not updated successfully, something went wrong. Try again');
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
            $response = Lead::whereIn('id', $arr)
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
    public function refer_lead(Request $request)
    {
        if ($request->sale_id !== null) {
            $sale_id_arr = explode(',', $request->sale_id);
            if (in_array('on', $sale_id_arr)) {
                $arr = array_diff($sale_id_arr, ['on']);
            } else {
                $arr = $sale_id_arr;
            }
            foreach ($arr as $key => $value) {
                $data = [
                    'lead_id' => $value,
                    'from' => auth()->user()->id,
                    'to' => $request->sale_person_id,
                    'status' => 'pending'
                ];
                $response = LeadRefer::insert($data);
            }
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
        return view('user.lead.employee_reports', get_defined_vars());
    }


    public function getInventory(Request $request)
    {
        $projectId = $request->id;
        $projectTypeId = $request->type_id;
        $size = null;
        $type = null;
        $premium = null;
        $floor = null;
        $block = null;
        switch ($projectTypeId) {
            case "1":

                $building = Building::where('project_id', $projectId)->first();

                $project = BuildingInventory::where('building_id', 1);

                $floor_list = json_decode($building->floor_list);
                $floor = BuildingFloor::whereIn('id', $floor_list)->get();

                $size_list = json_decode($building->apartment_size);
                $size = Size::whereIn('id', $size_list)->get();

                $type_id = json_decode($building->type);
                $type = Type::whereIn('id', $type_id)->get();

                break;
            case "2":
                $society = Society::where('project_id', $projectId)->first();
                // return json_encode($society);;
                $blocks = json_decode($society->block);
                $size = Size::where('project_type_id', $projectTypeId)->get();
                $premium = premium::where('project_type_id', $projectTypeId)->get();
                // $block = SocietyInventory::with('block')->where('project_id', $projectId)->get();
                $block = Block::whereIn('id', $blocks)->get();
                break;
            case "3":
                //form House
                // $project = Property::where('project_id', $projectId)->first();
                // echo '<pre>';
                // print_r($project);
                // echo '<pre>';
                // die();
                // $size_list = json_decode($project->size_id)->get();
                // $size = Size::whereIn('id', $size_list);
                // $premium_list = json_decode($project->premium_id)->get();
                // $premium = premium::whereIn('id', $premium_list);
                $size = Size::where('project_type_id', $projectTypeId)->get();
                $premium = premium::where('project_type_id', $projectTypeId)->get();

                $block = Farmhouse::where('project_id', $projectId)->first();
                break;
                // case "4":

                //     break;
            default:
                $size = null;
                $type = null;
                $premium = null;
                $floor = null;
                $block = null;
                break;
        }

        $data = json_encode([$size, $floor, $type, $premium, $block]);

        return  $data;
    }

    public function refer()
    {
        $refers = LeadRefer::with('lead', 'to_user', 'from_user')->where('from', auth()->user()->id)->get();
        $requested = LeadRefer::with('lead', 'to_user', 'from_user')->where('to', auth()->user()->id)->get();
        return view('user.lead.refers', get_defined_vars());
    }
    public function refer_lead_accept($id)
    {
        $data = [
            'status' => 'accept'
        ];
        $response = LeadRefer::where('id', $id)->update($data);
        if ($response) {
            return redirect()->back()->with('success', 'Request Has Been Accepted Successfully');
        } else {
            return redirect()->back()->with('error', 'SomeThing Went Wrong');
        }
    }
    public function refer_lead_reject($id)
    {
        $data = [
            'status' => 'reject'
        ];
        $response = LeadRefer::where('id', $id)->update($data);
        if ($response) {
            return redirect()->back()->with('success', 'Request Has Been Rejected Successfully');
        } else {
            return redirect()->back()->with('error', 'SomeThing Went Wrong');
        }
    }
    public function bulk_import_view()
    {
        return view('user.lead.bulk_import');
    }
    public function bulk_import(Request $request)
    {
        try {
            $collections = (new FastExcel)->import($request->file('leads_file'));
        } catch (\Exception $exception) {
            return back()->with($this->message('You have uploaded a wrong format file, please upload the right file.', 'error'));
        }

        foreach ($collections as $key => $collection) {
            if ($collection['username'] === "") {
                return back()->with($this->message('Username is required', 'error'));
            }
            if ($collection['phone_number'] === "") {
                return back()->with($this->message('Phone number is required', 'error'));
            }
            if ($collection['sale_person_id'] === "") {
                return back()->with($this->message('Sale person id is required', 'error'));
            } else {
                $user = User::find($collection['sale_person_id']);
                if (!$user) {
                    return back()->with($this->message('Sale person id ' . $collection['sale_person_id'] . ' does not exsist.. try again', 'error'));
                }
            }
            if ($collection['id']) {
                $lead = Lead::where('id', $collection['id'])->first();
                if (!$lead) {
                    return back()->with($this->message('Lead id ' . $collection['id'] . ' does not exsist.. try again ', 'error'));
                } else {
                    $lead = Lead::where('number', $collection['phone_number'])->where('id', '!==', $collection['id'])->first();
                    if ($lead) {
                        return back()->with($this->message('Phone number ' . $collection['phone_number'] . ' already exsist.. try again', 'error'));
                    }
                }
            }
        }

        foreach ($collections as $key => $collection) {
            if (empty($collection['source'])) {
                $collection['source'] = null;
            }
            if (empty($collection['source'])) {
                $collection['email'] = null;
            }
            if ($collection['id'] == "") {
                $lead = Lead::where('number', $collection['phone_number'])->first();
                if (!$lead) {
                    $lead = new Lead;
                }
                if ($lead->user_id != $collection['sale_person_id']) {
                    $lead_history = [
                        'lead_id' => $lead->id,
                        'status' => 'lead_assign',
                        'date' => date('Y-m-d H:i:s'),
                        'user_id' => Auth::user()->id,
                        'assign_to' => $collection['sale_person_id'],
                    ];
                    LeadHistory::create($lead_history);
                }
                $lead->name = $collection['username'];
                $lead->number = $collection['phone_number'];
                $lead->user_id = $collection['sale_person_id'];
                $lead->email = $collection['email'];
                $lead->source = $collection['source'];
                $lead->save();
            } else {
                $lead = Lead::where('id', $collection['id'])->first();
                if (!$lead) {
                    return back()->with($this->message("Lead id '" . $collection['id'] . "' does not exist!", "error"));
                }
                $number_lead = Lead::where('number', $collection['phone_number'])->first();
                if ($number_lead) {
                    return back()->with($this->message("Phone number '" . $collection['phone_number'] . "' already exist!", "error"));
                }
                if ($lead->user_id != $collection['sale_person_id']) {
                    $lead_history = [
                        'lead_id' => $lead->id,
                        'status' => 'lead_assign',
                        'date' => date('Y-m-d H:i:s'),
                        'user_id' => Auth::user()->id,
                        'assign_to' => $collection['sale_person_id'],
                    ];
                    LeadHistory::create($lead_history);
                }
                $lead->name = $collection['username'];
                $lead->number = $collection['phone_number'];
                $lead->user_id = $collection['sale_person_id'];
                $lead->email = $collection['email'];
                $lead->source = $collection['source'];
                $lead->save();
            }
        }
        return back()->with($this->message('Leads imported successfully!', 'success'));
    }
    public function bulk_export()
    {
        $users = get_user_by_projects();
        $lead = get_leads_from_user($users);
        $sales = $lead->whereNot('status', 'lost')->whereNot('status', 'mature')->orderBy('updated_at', 'desc')->get();
        $storage = [];
        foreach ($sales as $item) {
            $storage[] = [
                'id' => $item['id'],
                'username' => $item['name'],
                'phone_number' => $item['number'],
                'sale_person_id' => $item['user_id'],
                'source' => $item['source'],
            ];
        }
        return (new FastExcel($storage))->download('/public/assets/lead.xlsx');
    }
}
