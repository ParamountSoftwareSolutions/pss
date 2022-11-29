<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BuildingSale;
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
        $url = "https://graph.facebook.com/v14.0/" . $page_id . "/leadgen_forms?access_token=" . $token;
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
    public function lead_assign_to_mangers($page, $form_id, $token)
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

                    $datainsert = [
                        'lead_id' => $value->id,
                        'username' => $fields['full_name'][0],
                        'email' => $fields['email'][0],
                        'phone_number' => $fields['phone_number'][0],
                    ];

                    $user = User::insertOrIgnore($datainsert);
                    $id = DB::getPdo()->lastInsertId();

                    if ($id) {
                        $role = ModelsRole::where('name', 'user')->first();
                        $user = User::find($id);
                        $user->assignRole($role);

                        // Auto Assign Leads To User
                        // customer_id == Lead id   == $id
                        $user_id = User::whereHas('roles', function ($q) {
                            $q->where('name', 'sale_manager');
                        })->get();
                        $building_sale_data = [
                            'customer_id' => $id,
                            'user_id' => $user_id[$key]->id,
                            'order_status' => 'new',
                            'order_type' => 'facebook',
                        ];
                        $key = $key + 1;
                        $leads = $leads + 1;
                        if ($key == $count) {
                            $key = 0;
                        }
                        BuildingSale::insert($building_sale_data);
                    }
                }
            }
            if ($leads == "0") {
                return redirect()->back()->with($this->message('Leads have already added', 'success'));
            } else {
                return redirect()->back()->with($this->message($leads . ' Leads have been added successfully!', 'success'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with($this->message('No Leads Added Something Went Wrong!!!', 'error'));
        }
    }
    public function lead_assign_to_sale_person($page, $form_id, $token)
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

                    $datainsert = [
                        'lead_id' => $value->id,
                        'username' => $fields['full_name'][0],
                        'email' => $fields['email'][0],
                        'phone_number' => $fields['phone_number'][0],
                    ];

                    $user = User::insertOrIgnore($datainsert);
                    $id = DB::getPdo()->lastInsertId();

                    if ($id) {
                        $role = ModelsRole::where('name', 'user')->first();
                        $user = User::find($id);
                        $user->assignRole($role);

                        // Auto Assign Leads To User
                        // customer_id == Lead id   == $id
                        $user_id = User::whereHas('roles', function ($q) {
                            $q->where('name', 'sale_person');
                        })->get();
                        $building_sale_data = [
                            'customer_id' => $id,
                            'user_id' => $user_id[$key]->id,
                            'order_status' => 'new',
                            'order_type' => 'facebook',
                        ];
                        $key = $key + 1;
                        $leads = $leads + 1;
                        if ($key == $count) {
                            $key = 0;
                        }
                        BuildingSale::insert($building_sale_data);
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
}
