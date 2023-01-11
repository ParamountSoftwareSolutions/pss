<?php

use App\Models\BuildingInventory;
use App\Models\Client;
use App\Models\Farmhouse;
use App\Models\PaymentPlan;
use App\Models\Lead;
use App\Models\Project;
use App\Models\ProjectAssignUser;
use App\Models\ProjectType;
use App\Models\Property;
use App\Models\SocietyInventory;
use App\Models\ClientInstallment;
use App\Models\User;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('RolePrefix')) {
    function RolePrefix()
    {
        return Auth::user()->roles->pluck('name')[0];
    }
}
/**
 * get_leads_from_user
 *
 * @return response()
 */
if (!function_exists('get_leads_from_user')) {
    function get_leads_from_user($users)
    {
        if (Auth::user()->hasRole('sale_person')) {
            return Lead::with('sale_person', 'building')->where('user_id', Auth::id());
        }
        if (Auth::user()->hasRole('sale_manager')) {
            return Lead::with('sale_person', 'building')->whereIn('user_id', $users);
        }
        if (Auth::user()->hasRole('property_manager')) {
            return  Lead::with('sale_person', 'building')->whereIn('user_id', $users);
        }
        if (Auth::user()->hasRole('property_admin')) {
            return Lead::with('sale_person', 'building');
        }
    }
}
/**
 * get_leads_from_user
 *
 * @return response()
 */
if (!function_exists('get_clients_from_user')) {
    function get_clients_from_user($users)
    {
        if (Auth::user()->hasRole('sale_person')) {
            return Client::where('user_id', Auth::id());
        }
        if (Auth::user()->hasRole('sale_manager')) {
            return Client::whereIn('user_id', $users);
        }
        if (Auth::user()->hasRole('property_manager')) {
            return  Client::with('project', 'user', 'customer')->whereIn('user_id', $users);
        }
        if (Auth::user()->hasRole('property_admin')) {
            return Client::with('sale_person');
        }
    }
}
/**
 * get_user_by_projects
 *
 * @return response()
 */
if (!function_exists('get_user_by_projects')) {
    function get_user_by_projects()
    {
        if (Auth::user()->roles[0]->name == 'property_admin') {
            $project = ProjectAssignUser::get();
        } else {
            $project = ProjectAssignUser::where('user_id', auth()->user()->id)->get();
        }
        $user = ProjectAssignUser::groupBy('user_id')->whereIn('project_id', $project->pluck('project_id')->toArray())->where('user_id', '!=', auth()->user()->id)->get()->pluck('user_id');
        $a2 = array(Auth::user()->id);
        return array_merge($user->toArray(), $a2);
    }
}

if (!function_exists('project_type')) {
    function project_type($type)
    {
        return ProjectType::where('name', $type)->first()->id;
    }
}
/**
 * get_all_projects
 *
 * @return response()
 */
if (!function_exists('get_all_projects')) {
    function get_all_projects($type = null)
    {
        if ($type !== null) {
            $project_type = project_type($type);
            $list = ProjectAssignUser::where('user_id', Auth::id())->get();
            return Project::whereIn('id', $list->pluck('project_id')->toArray())->where('type_id', $project_type)->get();
        } else {
            $list = ProjectAssignUser::where('user_id', Auth::id())->get();
            return Project::whereIn('id', $list->pluck('project_id')->toArray())->get();
        }
    }
}

if (!function_exists('block')) {
    function block($id)
    {
        return \App\Models\Block::find($id)->name;
    }
}
if (!function_exists('get_inventory')) {
    function get_inventory($type_id, $inventory_id)
    {
        if ($type_id == 1) {
            $inventory = BuildingInventory::findOrFail($inventory_id);
        } elseif ($type_id == 2) {
            $inventory = SocietyInventory::findOrFail($inventory_id);
        } elseif ($type_id == 3) {
            $inventory = Farmhouse::findOrFail($inventory_id);
        } else {
            $inventory = Property::findOrFail($inventory_id);
        }
        return $inventory;
    }
}
if (!function_exists('get_inventory_by_project')) {
    function get_inventory_by_project($project_id)
    {
        if ($project_id) {
            $project = Project::findOrFail($project_id);
            if ($project->type_id == 1) {
                $inventories = BuildingInventory::where('project_id', $project_id)->get();
            } elseif ($project->type_id == 2) {
                $inventories = SocietyInventory::where('project_id', $project_id)->get();
            } elseif ($project->type_id == 3) {
                $inventories = Farmhouse::where('project_id', $project_id)->get();
            } else {
                $inventories = Property::where('project_id', $project_id)->get();
            }
        } else {
            $inventories = null;
        }

        return $inventories;
    }
}

