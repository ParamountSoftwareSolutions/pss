<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Helpers\MessageHelpers;
use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingCustomer;
use App\Models\BuildingPaymentPlan;
use App\Models\BuildingMobileApplication;
use App\Models\BuildingSale;
use App\Models\BuildingSaleHistory;
use App\Models\BuildingSaleInstallment;
use App\Models\City;
use App\Models\ClientInstallment;
use App\Models\Country;
use App\Models\FloorDetail;
use App\Models\State;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\BuildingEmployee;
use App\Models\BuildingInventory;
use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Farmhouse;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Property;
use App\Models\SocietyInventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\NullType;

use function GuzzleHttp\Promise\all;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $building = get_all_projects();
        $users = get_user_by_projects();
        $lead = get_clients_from_user($users);

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
        //Table salePersonFilter

        if ($request->salePersonFilter) {
            $lead->where('user_id', $request->salePersonFilter);
        }
        //Table statusFilter

        if ($request->statusFilter) {
            $lead->where('status', $request->statusFilter);
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

        $clients = $lead->orderBy('updated_at', 'desc')->get();

        $sale_persons = User::whereIn('id', $users)->get();

        $country = Country::get();
        $client_count = $lead->count();
        return view('user.client.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function create()
    {
        $country = Country::get();
        $users = get_user_by_projects();

        $project = get_all_projects();

        $projects = Project::whereIn('id', $project->pluck('id')->toArray())->get();

        $sale_persons = User::whereIn('id', $users)->get();
        $old_clients = Client::all();

        return view('user.client.create', get_defined_vars());
    }


    public function state($panel, $country_id)
    {
        //$country = Country::where('sortname', $country_id)->first();
        $state = State::where('country_id', $country_id)->get();
        return json_encode($state);
    }

    public function city($panel, $country_id)
    {
        $state = City::where('state_id', $country_id)->get();
        return json_encode($state);
    }

    public function old_client($panel, $id)
    {
        $client = User::findOrFail($id);
        return json_encode($client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Old Client Store In database
        if ($request->client_type == "old") {
            $client = Client::where('id', $request->old_client)->first();
            if (!empty($client->project_id)) {
                $project_type_id = Project::where('id', $client->project_id)->first()->type_id;
            } else {
                $project_type_id = Null;
            }
            $client_data = [
                'project_id' => $request->project_id,
                'project_type_id' => $request->project_type_id,
                'inventory_id' => $request->inventory_id,
                'customer_id' => $request->customer_id,
                'user_id' => auth()->user()->id,
                'name' => $client->name,
                'email' => $client->email,
                'password' => $client->password,
                'number' => $client->number,
                'alt_phone' => $client->alt_phone,
                'dob' => $client->dob,
                'address' => $client->address,
                'cnic' => $client->cnic,
                'father_name' => $client->father_name,
                'country_id' => $client->country_id,
                'state_id' => $client->state_id,
                'city_id' => $client->city_id,
                'registration_number' => rand(100, 100000),
                'hidden_file_number' => "",
                'down_payment' => $client->down_payment,
                'comment' => $client->comment,
                'created_by' => auth()->user()->id,
                'status' => 'mature',
            ];
        } else {

            // New Client Store In database
            $request->validate([
                'name_new' => 'required',
                'phone_number_new' => 'required|unique:leads,number',
                'phone_number_new' => 'unique:leads,alt_number',
                'email_new' => 'unique:leads,email',
                'father_name_new' => 'required',
                'cnic_new' => 'required',
                'address_new' => 'required',
                'dob_new' => 'required',
                'password_new' => 'required',
                'down_payment' => 'required',
            ]);
            // $validator = Validator::make($request->all(), [
            //     'name_new' => 'required',
            //     'phone_number_new' => 'required|unique:leads,number',
            //     'phone_number_new' => 'unique:leads,alt_number',
            //     'email_new' => 'unique:leads,email',
            //     'father_name_new' => 'required',
            //     'cnic_new' => 'required',
            //     'address_new' => 'required',
            //     'dob_new' => 'required',
            //     'password_new' => 'required',
            //     'down_payment' => 'required',
            // ]);
            // if ($validator->fails()) {
            //     return redirect()->back()->with(['status' => 'error', 'message' => $validator->errors()->first()]);
            // }
            if (!empty(json_decode($request->building_id)->id)) {
                $project_type_id = Project::where('id', json_decode($request->building_id)->id)->first()->type_id;
            } else {
                $project_type_id = Null;
            }
            $datalead = [
                'name' => $request->name_new,
                'number' => $request->phone_number_new,
                'cnic' => $request->cnic_new,
                'alt_number' => $request->alt_phone
            ];
            $user = Lead::create($datalead);
            $client_data = [
                'project_id' => (!empty(json_decode($request->building_id)->id)) ? json_decode($request->building_id)->id : Null,
                'project_type_id' => $project_type_id,
                'inventory_id' => "",
                'customer_id' => $user->id,
                'user_id' => (!empty($request->sale_person_id)) ? $request->sale_person_id : auth()->user()->id,

                'name' => $request->name_new,
                'email' => $request->email_new,
                'password' => $request->password_new,
                'number' => $request->phone_number_new,
                'alt_phone' => $request->alt_phone,
                'dob' => $request->dob_new,
                'address' => $request->address_new,
                'cnic' => $request->cnic_new,
                'father_name' => $request->father_name_new,
                'country_id' => $request->country_id_new,
                'state_id' => $request->state_id_new,
                'city_id' => $request->city_id_new,

                'registration_number' => rand(100, 100000),
                'hidden_file_number' => "",
                'down_payment' => $request->down_payment,
                // 'comment' => $request->comment,
                'created_by' => auth()->user()->id,
                'status' => 'mature',
            ];
        }

        $client = Client::create($client_data);

        if ($client) {
            // task_count_increment('client');
            // $inventory = get_inventory($client->project_type_id,$client->inventory_id);
            // $installment = installment($inventory->payment_plan_id);
            // if ($installment['total_price'] == $installment['payment_plan']->total_price) {
            //     $inventory->status = 'sold';
            //     $inventory->save();
            //     create_installment_plan($client->id,$installment,$request->down_payment);
            // }

            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('success', 'Client Insert Successfully');
        } else {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        if ($client->status == "transfered" || $client->status == 'Transfered') {
            $client_installment = ClientInstallment::where('client_id', $id)->where('project_id', $client->project_id)->where('inventory_id', $client->inventory_id)->orderBy('due_date', 'ASC')->get();
        } else {
            $client_installment = ClientInstallment::where('project_id', $client->project_id)->where('inventory_id', $client->inventory_id)->orderBy('due_date', 'ASC')->get();
        }

        return view('user.client.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $country = Country::get();
        $users = get_user_by_projects();
        $project = get_all_projects();
        $projects = Project::whereIn('id', $project->pluck('project_id')->toArray())->get();
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();
        $client = Client::with('customer', 'sale_person', 'country', 'state', 'city')->where('id', $id)->first();

        $clients = Client::with('customer')->get();
        return view('user.client.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // $project_type_id = Project::where('id', json_decode($request->building_id)->id)->first()->type_id;
        $client_data = [
            'user_id' => (!empty($request->sale_person_id)) ? $request->sale_person_id : Null,
            'name' => $request->name_new,
            'email' => $request->email_new,
            'password' => $request->password_new,
            'number' => $request->phone_number_new,
            'alt_phone' => $request->alt_phone_new,
            'address' => $request->address_new,
            'cnic' => $request->cnic_new,
            'down_payment' => $request->down_payment,
            'dob' => $request->dob_new,
            'father_name' => $request->father_name_new,
            'country_id' => $request->country_id_new,
            'state_id' => $request->state_id_new,
            'city_id' => $request->city_id_new,
            'hidden_file_number' => "",
            'down_payment' => $request->down_payment,
            'created_by' => auth()->user()->id,
            'status' => 'mature',
        ];
        $response = Client::where('id', $id)->update($client_data);
        if ($response) {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('success', 'Client Update Successfully');
        } else {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($panel, $id)
    {
    }








    public function changePriority($priority, $id)
    {
        $data = [
            'priority' => $priority,
        ];
        $response = Client::where('id', $id)->update($data);
        if ($response) {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('success', 'Priority Has Update Successfully');
        } else {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'Priority not updated successfully, something went wrong. Try again');
        }
    }


    // get inventories
    public function building_inventory($id)
    {

        $response = BuildingInventory::where('building_floor_id', $id)->where('status', 'available')->get()->toArray();
        // $data = json_encode($response->toArray());
        $data = json_encode($response);
        return  $data;
    }
    public function societyBlock_inventory($id)
    {
        $response = SocietyInventory::where('block_id', $id)->where('status', 'available')->get()->toArray();
        // $data = json_encode($response->toArray());
        $data = json_encode($response);
        return  $data;
    }

    // get inventories
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
        Client::where('id', $request->id)->update($lead_data);
        $lead_histories_data = [
            'client_id' => $request->id,
            'user_id' => auth()->user()->id,
            'status' => $request->status,
            'date' => $request->date,
            'comment' => $request->comment,
            // 'call_status' => $request->call_status,
            // 'start_time' => $request->start_time,
            // 'end_time' => $request->end_time,
            // 'call_time' => $request->call_time,
            'is_read' => 0,
        ];

        $response = ClientHistory::create($lead_histories_data);
        if ($response) {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('success', 'Status has updated successfully');
        } else {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'Status not updated successfully, something went wrong. Try again');
        }
    }
    public function comments($id)
    {

        $comments = ClientHistory::where('client_id', $id)->orderBy('id', 'desc')->get();
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
                return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('success', 'Lead Update Successfully');
            } else {
                return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
            }
        } else {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'Please select first any lead');
        }
    }
    public function client_transfered($id)
    {
        $country = Country::get();
        $users = get_user_by_projects();
        $project = get_all_projects();
        $projects = Project::whereIn('id', $project->pluck('id')->toArray())->get();
        $sale_persons = User::whereIn('id', $users)->get();
        $client = Client::with('customer', 'sale_person', 'country', 'state', 'city')->where('id', $id)->first();
        $clients = Client::with('customer')->get();
        $old_clients = Client::all();
        return view('user.client.transfer', get_defined_vars());
    }
    public function transfered_store(Request $request)
    {

        if ($request->client_type == "old") {
            $client = Client::where('id', $request->old_client)->first();
            $client_data = [
                'project_id' => $request->project_id,
                'project_type_id' => $request->project_type_id,
                'inventory_id' => $request->inventory_id,
                'customer_id' => $client->customer_id,
                'user_id' => auth()->user()->id,
                'name' => $client->name,
                'email' => $client->email,
                'password' => $client->password,
                'number' => $client->number,
                'alt_phone' => $client->alt_phone,
                'dob' => $client->dob,
                'address' => $client->address,
                'cnic' => $client->cnic,
                'father_name' => $client->father_name,
                'country_id' => $client->country_id,
                'state_id' => $client->state_id,
                'city_id' => $client->city_id,
                'registration_number' => rand(100, 100000),
                'hidden_file_number' => "",
                'down_payment' => $client->down_payment,
                'comment' => $client->comment,
                'created_by' => auth()->user()->id,
                'status' => 'mature',
            ];
        } else {


            $client = Client::where('id', $request->client_trnafer_id)->first();
            $datalead = [
                'name' => $request->name_new,
                'number' => $request->phone_number_new,
                'cnic' => $request->cnic_new,
                'alt_number' => $request->alt_phone
            ];
            $user = Lead::create($datalead);
            $customer_id = $user->id;

            $client_data = [
                'project_id' => $request->project_id,
                'project_type_id' => $request->project_type_id,
                'inventory_id' => $request->inventory_id,
                'registration_number' => $client->registration_number,
                'customer_id' => $customer_id,
                'user_id' => auth()->user()->id,
                'name' => $request->name_new,
                'email' => $request->email_new,
                'password' => $request->password_new,
                'number' => $request->phone_number_new,
                'alt_phone' => $request->alt_phone_new,
                'address' => $request->address_new,
                'cnic' => $request->cnic_new,
                'down_payment' => $request->down_payment,
                'dob' => $request->dob_new,
                'father_name' => $request->father_name_new,
                'country_id' => $request->country_id_new,
                'state_id' => $request->state_id_new,
                'city_id' => $request->city_id_new,
                'hidden_file_number' => "",
                'down_payment' => $request->down_payment,
                'created_by' => auth()->user()->id,
                'status' => 'mature',
            ];
        }

        $client_res = Client::create($client_data);
        $client_id = $client_res->id;

        //Inventory Id Updates 
        $installmentData = [
            'client_id' => $client_id
        ];
        //         $check  = ClientInstallment::where('project_type_id', $request->project_type_id)->where('inventory_id', $request->inventory_id)->where('client_id', $client->id)->where('status', 'not_paid')->get();
        // echo '<pre>';
        // print_r($check->toArray());
        // echo '<pre>';
        // die();
        ClientInstallment::where('project_id', $request->project_id)->where('inventory_id', $request->inventory_id)->where('client_id', $request->client_trnafer_id)->where('status', 'not_paid')->update($installmentData);

        // if ($client->project_type_id == "1") {
        //     //building

        // } elseif ($client->project_type_id == "2") {
        //     //society
        // } elseif ($client->project_type_id == "3") {
        //     //farm_house
        // } elseif ($client->project_type_id == "4") {
        //     //property
        // }
        //Inventory Id Updates 

        //client Status update and create history
        Client::where('id', $request->client_trnafer_id)->update(['status' => 'transfered']);
        $client_histories_data = [
            'client_id' => $request->client_trnafer_id,
            'user_id' => auth()->user()->id,
            'transfer_to' => $client_id,
            'price' => $request->price,
            'inventory_id' => $client->inventory_id,
            'project_type_id' => $client->project_type_id,
            'status' => 'Transfered',
            'comment' => $request->comment,
            'is_read' => 0,
        ];
        ClientHistory::create($client_histories_data);
        //client Status update and create history
        if ($client_res) {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('success', 'Client Insert Successfully');
        } else {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }
    public function client_active($id)
    {
        $country = Country::get();
        $users = get_user_by_projects();
        $project = get_all_projects();
        $projects = Project::whereIn('id', $project->pluck('id')->toArray())->get();
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();
        $client = Client::with('customer', 'sale_person', 'country', 'state', 'city')->where('id', $id)->first();
        $clients = Client::with('customer')->get();
        return view('user.client.active', get_defined_vars());
    }
    public function active(Request $request, $id)
    {


        $request->validate([
            // 'building_id' => 'required',
            // 'inventory_id' => 'required',
            'name_new' => 'required',
            'phone_number_new' => 'required|unique:leads,number',
            'phone_number_new' => 'unique:leads,alt_number',
            'email_new' => 'unique:leads,email',
            'father_name_new' => 'required',
            'cnic_new' => 'required',
            'address_new' => 'required',
            'dob_new' => 'required',
            'password_new' => 'required',
            'down_payment' => 'required',
        ]);

        if (!empty($request->building_id)) {
            $project_id = json_decode($request->building_id)->id;
        } else {
            $project_id = $request->project_id;
        }
        if (!empty($request->building_id)) {
            $type_id = json_decode($request->building_id)->type_id;
        } else {
            $type_id = $request->project_type_id;
        }

        if (!empty($request->client_inventory_id)) {
            $inventory_id = $request->client_inventory_id;
        } elseif (!empty($request->building_inventory_id)) {
            $inventory_id = $request->building_inventory_id;
        } elseif (!empty($request->society_inventory_id)) {
            $inventory_id = $request->society_inventory_id;
        }
        if (empty($inventory_id)) {
            return redirect()->back()->with($this->message('Select Inventory First', 'error'));
        }
        $client_data = [
            'project_id' => $project_id,
            'project_type_id' => $type_id,
            'inventory_id' => $inventory_id,
            'user_id' => (!empty($request->sale_person_id)) ? $request->sale_person_id : Null,
            'name' => $request->name_new,
            'email' => $request->email_new,
            'password' => $request->password_new,
            'number' => $request->phone_number_new,
            'alt_phone' => $request->alt_phone_new,
            'address' => $request->address_new,
            'cnic' => $request->cnic_new,
            'down_payment' => $request->down_payment,
            'dob' => $request->dob_new,
            'father_name' => $request->father_name_new,
            'country_id' => $request->country_id_new,
            'state_id' => $request->state_id_new,
            'city_id' => $request->city_id_new,
            'hidden_file_number' => "",
            'down_payment' => $request->down_payment,
            'created_by' => auth()->user()->id,
            'status' => 'mature',
        ];

        $response = Client::where('id', $id)->update($client_data);
        // Change Status In Inventory Sold   
        if ($type_id == '1') {
            $soldornot = BuildingInventory::where('id', $inventory_id)->first();

            if ($soldornot->status == 'available') {
                $update_status = [
                    'status' => 'sold',
                ];
                BuildingInventory::where('id', $inventory_id)->update($update_status);
                $get_inventory_id = $inventory_id;
                $get_inventory_project_type_id = $type_id;
                $get_inventory_inventory_id = $get_inventory_id;
                $inventory = get_inventory($get_inventory_project_type_id, $get_inventory_inventory_id);
                $installment = installment($inventory->payment_plan_id);

                if ($installment['total_price'] == $installment['payment_plan']->total_price) {
                    $inventory->status = 'sold';
                    $inventory->save();
                    create_installment_plan($id, $project_id, $inventory_id, $installment, $request->down_payment);
                }
            }
        } elseif ($type_id == '2') {
            $soldornot = SocietyInventory::where('id', $inventory_id)->first();
            if ($soldornot->status == 'available') {
                $update_status = [
                    'status' => 'sold',
                ];
                SocietyInventory::where('id', $inventory_id)->update($update_status);
                $get_inventory_id = $inventory_id;
                $get_inventory_project_type_id = $type_id;
                $get_inventory_inventory_id = $get_inventory_id;
                $inventory = get_inventory($get_inventory_project_type_id, $get_inventory_inventory_id);
                $installment = installment($inventory->payment_plan_id);
                if ($installment['total_price'] == $installment['payment_plan']->total_price) {
                    $inventory->status = 'sold';
                    $inventory->save();
                    create_installment_plan($id, $project_id, $inventory_id, $installment, $request->down_payment);
                }
            }
        } elseif ($type_id == '3') {
            $soldornot = Farmhouse::where('id', $inventory_id)->first();
            if ($soldornot->status == 'available') {
                $update_status = [
                    'status' => 'sold',
                ];
                Farmhouse::where('id', $id)->update($update_status);
                $get_inventory_id = $id;
                $get_inventory_project_type_id = $type_id;
                $get_inventory_inventory_id = $get_inventory_id;
                $inventory = get_inventory($get_inventory_project_type_id, $get_inventory_inventory_id);
                $installment = installment($inventory->payment_plan_id);
                if ($installment['total_price'] == $installment['payment_plan']->total_price) {
                    $inventory->status = 'sold';
                    $inventory->save();
                    create_installment_plan($id, $project_id, $inventory_id, $installment, $request->down_payment);
                }
            }
        } elseif ($type_id == '4') {
            $soldornot = Property::where('id', $inventory_id)->first();
            if ($soldornot->status == 'available') {
                $update_status = [
                    'status' => 'sold',
                ];
                Property::where('id', $id)->update($update_status);
                $get_inventory_id = $id;
                $get_inventory_project_type_id = $type_id;
                $get_inventory_inventory_id = $get_inventory_id;
                $inventory = get_inventory($get_inventory_project_type_id, $get_inventory_inventory_id);
                $installment = installment($inventory->payment_plan_id);
                if ($installment['total_price'] == $installment['payment_plan']->total_price) {
                    $inventory->status = 'sold';
                    $inventory->save();
                    create_installment_plan($id, $project_id, $inventory_id, $installment, $request->down_payment);
                }
            }
        }
        // Change Status In Inventory Sold   
        // Update Payment Plan

        // Update Payment Plan

        // Change Status In Client
        $update_data = [
            'status' => 'active',
        ];
        Client::where('id', $id)->update($update_data);
        $client_histories_data = [
            'client_id' => $request->id,
            'user_id' => auth()->user()->id,
            'status' => 'Active',
            'comment' => $request->comment,
            'is_read' => 0,
        ];
        ClientHistory::create($client_histories_data);
        // Change Status In Client

        if ($response) {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('success', 'Client Active Successfully');
        } else {
            return redirect()->route('clients.index', ['RolePrefix' => RolePrefix()])->with('error', 'SomeThing Went Wrong');
        }
    }
    public function installment(Request $request, $client_id, $id)
    {
        $client = Client::findOrFail($client_id);
        $installment = ClientInstallment::findOrFail($id);
        $installment->payment_method = $request->payment_method;
        $installment->status = $request->status;
        $installment->save();
        if ($installment) {
            return redirect()->back()->with($this->message('Installment has updated successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message('Installment Update Error', 'danger'));
        }
    }

    //Inventory Sale History
    public function history()
    {
        $building = get_all_projects();
        $users = get_user_by_projects();


        $clientHistory = ClientHistory::with('from', 'to', 'sale_person')->whereIn('user_id', $users)->where('status', 'Transfered')->get();

        return view('user.client.sale_history.index', get_defined_vars());
    }
    public function history_sale($client_id)
    {
        $client = Client::findOrFail($client_id);

        $client_installment = ClientInstallment::where('project_id', $client->project_id)->where('inventory_id', $client->inventory_id)->orderBy('due_date', 'ASC')->get();

        return view('user.client.sale_history.show', get_defined_vars());
    }
    //Inventory Sale History
}
