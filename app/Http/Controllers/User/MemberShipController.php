<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RolePrefix;
use App\Models\Building;
use App\Models\BuildingFile;
use App\Models\BuildingForm;
use App\Models\Client;
use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;
use Illuminate\Support\Facades\Auth;

class MemberShipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $membership = Form::with('client')->where('type', 'membership')->get();
        return view('user.membership.index', compact('membership'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $clients = Client::get();
        $projects = get_all_projects();
        return view('user.membership.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'fee' => 'required',
        ]);
        $form = new Form();
        $form->client_id = $request->client_id;
        $form->project_id = $request->project_id;
        $form->application_no = $request->application_no;
        $form->fee = $request->fee;
        $form->passport_no = $request->passport_no;
        $form->current_address = $request->current_address;
        $form->permanent_address = $request->permanent_address;
        $form->occupation = $request->occupation;
        $form->phone_no_office = $request->phone_no_office;
        $form->phone_no_res = $request->phone_no_res;
        $form->nominee_name = $request->nominee_name;
        $form->nominee_father_name = $request->nominee_father_name;
        $form->nominee_cnic = $request->nominee_cnic;
        $form->nominee_passport_no = $request->nominee_passport_no;
        $form->relationship = $request->relationship;
        $form->property_type = $request->property_type;
        $form->total_price = $request->total_price;
        $form->booking_price = $request->booking_price;
        $form->down_payment = $request->down_payment;
        $form->installment = $request->installment;
        $form->payment_type = $request->payment_type;
        $form->cash_receipt = $request->cash_receipt;
        $form->type = 'membership';
        if ($request->has('project_logo')) {
            foreach ($request->file('project_logo') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/form/', $filename);
                $file = 'images/form/' . $filename;
                $form->project_logo = $file;
            }
        }
        $form->save();
        $form->barcode = route('membership.verify',[RolePrefix(),$form->id]);
        $form->save();
        if ($form) {
            return redirect()->route('membership.index',RolePrefix())->with($this->message('Membership form has been created successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Membership Form create Error", 'error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $form = Form::with('client')->findOrFail($id);
        return view('user.membership.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $form = Form::findOrFail($id);
        $clients = Client::get();
        $projects = get_all_projects();
        return view('user.membership.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'project_id' => 'required',
            'fee' => 'required',
        ]);
        $form = Form::findOrFail($id);
        $form->client_id = $request->client_id;
        $form->project_id = $request->project_id;
        $form->application_no = $request->application_no;
        $form->fee = $request->fee;
        $form->passport_no = $request->passport_no;
        $form->current_address = $request->current_address;
        $form->permanent_address = $request->permanent_address;
        $form->occupation = $request->occupation;
        $form->phone_no_office = $request->phone_no_office;
        $form->phone_no_res = $request->phone_no_res;
        $form->nominee_name = $request->nominee_name;
        $form->nominee_father_name = $request->nominee_father_name;
        $form->nominee_cnic = $request->nominee_cnic;
        $form->nominee_passport_no = $request->nominee_passport_no;
        $form->relationship = $request->relationship;
        $form->property_type = $request->property_type;
        $form->total_price = $request->total_price;
        $form->booking_price = $request->booking_price;
        $form->down_payment = $request->down_payment;
        $form->installment = $request->installment;
        $form->payment_type = $request->payment_type;
        $form->cash_receipt = $request->cash_receipt;
        $form->type = 'membership';
        if ($request->has('project_logo')) {
            foreach ($request->file('project_logo') as $file) {
                $filename = hexdec(uniqid()) . '.' . strtolower($file->getClientOriginalExtension());
                $file->move('public/images/form/', $filename);
                $file = 'images/form/' . $filename;
                $form->project_logo = $file;
            }
        }
        $form->save();
        if ($form) {
            return redirect()->route('membership.index',RolePrefix())->with($this->message('Membership form has been updated successfully', 'success'));
        } else {
            return redirect()->back()->with($this->message("Membership Form update Error", 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();
        if ($form) {
            return response()->json(['message'=>'Membership form has been delete successfully','status'=>'success']);
        } else {
            return response()->json(['message'=>"Membership Form delete Error", 'status'=>'error']);
        }
    }

    public function printForm($id)
    {
        $form = Form::with('client')->findOrFail($id);
        return view('user.membership.form_print', get_defined_vars());
    }

    public function verify($id)
    {
        $status = 'error';
        $msg = 'Not Verified';
        $form = Form::findOrFail($id);
        if($form){
            $status = 'success';
            $msg = 'Verified';
        }
        return view('user.membership.verify', get_defined_vars());
    }
}
