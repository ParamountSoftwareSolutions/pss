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
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\NullType;

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
        $clients = $lead->get();
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();

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

        $sales_person = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();
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
        $request->inventory_id = 1;
        $request->project_id = 7;
        $request->project_type_id = 3;
        if ($request->old_client_id) {
            $client = Client::where('id', $request->old_client_id)->first();
            if (!empty($client->project_id)) {
                $project_type_id = Project::where('id', $client->project_id)->first()->type_id;
            } else {
                $project_type_id = Null;
            }
            $client_data = [
                'project_id' => $request->project_id,
                'project_type_id' => $request->project_type_id,
                'inventory_id' => $request->inventory_id,
                'customer_id' => Null,
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
            if (!empty(json_decode($request->building_id)->id)) {
                $project_type_id = Project::where('id', json_decode($request->building_id)->id)->first()->type_id;
            } else {
                $project_type_id = Null;
            }
            $client_data = [
                'project_id' => (!empty(json_decode($request->building_id)->id)) ? json_decode($request->building_id)->id : Null,
                'project_type_id' => $project_type_id,
                'inventory_id' => "",
                'customer_id' => Null,
                'user_id' => (!empty($request->sale_person_id)) ? $request->sale_person_id : auth()->user()->id,

                'name' => $request->name_new,
                'email' => $request->email_new,
                'password' => $request->password_new,
                'number' => $request->phone_number_new,
                'alt_phone' => $request->alt_phone,
                'dob' => $request->dob,
                'address' => $request->address,
                'cnic' => $request->cnic_new,
                'father_name' => $request->father_name_new,
                'country_id' => $request->country_id_new,
                'state_id' => $request->state_id_new,
                'city_id' => $request->city_id_new,

                'registration_number' => rand(100, 100000),
                'hidden_file_number' => "",
                'down_payment' => $request->down_payment,
                'comment' => $request->comment,
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
        $client_installment = ClientInstallment::where('client_id', $id)->orderBy('due_date', 'ASC')->get();
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
        $response = BuildingInventory::where('building_floor_id', $id)->where('status', 'available')->get()->toArray();
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
        $sale_persons = User::whereIn('id', $users)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
            })->get();
        $client = Client::with('customer', 'sale_person', 'country', 'state', 'city')->where('id', $id)->first();
        $clients = Client::with('customer')->get();

        return view('user.client.transfer', get_defined_vars());
    }
    public function transfered_store(Request $request)
    {
        $client = Client::where('id', $request->client_trnafer_id)->first();
        $client_data = [
            'project_id' => $client->project_id,
            'project_type_id' => $client->project_type_id,
            'inventory_id' => $client->inventory_id,
            'customer_id' => Null,
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
        $client_res = Client::create($client_data);
        //client Status update and create history
        Client::where('id', $request->client_trnafer_id)->update(['status' => 'transfered']);
        $client_histories_data = [
            'client_id' => $request->client_trnafer_id,
            'user_id' => auth()->user()->id,
            'status' => 'Transfered',
            'comment' => 'Client Avtive Now',
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
        if (!empty($request->building_id)) {
            $project_id = json_decode($request->building_id)->id;
        } else {
            $project_id = Null;
        }
        if (!empty($request->building_id)) {
            $type_id = json_decode($request->building_id)->type_id;
        } else {
            $type_id = Null;
        }
        if (is_numeric($request->inventory_id)) {
            $inventory_id = $request->inventory_id;
        } else {
            $inventory_id = Null;
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
            $update_status = [
                'status' => 'sold',
            ];
            BuildingInventory::where('id', $request->inventory_id)->update($update_status);
            $get_inventory_id = $request->inventory_id;
        } elseif ($type_id == '2') {
            $update_status = [
                'status' => 'sold',
            ];
            SocietyInventory::where('id', $request->inventory_id)->update($update_status);
            $get_inventory_id = $request->inventory_id;
        } elseif ($type_id == '3') {
            $update_status = [
                'status' => 'sold',
            ];
            Farmhouse::where('id', $id)->update($update_status);
            $get_inventory_id = $id;
        } elseif ($type_id == '4') {
            $update_status = [
                'status' => 'sold',
            ];
            Property::where('id', $id)->update($update_status);
            $get_inventory_id = $id;
        }

        // Change Status In Inventory Sold

        // Change Status In Client
        $update_data = [
            'status' => 'active',
        ];
        Client::where('id', $id)->update($update_data);
        $client_histories_data = [
            'client_id' => $request->id,
            'user_id' => auth()->user()->id,
            'status' => 'Active',
            'comment' => 'Client Avtive Now',
            'is_read' => 0,
        ];
        ClientHistory::create($client_histories_data);
        // Change Status In Client
        //Create Payment Plan
        if ($response) {
            $get_inventory_project_type_id = $type_id;
            $get_inventory_inventory_id = $get_inventory_id;

            $inventory = get_inventory($get_inventory_project_type_id, $get_inventory_inventory_id);
            $installment = installment($inventory->payment_plan_id);
            dd($installment);

            if ($installment['total_price'] == $installment['payment_plan']->total_price) {
                $inventory->status = 'sold';
                $inventory->save();
                dd($id, $installment, $request->down_payment);
                create_installment_plan($id, $installment, $request->down_payment);
            }
        }
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
}
