<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BuildingSale;
use App\Models\DublicateLead;
use App\Models\Lead;
use App\Models\LeadRefer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class WebHookController extends Controller
{
    public function testuser()
    {
        $user_id = User::withCount('assignee')->whereHas('roles', function ($q) {
            $q->where('name', 'sale_person');
        })->orderBy('assignee_count', 'asc')->get();
        echo '<pre>';
        print_r($user_id->toArray());
        echo '<pre>';
        die();
    }

    public function index()
    {
        return view('user.lead.facebook.index');
    }

    public function show(Request $request)
    {
        $challenge = $_REQUEST['hub_challenge'];
        $verify_token = $_REQUEST['hub_verify_token'];

        if ($verify_token === 'abc123') {
            echo $challenge;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        error_log(print_r($input, true));
    }

    public function leads($form_id, $token)
    {
        try {

            $url = "https://graph.facebook.com/v14.0/" . $form_id . "/leads?limit=9999&access_token=" . $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($output);

            $key = 0;
            if (!empty($data->data)) {
                return view('user.lead.facebook.leads', ['data' => $data, 'total_leads_insert' => $key, 'form_id' => $form_id, 'token' => $token]);
            } else {
                $output = [];
                $key = "";
                $form_id = "";
                $token = "";
                return view('user.lead.facebook.leads', ['data' => $data, 'total_leads_insert' => $key, 'form_id' => $form_id, 'token' => $token]);
            }
        } catch (\Exception $e) {
            $output = [];
            $key = "";
            $form_id = "";
            $token = "";
            return view('user.lead.facebook.leads', ['data' => $data, 'total_leads_insert' => $key, 'form_id' => $form_id, 'token' => $token]);
        }
    }

    public function leads_form($page_id, $token)
    {
        // $url = "https://graph.facebook.com/v14.0/" . $page_id . "/leadgen_forms?access_token=" . $token;
        $url = "https://graph.facebook.com/v14.0/111547548279032/leadgen_forms?access_token=EAAK0F3FROZCQBALsfAjKu83kU19AU0mdgmZAPBrSGclDS3FhVOeCDqatICFqZC90nZAgIixEyeRCwvxjL6BJghutb7MMkU6FabgRXAwxsaPeCuPcx2yR0hTzmsiZA5rqwPDHxjZCzolIZBZBJ1wXarSfxOgKWO19NyISuRN5brn2S19o0eYi2MtUypd0MY95URw6j7MjXfbzIPAd5nX3tI6VjgOueJK6UJUZD";
        // $url = "webhook/leads/1164544757488926/EAAK0F3FROZCQBAEhZCtxAyFX09k7m2zY4M7mbjA7R4MvqzKwAIltk2kPA0D9bcO2WLF1k0PyDftZB61a6WeAdYe31DB8Pf2KQmt1vZCoOtayCRFlhXoS6TuaEhzpgqU6lisTuLtKIkcqOaXLpNAMT6GAOFn7SIE4IXIBJXruGWga62ldLtpaf56gmB1hXP6vpSlpUM0TGy4hQweo7c2U7ZAhUedf8UoUZD";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);

        return view('user.lead.facebook.form', ['data' => $data, 'token' => $token]);
    }

    //leads Assign To Sale Mangers
    public function lead_assign_to_mangers($form_id, $token)
    {

        //  try {
        $url = "https://graph.facebook.com/v14.0/" . $form_id . "/leads?limit=9999&access_token=" . $token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);

        $count = User::whereHas('roles', function ($q) {
            $q->where('name', 'sale_manager');
        })->count();
        $key = 0;
        $leads = 0;

        if (!empty($data->data)) {
            foreach ($data->data as $key_data => $value) {
                $fields = array_reduce($value->field_data, static function ($fields, $entry) {
                    if ($entry->name == 'EMAIL' || $entry->name == 'email') {
                        $fields['email'] = $entry->values;
                    }
                    if ($entry->name == 'PHONE' || $entry->name == "phone_number") {
                        $fields['phone_number'] = $entry->values;
                    }
                    if ($entry->name == 'FULL_NAME' || $entry->name == "full_name") {
                        $fields['full_name'] = $entry->values;
                    }
                    return $fields;
                });


                $lead =  Lead::where('number', $fields['phone_number'][0])->first();
                if (!empty($lead)) {
                    $datainsert = [
                        'lead_id' => $value->id,
                        'user_id' => $lead->user_id,
                        'name' => $fields['full_name'][0],
                        'email' => $fields['email'][0],
                        'number' => $fields['phone_number'][0],
                    ];
                    $matchThese = ['number' => $lead->number];
                    DublicateLead::updateOrCreate($matchThese, $datainsert);
                    // DublicateLead::updateOrCreate($datainsert);
                } else {
                    $datainsert = [
                        'name' => $fields['full_name'][0],
                        'email' => $fields['email'][0],
                        'number' => $fields['phone_number'][0],
                    ];
                    Lead::insertOrIgnore($datainsert);
                    $id = DB::getPdo()->lastInsertId();
                    // if ($id) {
                    // $role = ModelsRole::where('name', 'user')->first();
                    // $user = User::find($id);
                    // $user->assignRole($role);

                    // Auto Assign Leads To User
                    // customer_id == Lead id   == $id
                    $user_id = User::whereHas('roles', function ($q) {
                        $q->where('name', 'sale_manager');
                    })->get();
                    $building_sale_data = [
                        //'customer_id' => $id,
                        'user_id' => $user_id[$key]->id,
                        'status' => 'new',
                        'type' => 'facebook_lead',
                    ];
                    $key = $key + 1;
                    $leads = $leads + 1;
                    if ($key == $count) {
                        $key = 0;
                    }
                    Lead::where('id', $id)->update($building_sale_data);
                    // }
                }
            }
        }

        if ($leads == "0") {
            return redirect()->back()->with($this->message('Leads have already added', 'success'));
        } else {
            return redirect()->back()->with($this->message($leads . ' Leads have been added successfully!', 'success'));
        }
        // } catch (\Exception $e) {
        //     return redirect()->back()->with($this->message('No Leads Added Something Went Wrong!!!', 'error'));
        // }
    }
    public function lead_assign_to_sale_person($form_id, $token)
    {

        try {

            // $url = "https://agent.psspropertiesmanager.com/property/webhook/leads/1164544757488926/EAAK0F3FROZCQBAEhZCtxAyFX09k7m2zY4M7mbjA7R4MvqzKwAIltk2kPA0D9bcO2WLF1k0PyDftZB61a6WeAdYe31DB8Pf2KQmt1vZCoOtayCRFlhXoS6TuaEhzpgqU6lisTuLtKIkcqOaXLpNAMT6GAOFn7SIE4IXIBJXruGWga62ldLtpaf56gmB1hXP6vpSlpUM0TGy4hQweo7c2U7ZAhUedf8UoUZD";
            $url = "https://graph.facebook.com/v14.0/" . $form_id . "/leads?limit=9999&access_token=" . $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($output);
            echo '<pre>';
            print_r($data);
            echo '<pre>';
            die();
            $count = User::whereHas('roles', function ($q) {
                $q->where('name', 'sale_manager');
            })->count();
            $key = 0;
            $leads = 0;

            if (!empty($data->data)) {
                foreach ($data->data as $key_data => $value) {
                    $fields = array_reduce($value->field_data, static function ($fields, $entry) {
                        if ($entry->name == 'EMAIL' || $entry->name == 'email') {
                            $fields['email'] = $entry->values;
                        }
                        if ($entry->name == 'PHONE' || $entry->name == "phone_number") {
                            $fields['phone_number'] = $entry->values;
                        }
                        if ($entry->name == 'FULL_NAME' || $entry->name == "full_name") {
                            $fields['full_name'] = $entry->values;
                        }
                        return $fields;
                    });


                    $lead =  Lead::where('number', $fields['phone_number'][0])->first();
                    if (!empty($lead)) {
                        $datainsert = [
                            'lead_id' => $value->id,
                            'user_id' => $lead->user_id,
                            'name' => $fields['full_name'][0],
                            'email' => $fields['email'][0],
                            'number' => $fields['phone_number'][0],
                        ];
                        $matchThese = ['number' => $lead->number];
                        DublicateLead::updateOrCreate($matchThese, $datainsert);
                        // DublicateLead::updateOrCreate($datainsert);
                    } else {
                        $datainsert = [
                            'name' => $fields['full_name'][0],
                            'email' => $fields['email'][0],
                            'number' => $fields['phone_number'][0],
                        ];
                        Lead::insertOrIgnore($datainsert);
                        $id = DB::getPdo()->lastInsertId();
                        // if ($id) {
                        // $role = ModelsRole::where('name', 'user')->first();
                        // $user = User::find($id);
                        // $user->assignRole($role);

                        // Auto Assign Leads To User
                        // customer_id == Lead id   == $id
                        $user_id = User::whereHas('roles', function ($q) {
                            $q->where('name', 'sale_person');
                        })->get();
                        $building_sale_data = [
                            //'customer_id' => $id,
                            'user_id' => $user_id[$key]->id,
                            'status' => 'new',
                            'type' => 'facebook_lead',
                        ];
                        $key = $key + 1;
                        $leads = $leads + 1;
                        if ($key == $count) {
                            $key = 0;
                        }
                        Lead::where('id', $id)->update($building_sale_data);
                        // }
                    }
                }
            }


            if ($leads == "0") {
                return redirect()->back()->with($this->message('Leads have already added', 'success'));
            } else {
                return redirect()->back()->with($this->message($leads . ' Leads have been added successfully!', 'success'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($this->message('No Leads Create Something Went Wrong!!!', 'error'));
        }
    }
    public function lead_assign_to_me($page, $form_id, $token)
    {
        try {
            $url = "https://graph.facebook.com/v14.0/" . $form_id . "/leads?limit=9999&access_token=" . $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($output);

            $count = User::whereHas('roles', function ($q) {
                $q->where('name', 'sale_manager');
            })->count();
            $key = 0;
            $leads = 0;

            if (!empty($data->data)) {
                foreach ($data->data as $key_data => $value) {
                    $fields = array_reduce($value->field_data, static function ($fields, $entry) {
                        if ($entry->name == 'EMAIL' || $entry->name == 'email') {
                            $fields['email'] = $entry->values;
                        }
                        if ($entry->name == 'PHONE' || $entry->name == "phone_number") {
                            $fields['phone_number'] = $entry->values;
                        }
                        if ($entry->name == 'FULL_NAME' || $entry->name == "full_name") {
                            $fields['full_name'] = $entry->values;
                        }
                        return $fields;
                    });


                    $lead =  Lead::where('number', $fields['phone_number'][0])->first();
                    if (!empty($lead)) {
                        $datainsert = [
                            'lead_id' => $value->id,
                            'user_id' => $lead->user_id,
                            'name' => $fields['full_name'][0],
                            'email' => $fields['email'][0],
                            'number' => $fields['phone_number'][0],
                        ];
                        $matchThese = ['number' => $lead->number];
                        DublicateLead::updateOrCreate($matchThese, $datainsert);
                        // DublicateLead::updateOrCreate($datainsert);
                    } else {
                        $datainsert = [
                            'name' => $fields['full_name'][0],
                            'email' => $fields['email'][0],
                            'number' => $fields['phone_number'][0],
                        ];
                        Lead::insertOrIgnore($datainsert);
                        $id = DB::getPdo()->lastInsertId();
                        $building_sale_data = [
                            'user_id' => auth()->user()->id,
                            'status' => 'new',
                            'type' => 'facebook_lead',
                        ];
                        $key = $key + 1;
                        $leads = $leads + 1;
                        if ($key == $count) {
                            $key = 0;
                        }
                        Lead::where('id', $id)->update($building_sale_data);
                    }
                }
            }
            if ($leads == "0") {
                return redirect()->back()->with($this->message('Leads have already added', 'success'));
            } else {
                return redirect()->back()->with($this->message($leads . ' Leads have been added successfully!', 'success'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($this->message('No Leads Create Something Went Wrong!!!', 'error'));
        }
    }
    public function lead_assign_to_both($page, $form_id, $token)
    {

        try {
            $url = "https://graph.facebook.com/v14.0/" . $form_id . "/leads?limit=9999&access_token=" . $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($output);

            $count = User::whereHas('roles', function ($q) {
                $q->where('name', 'sale_person');
                $q->orWhere('name', 'sale_manager');
            })->count();
            $key = 0;
            $leads = 0;

            if (!empty($data->data)) {
                foreach ($data->data as $key_data => $value) {
                    $fields = array_reduce($value->field_data, static function ($fields, $entry) {
                        if ($entry->name == 'EMAIL' || $entry->name == 'email') {
                            $fields['email'] = $entry->values;
                        }
                        if ($entry->name == 'PHONE' || $entry->name == "phone_number") {
                            $fields['phone_number'] = $entry->values;
                        }
                        if ($entry->name == 'FULL_NAME' || $entry->name == "full_name") {
                            $fields['full_name'] = $entry->values;
                        }
                        return $fields;
                    });


                    $lead =  Lead::where('number', $fields['phone_number'][0])->first();
                    if (!empty($lead)) {
                        $datainsert = [
                            'lead_id' => $value->id,
                            'user_id' => $lead->user_id,
                            'name' => $fields['full_name'][0],
                            'email' => $fields['email'][0],
                            'number' => $fields['phone_number'][0],
                        ];
                        $matchThese = ['number' => $lead->number];
                        DublicateLead::updateOrCreate($matchThese, $datainsert);
                        // DublicateLead::updateOrCreate($datainsert);
                    } else {
                        $datainsert = [
                            'name' => $fields['full_name'][0],
                            'email' => $fields['email'][0],
                            'number' => $fields['phone_number'][0],
                        ];
                        Lead::insertOrIgnore($datainsert);
                        $id = DB::getPdo()->lastInsertId();
                        // Auto Assign Leads To User
                        // customer_id == Lead id   == $id
                        $user_id = User::whereHas('roles', function ($q) {
                            $q->where('name', 'sale_manager');
                            $q->where('name', 'sale_person');
                        })->get();
                        $building_sale_data = [
                            'user_id' => $user_id[$key]->id,
                            'status' => 'new',
                            'type' => 'facebook_lead',
                        ];
                        $key = $key + 1;
                        $leads = $leads + 1;
                        if ($key == $count) {
                            $key = 0;
                        }
                        Lead::where('id', $id)->update($building_sale_data);
                    }
                }
            }

            if ($leads == "0") {
                return redirect()->back()->with($this->message('Leads have already added', 'success'));
            } else {
                return redirect()->back()->with($this->message($leads . ' Leads have been added successfully!', 'success'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($this->message('No Leads Create Something Went Wrong!!!', 'error'));
        }
    }
    public function dublicate(Request $request)
    {
        $dublicates = DublicateLead::all();

        return view('user.lead.dublicate.index', get_defined_vars());
    }
    public function dublicate_store($id)
    {
        $dublicate = Lead::where('id', $id)->first();
        $data = [
            'created_by' => auth()->user()->id,
            'name' => $dublicate->name,
            'email' => $dublicate->email,
            'number' => $dublicate->number,
            'cnic' => $dublicate->cnic,
            'status' => 'new',
            'type' => 'lead',
        ];
        $response = Lead::where('id', $id)->update($data);
        //DublicateLead::where('lead_id', $id)->delete();
        if ($response) {
            return redirect()->back()->with('success', 'Lead Update Successfully');
        } else {
            return redirect()->back()->with('error', 'SomeThing Went Wrong');
        }
    }
}
