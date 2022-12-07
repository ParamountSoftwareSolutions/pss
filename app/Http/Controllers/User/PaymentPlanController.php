<?php

namespace App\Http\Controllers\User;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\PaymentPlan;
use App\Models\Premium;
use App\Models\ProjectType;
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
            'booking_price' => 'required',
            'per_month_installment' => 'required',
            'balloting_price' => 'required',
            'possession_price' => 'required',
            'total_month_installment' => 'required',
        ]);
        $payment_plan = new PaymentPlan();
        $payment_plan->project_type_id = $request->project_type_id;
        $payment_plan->name = $request->name;
        $payment_plan->total_month_installment = $request->total_month_installment;
        $payment_plan->total_price = $request->total_price;
        $payment_plan->booking_price = $request->booking_price;
        $payment_plan->per_month_installment = $request->per_month_installment;
        $payment_plan->half_year_installment = $request->half_year_installment;
        $payment_plan->quarterly_payment = $request->quarterly_payment;
        $payment_plan->balloting_price = $request->balloting_price;
        $payment_plan->possession_price = $request->possession_price;
        $payment_plan->rent_price = $request->rent_price;
        $payment_plan->number_of_payment = $request->number_of_payment;
        $payment_plan->confirmation_amount = $request->confirmation_amount;
        if(isset($request->premium_id)){
            $payment_plan->premium_id = $request->premium_id;
            $payment_plan->commission = $request->commission;
        }
        $payment_plan->save();
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
        return view('user.payment_plan.edit', compact('payment_plan','project_type'));
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
            'booking_price' => 'required',
            'per_month_installment' => 'required',
            'balloting_price' => 'required',
            'possession_price' => 'required',
            'total_month_installment' => 'required',
        ]);
        $payment_plan = PaymentPlan::findOrFail($id);
        $payment_plan->project_type_id = $request->project_type_id;
        $payment_plan->name = $request->name;
        $payment_plan->total_month_installment = $request->total_month_installment;
        $payment_plan->total_price = $request->total_price;
        $payment_plan->booking_price = $request->booking_price;
        $payment_plan->per_month_installment = $request->per_month_installment;
        $payment_plan->half_year_installment = $request->half_year_installment;
        $payment_plan->quarterly_payment = $request->quarterly_payment;
        $payment_plan->balloting_price = $request->balloting_price;
        $payment_plan->possession_price = $request->possession_price;
        $payment_plan->rent_price = $request->rent_price;
        $payment_plan->number_of_payment = $request->number_of_payment;
        $payment_plan->confirmation_amount = $request->confirmation_amount;
        if(isset($request->premium_id)){
            $payment_plan->premium_id = $request->premium_id;
            $payment_plan->commission = $request->commission;
        }
        $payment_plan->save();
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
        $payment_plan = PaymentPlan::where(['project_type_id'=>$project_type_id,'premium_id'=>$premium_id])->get();
        return response()->json($payment_plan);
    }
}
