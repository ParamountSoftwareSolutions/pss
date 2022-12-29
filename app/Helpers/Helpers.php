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
    function create_installment_plan($client_id, $installment, $down_payment)
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
