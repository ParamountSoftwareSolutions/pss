<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BuildingInventory;
use App\Models\Farmhouse;
use App\Models\PaymentPlan;
use App\Models\Premium;
use App\Models\ProjectType;
use App\Models\Property;
use App\Models\SocietyInventory;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $abc = installment(2);
        dd($abc);
        $payment_plan = PaymentPlan::get();
        return view('user.payment_plan.index', compact('payment_plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $project_type = ProjectType::get();
        return view('user.payment_plan.create',compact('project_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_type_id' => 'required',
            'name' => 'required',
            'total_price' => 'required',
            'premium_id' => 'required',
            'payment_method' => 'required',
        ]);
        if($request->premium_id !== "regular"){
            $request->validate([
                'commission' => 'required',
                'after_commission_price' => 'required',
            ]);
            $premium = [
                'premium_id'=>$request->premium_id,
                'commission'=>$request->commission,
                'after_commission_price'=>$request->after_commission_price,
            ];
        }else{
            $premium = [
                'premium_id'=>null,
                'commission'=>null,
                'after_commission_price'=>null,
            ];
        }
        if($request->payment_method === 'installment'){
            $request->validate([
                'installment_plan' => 'required',
            ]);
            $monthly_arr = ['monthly','monthly_bi','monthly_qa'];
            $half_year_arr = ['bi_anually','monthly_bi','bi_qa'];
            $quarter_arr = ['quartrly','monthly_qa','bi_qa'];

            if(in_array($request->installment_plan,$monthly_arr)){
                $request->validate([
                    'no_of_month' => 'required',
                    'monthly_installment' => 'required',
                ]);
            }elseif (in_array($request->installment_plan,$half_year_arr)){
                $request->validate([
                    'no_of_half' => 'required',
                    'half_year_installment' => 'required',
                ]);
            }elseif (in_array($request->installment_plan,$quarter_arr)){
                $request->validate([
                    'no_of_quarter' => 'required',
                    'quarterly_installment' => 'required',
                ]);
            }else{
                $request->validate([
                    'rent_price' => 'required',
                    'rent_installment' => 'required',
                ]);
            }
            $plan = [
                'project_type_id'=> $request->project_type_id,
                'name'=> $request->name,
                'total_price'=> $request->total_price,
                'down_payment'=> $request->down_payment,
                'down_payment_percent'=> $request->down_payment_percent,
                'confirmation_amount'=> $request->confirmation_amount,
                'balloting_price'=> $request->balloting_price,
                'possession_price'=> $request->possession_price,
                'installment_plan'=> $request->installment_plan,
                'no_of_month'=> $request->no_of_month,
                'monthly_installment'=> $request->monthly_installment,
                'no_of_half'=> $request->no_of_half,
                'half_year_installment'=> $request->half_year_installment,
                'no_of_quarter'=> $request->no_of_quarter,
                'quarterly_installment'=> $request->quarterly_installment,
                'discount'=> $request->discount,
                'rent_price'=> $request->rent_price,
                'rent_installment'=> $request->rent_installment,
                'payment_method'=> $request->payment_method,
            ];
        }else{
            $request->validate([
                'baloon' => 'required',
            ]);
            $data = [];
            foreach($request->baloon as $key => $baloon){
                $data[$key] = ['date'=>$baloon['date'],'amount'=>$baloon['amount']];
            }
            $data = json_encode($data);
            $plan = [
                'project_type_id'=> $request->project_type_id,
                'name'=> $request->name,
                'total_price'=> $request->total_price,
                'baloon'=>$data,
                'payment_method'=> $request->payment_method,
            ];
        }
        $plan = $plan + $premium;
        $payment_plan = PaymentPlan::create($plan);
        if($payment_plan){
            return redirect()->route('payment_plan.index',RolePrefix())->with(['alert' => 'success', 'message' =>  'Payment Plan has created successfully']);
        } else{
            return redirect()->back()->with(['alert' => 'error', 'message' =>  'Payment Plan has not created, something went wrong. Try again']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $project_type = ProjectType::get();
        $payment_plan = PaymentPlan::findOrFail($id);
        return view('user.payment_plan.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'project_type_id' => 'required',
            'name' => 'required',
            'total_price' => 'required',
            'premium_id' => 'required',
            'payment_method' => 'required',
        ]);
        if($request->premium_id !== "regular"){
            $request->validate([
                'commission' => 'required',
                'after_commission_price' => 'required',
            ]);
            $premium = [
                'premium_id'=>$request->premium_id,
                'commission'=>$request->commission,
                'after_commission_price'=>$request->after_commission_price,
            ];
        }else{
            $premium = [
                'premium_id'=>null,
                'commission'=>null,
                'after_commission_price'=>null,
            ];
        }
        if($request->payment_method === 'installment'){
            $request->validate([
                'installment_plan' => 'required',
            ]);
            $monthly_arr = ['monthly','monthly_bi','monthly_qa'];
            $half_year_arr = ['bi_anually','monthly_bi','bi_qa'];
            $quarter_arr = ['quartrly','monthly_qa','bi_qa'];

            if(in_array($request->installment_plan,$monthly_arr)){
                $request->validate([
                    'no_of_month' => 'required',
                    'monthly_installment' => 'required',
                ]);
            }elseif (in_array($request->installment_plan,$half_year_arr)){
                $request->validate([
                    'no_of_half' => 'required',
                    'half_year_installment' => 'required',
                ]);
            }elseif (in_array($request->installment_plan,$quarter_arr)){
                $request->validate([
                    'no_of_quarter' => 'required',
                    'quarterly_installment' => 'required',
                ]);
            }else{
                $request->validate([
                    'rent_price' => 'required',
                    'rent_installment' => 'required',
                ]);
            }
            $plan = [
                'project_type_id'=> $request->project_type_id,
                'name'=> $request->name,
                'total_price'=> $request->total_price,
                'down_payment'=> $request->down_payment,
                'down_payment_percent'=> $request->down_payment_percent,
                'confirmation_amount'=> $request->confirmation_amount,
                'balloting_price'=> $request->balloting_price,
                'possession_price'=> $request->possession_price,
                'installment_plan'=> $request->installment_plan,
                'no_of_month'=> $request->no_of_month,
                'monthly_installment'=> $request->monthly_installment,
                'no_of_half'=> $request->no_of_half,
                'half_year_installment'=> $request->half_year_installment,
                'no_of_quarter'=> $request->no_of_quarter,
                'quarterly_installment'=> $request->quarterly_installment,
                'discount'=> $request->discount,
                'rent_price'=> $request->rent_price,
                'rent_installment'=> $request->rent_installment,
                'payment_method'=> $request->payment_method,
            ];
        }else{
            $request->validate([
                'baloon' => 'required',
            ]);
            $data = [];
            foreach($request->baloon as $key => $baloon){
                $data[$key] = ['date'=>$baloon['date'],'amount'=>$baloon['amount']];
            }
            $data = json_encode($data);
            $plan = [
                'project_type_id'=> $request->project_type_id,
                'name'=> $request->name,
                'total_price'=> $request->total_price,
                'baloon'=>$data,
                'payment_method'=> $request->payment_method,
            ];
        }
        $plan = $plan + $premium;
        $payment_plan = PaymentPlan::find($id)->update($plan);
        if($payment_plan){
            return redirect()->route('payment_plan.index',RolePrefix())->with(['alert' => 'success', 'message' =>  'Payment Plan updated successfully']);
        } else{
            return redirect()->back()->with(['alert' => 'error', 'message' =>  'Payment Plan has not updated, something went wrong. Try again']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $payment_plan = PaymentPlan::findOrFail($id);
        $payment_plan->delete();
        if($payment_plan){
            return response()->json(['message'=>'Payment Plan has deleted successfully','status'=> 'success']);
        } else {
            return response()->json(['message'=>'Payment Plan has not deleted, something went wrong. Try again','status'=> 'error']);
        }
    }
    public function get_payment_plan($premium_id,$project_type_id)
    {
        if($premium_id !== 'regular'){
            $payment_plan = PaymentPlan::where(['project_type_id'=>$project_type_id,'premium_id'=>$premium_id])->get();
        }else{
            $payment_plan = PaymentPlan::where('project_type_id',$project_type_id)->where('premium_id',null)->get();
        }
        return response()->json($payment_plan);
    }
}