if (!function_exists('installment')) {
    function installment($payment_plan_id)
    {
        $payment_plan = PaymentPlan::findOrFail($payment_plan_id);
        $a1 = [];
        $a2 = [];
        $a3 = [];
        $a4 = [];
        $total = [];
        $total_per_year_price = 0;
        // Calculation Payment Plan
        $current_date = Carbon::now()->format('Y-m-d');
        $total_month = $payment_plan->total_month_installment;
        $after_installment_date = Carbon::now()->addMonths($total_month)->addDay()->format('Y-m-d');
        $extra_total_price = [
            'down_payment' => [$payment_plan->down_payment, $current_date],
            'confirmation_amount' => [$payment_plan->confirmation_amount, $current_date],
            'balloting' => [$payment_plan->balloting_price, $after_installment_date],
            'possession' => [$payment_plan->possession_price, $after_installment_date],
        ];
        foreach ($extra_total_price as $key => $data) {
            array_push($a1, [
                'title' => $key,
                'amount' => $data[0],
                'due_date' => $data[1],
                'created_at' => $current_date,
            ]);
        }

        if ($payment_plan->half_year_installment !== null && $total_month >= 12) {
            $price_per_year = $payment_plan->half_year_installment;
            $yearly_month = $total_month / 6;
            $monthly = ($total_month / 12) * 10;
            $date = Carbon::now();

            for ($i = 0; $yearly_month > $i; $i++) {
                $a2[$i] = $price_per_year;
            }
            foreach ($a2 as $data) {
                array_push($a1, [
                    'title' => 'yearly',
                    'amount' => $data,
                    'due_date' => $date->addMonths(6)->format('Y-m-d'),
                    'created_at' => Carbon::now()->addMonths(6),
                ]);
            }
            for ($i = 1; $monthly >= $i; $i++) {
                $a3[$i] = $payment_plan->per_month_installment;
            }
            $end = count($a3) / 5;
            for ($i = 1; $i <= $end; $i++) {
                $skip_month[] = $i;
            }
            $month_date = Carbon::now();
            foreach ($a3 as $key => $data) {
                array_push($a1, [
                    'title' => 'installment',
                    'amount' => $data,
                    'due_date' => $month_date->addMonth()->format('Y-m-d'),
                    'created_at' => Carbon::now()->addMonths($key),
                ]);
                $skip = $key / 5;
                if (in_array($skip, $skip_month)) {
                    $month_date->addMonth();
                }
            }
        } elseif ($payment_plan->quarterly_payment !== null && $total_month >= 12) {
            $quarterly_price = $payment_plan->quarterly_payment;
            $quarterly_month = $total_month / 3;
            $monthly = ($total_month / 12) * 8;
            $date = Carbon::now();
            for ($i = 0; $quarterly_month > $i; $i++) {
                $a2[$i] = $quarterly_price;
            }
            foreach ($a2 as $data) {
                array_push($a1, [
                    'title' => 'quarterly',
                    'amount' => $data,
                    'due_date' => $date->addMonths(3)->format('Y-m-d'),
                    'created_at' => Carbon::now()->addMonths(3),
                ]);
            }
            for ($i = 0; $monthly > $i; $i++) {
                $a3[$i] = $payment_plan->per_month_installment;
            }
            $month_date = Carbon::now();
            foreach ($a3 as $key => $data) {
                array_push($a1, [
                    'title' => 'installment',
                    'amount' => $data,
                    'due_date' => $month_date->addMonth()->format('Y-m-d'),
                    'created_at' => Carbon::now()->addMonths($key),
                ]);
            }
        } else {
            for ($i = 0; $total_month > $i; $i++) {
                $a3[$i] = $payment_plan->per_month_installment;
            }
            $month_date = Carbon::now();
            foreach ($a3 as $key => $data) {
                array_push($a1, [
                    'title' => 'installment',
                    'amount' => $data,
                    'due_date' => $month_date->addMonth()->format('Y-m-d'),
                    'created_at' => Carbon::now()->addMonths($key),
                ]);
            }
        }

        $amount = $a1;
        $total_price = array_sum(array_column($a1, 'amount'));

        return $data = [
            'amount' => $amount,
            'total_price' => $total_price,
            'payment_plan' => $payment_plan,
        ];
    }
}
if (!function_exists('create_installment_plan')) {
    function create_installment_plan($client_id, $project_type_id, $inventory_id, $installment, $down_payment)
    {
        $installment_check = ClientInstallment::where('client_id', $client_id)->first();
        if ($installment_check == null) {

            if ($down_payment !== $installment['payment_plan']->total_price) {
                foreach ($installment['amount'] as $data) {
                    if (in_array($data['title'], ['down_payment', 'confirmation_amount'])) {
                        $status = 'paid';
                    } else {
                        $status = 'not_paid';
                    }
                    if (!$data['amount']) {
                        continue;
                    }
                    ClientInstallment::create([
                        'client_id' => $client_id,
                        'project_type_id' => $project_type_id,
                        'inventory_id' => $inventory_id,
                        'title' => $data['title'],
                        'installment_amount' => $data['amount'],
                        'due_date' => $data['due_date'],
                        'type' => 'installment',
                        'status' => $status,
                        'created_at' => $data['created_at']
                    ]);
                }
                return true;
            } else {
                foreach ($installment['amount'] as $data) {
                    ClientInstallment::create([
                        'client_id' => $client_id,
                        'title' => $data['title'],
                        'installment_amount' => $data['amount'],
                        'due_date' => $data['due_date'],
                        'type' => 'rent',
                        'status' => 'not_paid',
                        'created_ad' => $data['created_at']
                    ]);
                }
            }
        } else {
            return redirect()->back()->with(['message' => 'Client is already use in installment!', 'alert' => 'warning']);
        }
    }
}

if (!function_exists('check_target_assign')) {
    function check_target_assign($assign_to)
    {
        switch ($assign_to) {
            case 'all_property_manager':
                $role = 'property_manager';
                break;
            case 'all_sale_manager':
                $role = 'sale_manager';
                break;
            case 'all_sales_person':
                $role = 'sale_person';
                break;
            default:
                $role = '';
        }
        $arr = ['all_property_manager', 'all_sale_manager', 'all_sales_person'];
        if ($assign_to == 'self') {
            $assign_to_list = [Auth::user()->id];
        } elseif (in_array($assign_to, $arr)) {
            $users = get_user_by_projects();
            $assign_to_list = User::whereIn('id', $users)->with('roles')
                ->whereHas('roles', function ($q) use ($role) {
                    $q->Where('name', $role);
                })->pluck('id')->toArray();
        } elseif (is_numeric($assign_to)) {
            $assign_to_list = [$assign_to];
        } else {
            return redirect()->back()->with($this->message('Something went wrong,Try again.', 'error'));
        }
        return $assign_to_list;
    }
}
if (!function_exists('task_count_increment')) {
    function task_count_increment($type)
    {
        $date = Carbon::now()->format('Y-m-d');
        $target = Target::where('assign_to', Auth::user()->id)->where('type', $type)->where('from', '<=', $date)->where('to', '>=', $date)->first();
        if ($target) {
            $achieved = $target->achieved + 1;
            if ($achieved >= $target->target) {
                $target->status = 'success';
            }
            $target->achieved = $achieved;
            $target->save();
        }
        return true;
    }
}

////////////Acountss Helper Dunctions//////////////


// function html_escape($var, $double_encode = TRUE)
// {
// 	if (empty($var))
// 	{
// 		return $var;
// 	}

// 	if (is_array($var))
// 	{
// 		foreach (array_keys($var) as $key)
// 		{
// 			$var[$key] = html_escape($var[$key], $double_encode);
// 		}

// 		return $var;
// 	}

// 	return htmlspecialchars($var, ENT_QUOTES, config_item('charset'), $double_encode);
// }
if (!function_exists('display')) {
    function display($text = null)
    {
        // $ci = &get_instance();
        // $ci->load->database();
        // $ci->load->library('session');
        $table  = 'language';
        $phrase = 'phrase';
        $setting_table = 'setting';
        $default_lang  = 'english';

        //set language  
        // $data = DB::get($setting_table)->row();
        // if ($ci->session->has_userdata('language')) {
        //     $language = $ci->session->userdata('language');
        // } elseif (!empty($data->language)) {
        //     $language = $data->language;
        // } else {
        $language = $default_lang;
        // }

        if (!empty($text)) {

            // if ($ci->db->table_exists($table)) {

            //     if ($ci->db->field_exists($phrase, $table)) {

            //         if ($ci->db->field_exists($language, $table)) {

            $row = DB::table('language')->select($language)
                // ->from($table)
                ->where($phrase, $text)
                ->first();
            // ->row();

            if (!empty($row->$language)) {
                return htmlspecialchars($row->$language);
            } else {
                return false;
            }
            //     } else {
            //         return false;
            //     }
            // } else {
            //     return false;
            // }
            // } else {
            //     return false;
            // }
        } else {
            return false;
        }
    }
}
if (!function_exists('set_value')) {
    function set_value($field, $default = '', $html_escape = TRUE)
    {
        // $CI =& get_instance();

        // $value = (isset($CI->form_validation) && is_object($CI->form_validation) && $CI->form_validation->has_rule($field))
        // 	? $CI->form_validation->set_value($field, $default)
        // 	: $CI->input->post($field, FALSE);

        isset($value) or $value = $default;
        return ($html_escape) ? htmlspecialchars($value) : $value;
    }
}
if (!function_exists('allpheadtable')) {
    function allpheadtable($headlist)
    {

        foreach ($headlist as $menu) {
            echo '<tr><td>' . $menu->HeadCode . '</td><td>' . $menu->HeadName . '</td><td>' . $menu->PHeadName . '</td><td>' . $menu->HeadType . '</td><td>&nbsp;</td></tr>';
            if (!empty($menu->sub)) {
                all_subpheadtable($menu->sub);
            }
        }
    }
}
if (!function_exists('all_subpheadtable')) {
    function all_subpheadtable($sub_menu)
    {

        foreach ($sub_menu as $menu) {
            $update = '';
            $remove = '';
            $alerttxt = "You Can not Remove this Head!!! Because the Head have some Child Head";
            // $ci = &get_instance();
            // if ($ci->permission->method('accounts', 'update')->access()) :
            $update = '<input name="url" type="hidden" id="url_' . $menu->HeadCode . '" value="' . url("accounts/accounts/updatecoa") . '" /><a onclick="editinfo(' . $menu->HeadCode . ')" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;';
            // endif;
            // if ($ci->permission->method('accounts', 'delete')->access()) :
            $exitid = DB::table('acc_coa')->select("*")->where('PHeadName', $menu->HeadName)->first();
            if (!empty($exitid)) {
                $remove = '<a  onclick="return confirm(\'' . $alerttxt . '\')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash" aria-hidden="true"></i></a>';
            } else {
                $remove = '<a href="' . url("accounts/deletehead/$menu->HeadCode") . '" onclick="return confirm(\'' . "are_you_sure" . '\')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash" aria-hidden="true"></i></a>';
            }
            // endif;


            echo '<tr><td>' . $menu->HeadCode . '</td><td>' . $menu->HeadName . '</td><td>' . $menu->PHeadName . '</td><td>' . $menu->HeadType . '</td><td>' . $update . $remove . '</td></tr>';
            if (!empty($menu->sub)) {
                all_subpheadtable($menu->sub);
            }
        }
    }
}

    ////////////Acountss Helper Dunctions//////////////
