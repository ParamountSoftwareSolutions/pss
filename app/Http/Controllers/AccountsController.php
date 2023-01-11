<?php

namespace App\Http\Controllers;

use App\Models\Accounts_model;
use CAccount;
use CResult;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Svg\Tag\Rect;

// use Symfony\Component\HttpFoundation\Request;
// defined('BASEPATH') or exit('No direct script access allowed');

class AccountsController extends Controller
{
    public function reg_form_submit(Request $request)
    {
        $response = RegistrationModel::create($request->except(['_token']));
        if ($response) {
            return redirect()->back()->with(['alert' => 'success', 'message' => 'Regitration Form Has Been Submit Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error']);
        }
    }
    // public function __construct()
    // {
    //     parent::__construct();

    //     $this->load->model(array(
    //         'accounts_model'
    //     ));
    //     DB::table()->query('SET SESSION sql_mode = ""');
    // }

    public static  function C_O_A()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $data['title'] = display('act');
        $data['module'] = "accounts";
        $data['page']   = "coa";
        return view('user/accounts/coa', $data);
        // echo Modules::run('template/layout', $data);
    }


    // tree view controller
    public static  function show_tree($id = null)
    {
        $id      = ($id ? $id : 2);
        $data = array(
            'userList' => Accounts_model::get_userlist(),
            'userID' => set_value('userID'),
        );
        $data['coa_head'] = Accounts_model::get_coahead();
        $data['allheadname'] = Accounts_model::allphead_dropdown('COA');
        $data['title'] = display('act');
        $data['module'] = "accounts";
        $data['page']   = "treeview";
        return view('user/accounts/treeview', get_defined_vars());
    }

    public function selectphead(Request $request)
    {
        $phead = $request->phead;
        $coa_phead = Accounts_model::allphead_dropdown($phead);
        echo $allphead = $this->allphead($coa_phead);
    }

    function allphead($data)
    {
        // echo '<option value="" class="bolden" data-id="0"><strong>' . $menu->HeadName . '</strong></option>';
        echo '<option value="" class="bolden" data-id="0"><strong>Head</strong></option>';
        foreach ($data as $menu) {
            echo '<option value="' . $menu->HeadCode . '" class="bolden" data-id="' . $menu->HeadLevel . '" data-phead="' . $menu->HeadName . '"><strong>' . $menu->HeadName . '</strong></option>';
            if (!empty($menu->sub)) {
                $this->all_subphead($menu->sub);
            }
        }
    }

    function all_subphead($sub_menu)
    {
        foreach ($sub_menu as $menu) {
            echo '<option value="' . $menu->HeadCode . '" data-id="' . $menu->HeadLevel . '" data-phead="' . $menu->HeadName . '">&nbsp;&nbsp;&mdash;' . $menu->HeadName . '</option>';
            if (!empty($menu->sub)) {
                $this->all_subphead($menu->sub);
            }
        }
    }

    public function selectedform($id)
    {
        $role_reult = DB::table('acc_coa')->select('*')
            ->where('HeadCode', $id)
            ->first();
        $base_url_env = env('APP_URL');

        $baseurl = $base_url_env . '/accounts/insert_coa';


        if ($role_reult) {
            $html = "";
            $html .= "
        <form name=\"form\" id=\"form\" action=\"" . $baseurl . "\" method=\"post\" enctype=\"multipart/form-data\">
                <div id=\"newData\">
   <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
    
      <tr>
        <td>Head Code</td>
        <td><input type=\"text\" name=\"txtHeadCode\" id=\"txtHeadCode\" class=\"form_input\"  value=\"" . $role_reult->HeadCode . "\" readonly=\"readonly\"/></td>
      </tr>
      <tr>
        <td>Head Name</td>
        <td><input type=\"text\" name=\"txtHeadName\" id=\"txtHeadName\" class=\"form_input\" value=\"" . $role_reult->HeadName . "\"/>
<input type=\"hidden\" name=\"HeadName\" id=\"HeadName\" class=\"form_input\" value=\"" . $role_reult->HeadName . "\"/>
        </td>
      </tr>
      <tr>
        <td>Parent Head</td>
        <td><input type=\"text\" name=\"txtPHead\" id=\"txtPHead\" class=\"form_input\" readonly=\"readonly\" value=\"" . $role_reult->PHeadName . "\"/></td>
      </tr>
      <tr>

        <td>Head Level</td>
        <td><input type=\"text\" name=\"txtHeadLevel\" id=\"txtHeadLevel\" class=\"form_input\" readonly=\"readonly\" value=\"" . $role_reult->HeadLevel . "\"/></td>
      </tr>
       <tr>
        <td>Head Type</td>
        <td><input type=\"text\" name=\"txtHeadType\" id=\"txtHeadType\" class=\"form_input\" readonly=\"readonly\" value=\"" . $role_reult->HeadType . "\"/></td>
      </tr>

       <tr>
        <td>&nbsp;</td>
        <td><input type=\"checkbox\" name=\"IsTransaction\" value=\"1\" id=\"IsTransaction\" size=\"28\"  onchange=\"IsTransaction_change();\"";
            if ($role_reult->IsTransaction == 1) {
                $html .= "checked";
            }

            $html .= "/><label for=\"IsTransaction\"> Transaction</label>
        <input type=\"checkbox\" value=\"1\" name=\"IsActive\" id=\"IsActive\"";
            if ($role_reult->IsActive == 1) {
                $html .= "checked";
            }
            $html .= " size=\"28\" checked=\"\" /><label for=\"IsActive\"> Active</label>
        <input type=\"checkbox\" value=\"1\" name=\"IsGL\" id=\"IsGL\" size=\"28\"";
            if ($role_reult->IsGL == 1) {
                $html .= "checked";
            }
            $html .= " onchange=\"IsGL_change();\"/><label for=\"IsGL\"> GL</label>

        </td>
      </tr>
       <tr>
                    <td>&nbsp;</td>
                    <td>";
            // if ($this->permission->method('accounts', 'create')->access()) :
            $html .= "<input type=\"button\" name=\"btnNew\" id=\"btnNew\" value=\"New\" onClick=\"newdata(" . $role_reult->HeadCode . ")\" />
                     <input type=\"submit\" name=\"btnSave\" id=\"btnSave\" value=\"Save\" disabled=\"disabled\"/>";
            // endif;
            // if ($this->permission->method('accounts', 'update')->access()) :
            $html .= " <input type=\"submit\" name=\"btnUpdate\" id=\"btnUpdate\" value=\"Update\" />";
            // endif;
            $html .= " </td>
                  </tr>
      
    </table>
 </form>
			";
        }
        echo json_encode($html);
    }

    public function newform($id)
    {

        $newdata =  DB::table('acc_coa')->select('*')
            ->where('HeadCode', $id)
            ->first();


        $newidsinfo =  DB::table('acc_coa')->select('*,count(HeadCode) as hc')
            ->where('PHeadName', $newdata->HeadName)
            ->first();

        $nid  = $newidsinfo->hc;
        $n = $nid + 1;
        if ($n / 10 < 1)
            $HeadCode = $id . "0" . $n;
        else
            $HeadCode = $id . $n;

        $info['headcode'] =  $HeadCode;
        $info['rowdata'] =  $newdata;
        $info['headlabel'] =  $newdata->HeadLevel + 1;
        echo json_encode($info);
    }

    public function insert_coa(Request $request)
    {
        $headcode = $request->txtHeadCode;
        $HeadName = $request->txtHeadName;
        $PHeadName = $request->txtPHead;
        $HeadLevel = $request->txtHeadLevel;
        $txtHeadType = $request->txtHeadType;
        $isact = $request->IsActive;
        $IsActive = (!empty($isact) ? $isact : 0);
        $trns = $request->IsTransaction;
        $IsTransaction = (!empty($trns) ? $trns : 0);
        $isgl = $request->IsGL;
        $IsGL = (!empty($isgl) ? $isgl : 0);
        $createby = Auth::id();

        $createdate = date('Y-m-d H:i:s');
        $postData = array(
            'HeadCode'       =>  $headcode,
            'HeadName'       =>  $HeadName,
            'PHeadName'      =>  $PHeadName,
            'HeadLevel'      =>  $HeadLevel,
            'IsActive'       =>  $IsActive,
            'IsTransaction'  =>  $IsTransaction,
            'IsGL'           =>  $IsGL,
            'HeadType'       => $txtHeadType,
            'IsBudget'       => 0,
            'CreateBy'       => $createby,
            'CreateDate'     => $createdate,
        );
        $upinfo = DB::table()->select('*')
            ->from('acc_coa')
            ->where('HeadCode', $headcode)
            ->get()
            ->row();
        if (empty($upinfo)) {
            DB::table('acc_coa')->insert($postData);
        } else {

            $hname = $request->HeadName;
            $updata = array(
                'PHeadName'      =>  $HeadName,
            );


            DB::table('acc_coa')->where('HeadCode', $headcode)
                ->update($postData);
            DB::table('acc_coa')->where('PHeadName', $hname)
                ->update($updata);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert_coa2(Request $request)
    {

        $id = $request->headcode;
        $HeadName = $request->headname;
        $coahead = $request->coahead;
        $PHeadName = $request->pheadcode;
        $newhead = (!empty($PHeadName) ? $PHeadName : $coahead);
        $HeadLevel = $request->headlebel;
        $txtHeadType = $request->headtype;
        $newidsinfo = DB::table('acc_coa')->select('*', DB::raw('count(HeadCode) as hc'))->where('PHeadName', $PHeadName)->first();


        $nid  = $newidsinfo->hc;
        $n = $nid + 1;
        if ($n / 10 < 1) {
            $HeadCode = $id . "0" . $n;
        } else {
            $HeadCode = $id . $n;
        }
        $isact = $request->IsActive;
        $IsActive = (!empty($isact) ? $isact : 0);
        $trns = $request->IsTransaction;
        $IsTransaction = (!empty($trns) ? $trns : 0);
        $isgl = $request->IsGL;
        $IsGL = (!empty($isgl) ? $isgl : 0);
        // $createby = $this->session->userdata('id');
        $createby = Auth::id();


        $createdate = date('Y-m-d H:i:s');
        $postData = array(
            'HeadCode'       =>  $HeadCode,
            'HeadName'       =>  $HeadName,
            'PHeadName'      =>  $PHeadName,
            'HeadLevel'      =>  $HeadLevel,
            'IsActive'       =>  $IsActive,
            'IsTransaction'  =>  $IsTransaction,
            'IsGL'           =>  $IsGL,
            'HeadType'       => $txtHeadType,
            'IsBudget'       => 0,
            'CreateBy'       => $createby,
            'CreateDate'     => $createdate,
        );

        $lastid = DB::table('acc_coa')->insertGetId($postData);

        //echo DB::table()->last_query();
        // $lastid = DB::table()->insert_id();
        if ($lastid == "0") {
            return redirect()->route('accounts.show_tree')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
    }
    public function updatecoa($id)
    {

        // $this->permission->method('accounts', 'update')->redirect();
        $data['title'] = display('update');
        $data['intinfo']   = Accounts_model::findById($id);
        $data['module'] = "accounts";
        $data['page']   = "coaedit";
        $this->load->view('user/accounts/coaedit', $data);
    }
    public function updatecoahead(Request $request)
    {
        $this->permission->method('accounts', 'update')->redirect();
        $Headcode = $request->HeadCode;
        $HeadName = $request->headname;

        if (!empty($request->IsTransaction)) {
            $IsTransaction = 1;
        } else {
            $IsTransaction = 0;
        }
        if (!empty($request->IsActive)) {
            $IsActive = 1;
        } else {
            $IsActive = 0;
        }
        if (!empty($request->IsGL)) {
            $IsGL = 1;
        } else {
            $IsGL = 0;
        }
        $postData = array(
            'HeadCode'                         => $request->HeadCode,
            'HeadName'                         => $request->headname,
            'IsTransaction'                    => $IsTransaction,
            'IsActive'                         => $IsActive,
            'IsGL'                             => $IsGL,
        );
        if (Accounts_model::updarecoahead($postData)) {
            $this->session->set_flashdata('message', display('update_successfully'));
            redirect("accounts/accounts/show_tree");
        } else {
            $this->session->set_flashdata('exception',  display('please_try_again'));
            redirect("accounts/accounts/show_tree");
        }
    }
    public function deletehead($id)
    {

        if (Accounts_model::head_delete($id)) {
            return redirect()->route('accounts.show_tree')->with(['alert' => 'success', 'message' => 'Delete Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // if (Accounts_model::head_delete($id)) {
        //     $this->session->set_flashdata('message', display('delete_successfully'));
        // } else {
        //     $this->session->set_flashdata('exception', display('please_try_again'));
        // }
        // redirect($_SERVER['HTTP_REFERER']);
    }

    // Debit voucher Create 
    public function debit_voucher()
    {
        $data['title'] = display('debit_voucher');
        $data['acc'] = Accounts_model::Transacc();
        $data['voucher_no'] = Accounts_model::voNO();
        $data['crcc'] = Accounts_model::Cracc();
        $data['module'] = "accounts";
        $data['page']   = "debit_voucher";
        return view('user/accounts/debit_voucher', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }

    // Debit voucher code select onchange
    public function debtvouchercode($id)
    {
        $debitvcode = DB::table('acc_coa')->select('*')
            ->where('HeadCode', $id)
            ->first();

        $code = $debitvcode->HeadCode;
        echo json_encode($code);
    }
    //Create Debit Voucher
    public function create_debit_voucher(Request $request)
    {
        $voucher_no = addslashes(trim($_POST['txtVNo']));
        $Vtype = "DV";
        $cAID = $_POST['cmbDebit'];
        $dAID = $_POST['txtCode'];
        $Debit = $_POST['txtAmount'];
        $remark = $_POST['remark'];
        $Credit = $_POST['grand_total'];
        $VDate = $_POST['dtpDate'];
        $Narration = addslashes(trim($_POST['txtRemarks']));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');

        $cinsert = array(
            'VNo'            =>  $voucher_no,
            'Vtype'          =>  $Vtype,
            'VDate'          =>  $VDate,
            'COAID'          =>  $cAID,
            'Narration'      =>  $Narration,
            'Debit'          =>  0,
            'Credit'         =>  $Credit,
            'StoreID'        => 0,
            'IsPosted'       => $IsPosted,
            'CreateBy'       => $CreateBy,
            'CreateDate'     => $createdate,
            'IsAppove'       => 0
        );
        // Accounts_model::insert_debitvoucher()
        DB::table('acc_transaction')->insert($cinsert);
        for ($i = 0; $i < count($dAID); $i++) {
            $dbtid = $dAID[$i];
            $Damnt = $Debit[$i];
            $remarkt = $remark[$i];

            $debitinsert = array(
                'VNo'            =>  $voucher_no,
                'Vtype'          =>  $Vtype,
                'VDate'          =>  $VDate,
                'COAID'          =>  $dbtid,
                'Narration'      =>  $remarkt,
                'Debit'          =>  $Damnt,
                'Credit'         =>  0,
                'StoreID'        => 0,
                'IsPosted'       => $IsPosted,
                'CreateBy'       => $CreateBy,
                'CreateDate'     => $createdate,
                'IsAppove'       => 0
            );

            $response =  DB::table('acc_transaction')->insert($debitinsert);
        }
        if ($response) {
            return redirect()->route('accounts.debit_voucher')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // $this->form_validation->set_rules('cmbDebit', display('cmbDebit'), 'max_length[100]');
        // if ($this->form_validation->run()) {
        //     if (Accounts_model::insert_debitvoucher()) {
        //         $this->session->set_flashdata('message', display('save_successfully'));
        //         redirect('accounts/accounts/debit_voucher/');
        //     } else {
        //         $this->session->set_flashdata('exception',  display('please_try_again'));
        //     }
        //     redirect("accounts/accounts/debit_voucher");
        // } else {
        //     $this->session->set_flashdata('exception',  display('please_try_again'));
        //     redirect("accounts/accounts/debit_voucher");
        // }
    }

    // Update Debit voucher 
    public function update_debit_voucher(Request $request)
    {
        $voucher_no = $_POST['txtVNo'];
        $Vtype = "DV";
        $cAID = $_POST['cmbDebit'];
        $dAID = $_POST['txtCode'];
        $Debit = $_POST['txtAmount'];
        $Credit = $_POST['grand_total'];
        $VDate = $_POST['dtpDate'];
        $Narration = addslashes(trim($_POST['txtRemarks']));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');

        $cinsert = array(
            'VNo'            =>  $voucher_no,
            'Vtype'          =>  $Vtype,
            'VDate'          =>  $VDate,
            'COAID'          =>  $cAID,
            'Narration'      =>  $Narration,
            'Debit'          =>  0,
            'Credit'         =>  $Credit,
            'StoreID'        => 0,
            'IsPosted'       => $IsPosted,
            'CreateBy'       => $CreateBy,
            'CreateDate'     => $createdate,
            'IsAppove'       => 0
        );
        DB::table('acc_transaction')->where('VNo', $voucher_no)
            ->delete();

        DB::table('acc_transaction')->insert($cinsert);
        for ($i = 0; $i < count($dAID); $i++) {
            $dbtid = $dAID[$i];
            $Damnt = $Debit[$i];

            $debitinsert = array(
                'VNo'            =>  $voucher_no,
                'Vtype'          =>  $Vtype,
                'VDate'          =>  $VDate,
                'COAID'          =>  $dbtid,
                'Narration'      =>  $Narration,
                'Debit'          =>  $Damnt,
                'Credit'         =>  0,
                'StoreID'        => 0,
                'IsPosted'       => $IsPosted,
                'CreateBy'       => $CreateBy,
                'CreateDate'     => $createdate,
                'IsAppove'       => 0
            );

            $response =  DB::table('acc_transaction')->insert($debitinsert);
        }
        if ($response) {
            return redirect()->route('accounts.aprove_v')->with(['alert' => 'success', 'message' => 'Update Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // }
        // $this->permission->method('accounts', 'update')->redirect();
        // $this->form_validation->set_rules('cmbDebit', display('cmbDebit'), 'max_length[100]');
        // if ($this->form_validation->run()) {
        // if (Accounts_model::update_debitvoucher()) {
        //         $this->session->set_flashdata('message', display('update_successfully'));
        //         redirect('accounts/accounts/aprove_v/');
        //     } else {
        //         $this->session->set_flashdata('exception',  display('please_try_again'));
        //     }
        //     redirect("accounts/accounts/aprove_v");
        // } else {
        //     $this->session->set_flashdata('exception',  display('please_try_again'));
        //     redirect("accounts/accounts/aprove_v");
        // }
    }

    //Credit voucher 
    public function credit_voucher()
    {
        // $this->permission->method('accounts', 'create')->redirect();
        $data['title'] = display('credit_voucher');
        $data['acc'] = Accounts_model::Transacc();
        $data['voucher_no'] = Accounts_model::crVno();
        $data['crcc'] = Accounts_model::Cracc();
        $data['module'] = "accounts";
        $data['page']   = "credit_voucher";
        return view('user/accounts/credit_voucher', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }

    //Create Credit Voucher
    public function create_credit_voucher()
    {
        if (Accounts_model::insert_creditvoucher()) {
            return redirect()->route('accounts.credit_voucher')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // $this->permission->method('accounts', 'create')->redirect();
        // $this->form_validation->set_rules('cmbDebit', display('cmbDebit'), 'max_length[100]');
        // if ($this->form_validation->run()) {
        //     if (Accounts_model::insert_creditvoucher()) {
        //         $this->session->set_flashdata('message', display('save_successfully'));
        //         redirect('accounts/accounts/credit_voucher/');
        //     } else {
        //         $this->session->set_flashdata('exception',  display('please_try_again'));
        //     }
        //     redirect("accounts/accounts/credit_voucher");
        // } else {
        //     $this->session->set_flashdata('exception',  display('please_try_again'));
        //     redirect("accounts/accounts/credit_voucher");
        // }
    }
    // Contra Voucher form
    public function contra_voucher()
    {
        // $this->permission->method('accounts', 'create')->redirect();
        $data['title'] = display('contra_voucher');
        $data['acc'] = Accounts_model::Transacc();
        $data['voucher_no'] = Accounts_model::contra();
        $data['module'] = "accounts";
        $data['page']   = "contra_voucher";
        return view('user/accounts/contra_voucher', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }

    //Create Contra Voucher
    public function create_contra_voucher()
    {
        if (Accounts_model::insert_contravoucher()) {
            return redirect()->route('accounts.contra_voucher')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // $this->permission->method('accounts', 'create')->redirect();
        // $this->form_validation->set_rules('cmbDebit', display('cmbDebit'), 'max_length[100]');
        // if ($this->form_validation->run()) {
        //     if (Accounts_model::insert_contravoucher()) {
        //         $this->session->set_flashdata('message', display('save_successfully'));
        //         redirect('accounts/accounts/contra_voucher/');
        //     } else {
        //         $this->session->set_flashdata('exception',  display('please_try_again'));
        //     }
        //     redirect("accounts/accounts/contra_voucher");
        // } else {
        //     $this->session->set_flashdata('exception',  display('please_try_again'));
        //     redirect("accounts/accounts/contra_voucher");
        // }
    }
    // Journal voucher
    public function journal_voucher()
    {
        // $this->permission->method('accounts', 'create')->redirect();
        $data['title'] = display('journal_voucher');
        $data['acc'] = Accounts_model::Transacc();

        $data['voucher_no'] = Accounts_model::journal();
        $data['module'] = "accounts";
        $data['page']   = "journal_voucher";
        return view('user/accounts/journal_voucher', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }

    //Create Journal Voucher
    public function create_journal_voucher()
    {
        if (Accounts_model::insert_journalvoucher()) {
            return redirect()->route('accounts.journal_voucher')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // $this->permission->method('accounts', 'create')->redirect();
        // $this->form_validation->set_rules('cmbDebit', display('cmbDebit'), 'max_length[100]');
        // if ($this->form_validation->run()) {
        //     if (Accounts_model::insert_journalvoucher()) {
        //         $this->session->set_flashdata('message', display('save_successfully'));
        //         redirect('accounts/accounts/journal_voucher/');
        //     } else {
        //         $this->session->set_flashdata('exception',  display('please_try_again'));
        //     }
        //     redirect("accounts/accounts/journal_voucher");
        // } else {
        //     $this->session->set_flashdata('exception',  display('please_try_again'));
        //     redirect("accounts/accounts/journal_voucher");
        // }
    }
    //Aprove voucher
    public function aprove_v()
    {
        // $this->permission->method('accounts', 'create')->redirect();
        $data['title'] = display('voucher_approval');
        $data['aprrove'] = Accounts_model::approve_voucher();
        $data['aprroved'] = Accounts_model::approved_voucher();
        $data['module'] = "accounts";
        $data['page']   = "voucher_approve";
        return view('user/accounts/voucher_approve', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    // isApprove
    public function isactive($id = null, $action = null)
    {
        $action = 1;
        $postData = array(
            'VNo'     => $id,
            'IsAppove' => $action
        );
        $response = DB::table('acc_transaction')->where('VNo', $postData['VNo'])->update($postData);
        if ($response) {
            return redirect()->route('accounts.aprove_v')->with(['alert' => 'success', 'message' => 'successfully_approved']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        //  $action = 1;
        //  $postData = array(
        //      'VNo'     => $id,
        //      'IsAppove' => $action
        //  );
        //  if (Accounts_model::approved($postData)) {
        //      return redirect()->route('accounts.aprove_v')->with(['alert' => 'success', 'message' => 'successfully_approved']);
        //  } else {
        //      return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        //  }

    }

    //Update voucher 
    public function voucher_update($id = null)
    {
        // $this->permission->method('accounts', 'Update')->redirect();
        $vtype = DB::table('acc_transaction')->select('*')
            ->where('VNo', $id)
            ->first();

        $data['crcc'] = Accounts_model::Cracc();
        $data['acc'] = Accounts_model::Transacc();

        if ($vtype->Vtype == "DV") {
            $data['title'] = display('update_debit_voucher');
            $data['dbvoucher_info'] = Accounts_model::dbvoucher_updata($id);
            $data['credit_info'] = Accounts_model::crvoucher_updata($id);
            $data['page']   = "update_dbt_crtvoucher";
        }
        if ($vtype->Vtype == "CV") {

            $data['title'] = display('update_credit_voucher');
            $data['crvoucher_info'] = Accounts_model::crdtvoucher_updata($id);
            $data['debit_info'] = Accounts_model::debitvoucher_updata($id);
            $data['page']   = "update_credit_bdtvoucher";
        }
        if ($vtype->Vtype == "Contra") {

            $data['title'] = display('update_contra_voucher');
            $data['crvoucher_info'] = Accounts_model::contravoucher_updata($id);
            $data['page']   = "update_contra_voucher";
        }
        if ($vtype->Vtype == "JV") {

            $data['title'] = display('update_contra_voucher');
            $data['journal_info'] = Accounts_model::journalCrebitVoucher_edit($id);
            $data['page']   = "update_journal_voucher";
        }
        $data['module'] = "accounts";

        return view('user/accounts/' . $data['page'], get_defined_vars());
    }
    // update credit voucher 
    public function update_credit_voucher()
    {
        if (Accounts_model::update_creditvoucher()) {
            return redirect()->route('accounts.aprove_v')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // $this->permission->method('accounts', 'update')->redirect();
        // $this->form_validation->set_rules('cmbDebit', display('cmbDebit'), 'max_length[100]');
        // if ($this->form_validation->run()) {
        //     if (Accounts_model::update_creditvoucher()) {
        //         $this->session->set_flashdata('message', display('save_successfully'));
        //         redirect('accounts/accounts/aprove_v/');
        //     } else {
        //         $this->session->set_flashdata('exception',  display('please_try_again'));
        //     }
        //     redirect("accounts/accounts/aprove_v");
        // } else {
        //     $this->session->set_flashdata('exception',  display('please_try_again'));
        //     redirect("accounts/accounts/aprove_v");
        // }
    }
    // Debit voucher code select onchange
    public function debit_voucher_code($id)
    {

        $debitvcode = DB::table('acc_coa')->select('*')
            ->where('HeadCode', $id)
            ->first();
        $code = $debitvcode->HeadCode;
        return json_encode($code);
    }
    // update_contra_voucher
    public function update_contra_voucher(Request $request)
    {
        $voucher_no = addslashes(trim($request->txtVNo));
        $Vtype = "Contra";
        // $dAID = $request->cmbDebit;
        $cAID = $request->txtCode;
        $debit = $request->txtAmount;
        $credit = $request->txtAmountcr;
        $VDate = $request->dtpDate;
        $Narration = addslashes(trim($request->txtRemarks));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');
        if ($voucher_no) {
            DB::table('acc_transaction')->where('VNo', $voucher_no)->delete();
        }
        for ($i = 0; $i < count($cAID); $i++) {
            $contrainsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $cAID[$i],
                'Narration' => $Narration,
                'Debit' => $debit[$i],
                'Credit' => $credit[$i],
                'StoreID' => 0,
                'IsPosted' => $IsPosted,
                'UpdateBy' => $CreateBy,
                'UpdateDate' => $createdate,
                'IsAppove' => 0
            );
            $data = DB::table('acc_transaction')->insert($contrainsert);
        }
        if ($data) {
            return redirect()->route('accounts.aprove_v')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
    }
    //    ============== its for update_journal_voucher ==============
    public function update_journal_voucher(Request $request)
    {

        $voucher_no = addslashes(trim($request->txtVNo));

        $Vtype = "JV";
        // $dAID = $request->cmbDebit;
        $cAID = $request->txtCode;
        $debit = $request->txtAmount;
        $credit = $request->txtAmountcr;
        $VDate = $request->dtpDate;
        $Narration = addslashes(trim($request->txtRemarks));

        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');
        if ($voucher_no) {
            DB::table('acc_transaction')->where('VNo', $voucher_no)->delete();
            // DB::table('acc_transaction')->delete();
        }

        for ($i = 0; $i < count($cAID); $i++) {

            $contrainsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $cAID[$i],
                'Narration' => $Narration,
                'Debit' => $debit[$i],
                'Credit' => $credit[$i],

                'IsPosted' => $IsPosted,
                'UpdateBy' => $CreateBy,
                'UpdateDate' => $createdate,
                'IsAppove' => 0
            );

            $data = DB::table('acc_transaction')->insert($contrainsert);
        }
        if ($data) {
            return redirect()->route('accounts.aprove_v')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // $this->session->set_flashdata('message', display('save_successfully'));
        // redirect("accounts/accounts/aprove_v");
    }
    //Trial Balannce
    public function trial_balance()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $data['title']  = display('trial_balance');
        $data['module'] = "accounts";
        $data['page']   = "trial_balance";
        return view('user/accounts/trial_balance', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //Trial Balance Report
    public function trial_balance_report(Request $request)
    {
        $dtpFromDate     = $request->dtpFromDate;
        $dtpToDate       = $request->dtpToDate;
        $chkWithOpening  = $request->chkWithOpening;

        $results = Accounts_model::trial_balance_report($dtpFromDate, $dtpToDate, $chkWithOpening);

        // if ($results['WithOpening']) {
        //     $data['oResultTr']    = $results['oResultTr'];
        //     $data['oResultInEx']  = $results['oResultInEx'];
        //     $data['dtpFromDate']  = $dtpFromDate;
        //     $data['dtpToDate']    = $dtpToDate;

        //     // PDF Generator 
        //     $dompdf = new Dompdf();

        //     $page = $this->load->view('user/accounts/trial_balance_with_opening_pdf', $data, true);
        //     $dompdf->load_html($page);
        //     $dompdf->render();
        //     $output = $dompdf->output();
        //     file_put_contents('assets/data/pdf/Trial Balance With Opening As On ' . $dtpFromDate . ' To ' . $dtpToDate . '.pdf', $output);


        //     $data['pdf']    = 'assets/data/pdf/Trial Balance With Opening As On ' . $dtpFromDate . ' To ' . $dtpToDate . '.pdf';
        //     $data['title']  = display('trial_balance_report');
        //     $data['module'] = "accounts";
        //     $data['page']   = "trial_balance_with_opening";
        // echo Modules::run('template/layout', $data);
        // } else {

        $data['oResultTr']    = $results['oResultTr'];
        $data['oResultInEx']  = $results['oResultInEx'];
        $data['dtpFromDate']  = $dtpFromDate;
        $data['dtpToDate']    = $dtpToDate;

        // PDF Generator 
        // $dompdf = new DOMPDF();


        // $page = view('user/accounts/trial_balance_without_opening_pdf', ['data', $data]);

        // $dompdf->load_html($page);
        // $dompdf->render();
        // $output = $dompdf->output();
        // file_put_contents('assets/data/pdf/Trial Balance As On ' . $dtpFromDate . ' To ' . $dtpToDate . '.pdf', $output);
        // $data['pdf']    = 'assets/data/pdf/Trial Balance As On ' . $dtpFromDate . ' To ' . $dtpToDate . '.pdf';

        $data['title']  = display('trial_balance_report');
        $data['module'] = "accounts";
        $data['page']   = "trial_balance_without_opening";

        return view('user/accounts/trial_balance_without_opening', get_defined_vars());
        // echo Modules::run('template/layout', $data);
        // }
    }

    //al hassan working
    public function vouchar_cash($date)
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $vouchar_view = Accounts_model::get_vouchar_view($date);
        $data = array(
            'vouchar_view' => $vouchar_view,
        );

        $data['title'] = display('accounts_form');
        $data['module'] = "accounts";
        $data['page']   = "vouchar_cash";
        return view('user/accounts/vouchar_cash', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //alhassan working
    public function general_ledger()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $general_ledger = Accounts_model::get_general_ledger();
        $data = array(
            'general_ledger' => $general_ledger,
        );

        $data['title'] = display('general_ledger');
        $data['module'] = "accounts";
        $data['page']   = "general_ledger";
        return view('user/accounts/general_ledger', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //alhassan working
    public function general_led(Request $request, $Headid = NULL)
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $Headid = $request->Headid;
        $HeadName = Accounts_model::general_led_get($Headid);

        // echo  "<option>Transaction Head</option>";
        $html = "";
        foreach ($HeadName as $data) {
            $html .= "<option value='$data->HeadCode'>$data->HeadName</option>";
        }
        echo $html;
    }
    //al hassan working
    public function voucher_report_serach(Request $request, $vouchar = NULL)
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $vouchar = $request->vouchar;

        $voucher_report_serach = Accounts_model::voucher_report_serach($vouchar);

        if ($voucher_report_serach->Amount == '') {
            $pay = '0.00';
        } else {
            $pay = $voucher_report_serach->Amount;
        }
        $base = url('/');
        $baseurl = $base . '/accounts/vouchar_cash/' . $vouchar;
        $html = "";
        $html .= "<td>
                   <a href=\"$baseurl\">CV-BAC-$vouchar</a>
                 </td>
                 <td>Aggregated Cash Credit Voucher of $vouchar</td>
                 <td>$pay</td>
                 <td align=\"left\">$vouchar</td>";
        echo $html;
    }
    //alhassan working
    public function accounts_report_search(Request $request)
    {

        // $this->permission->method('accounts', 'read')->redirect();
        $cmbGLCode = $request->cmbGLCode;
        $cmbCode = $request->cmbCode;

        $dtpFromDate = $request->dtpFromDate;
        $dtpToDate = $request->dtpToDate;
        $chkIsTransction = $request->chkIsTransction;

        $HeadName = Accounts_model::general_led_report_headname($cmbGLCode);

        $HeadName2 = Accounts_model::general_led_report_headname2($cmbGLCode, $cmbCode, $dtpFromDate, $dtpToDate, $chkIsTransction);

        $pre_balance = Accounts_model::general_led_report_prebalance($cmbCode, $dtpFromDate);

        $data = array(
            'dtpFromDate' => $dtpFromDate,
            'dtpToDate' => $dtpToDate,
            'HeadName' => $HeadName,
            'HeadName2' => $HeadName2,
            'prebalance' =>  $pre_balance,
            'chkIsTransction' => $chkIsTransction,

        );
        $data['ledger'] = DB::table('acc_coa')->where('HeadCode', $cmbCode)->first();
        $data['title'] = display('general_ledger_report');
        $data['module'] = "accounts";
        $data['page']   = "general_ledger_report";

        return view('user/accounts/general_ledger_report', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //alhassan working
    public function check_status_report()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $get_status = Accounts_model::get_status();
        $data = array(
            'get_status' => $get_status,
        );

        $data['title'] = display('general_ledger_report');
        $data['module'] = "accounts";
        $data['page']   = "check_status_report";
        echo '<pre>';
        print_r($data);
        echo '<pre>';
        die();
        // echo Modules::run('template/layout', $data);
    }



    public function cash_book()
    {

        $FromDate = date('Y-m-d');
        $ToDate = date('Y-m-d');
        $PreBalance = 0;
        if (isset($_POST['btnSave'])) {

            $oAccount = new CAccount;

            $oResult = new CResult;
            $Semester = '';
            $Department = '';

            if (isset($_POST['cmbSemester']))
                $Semester = $_POST['cmbSemester'];
            if (isset($_POST['cmbDepartment']))
                $Department = $_POST['cmbDepartment'];

            $HeadCode = $_POST['txtCode'];
            $HeadName = $_POST['txtName'];
            $FromDate = $_POST['dtpFromDate'];
            $ToDate = $_POST['dtpToDate'];


            $sql = "SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, COAID FROM acc_transaction
                      WHERE VDate < '$FromDate' AND COAID LIKE '$HeadCode%' AND IsAppove =1 ";
            $sql .= "GROUP BY IsAppove, COAID";

            $oResult = $oAccount->SqlQuery($sql);

            $PreBalance = 0;

            if ($oResult->num_rows > 0) {
                $PreBalance = $oResult->row['Debit'];
                $PreBalance = $PreBalance - $oResult->row['Credit'];
            }

            $sql = "SELECT acc_transaction.VNo, acc_transaction.Vtype, acc_transaction.VDate, acc_transaction.Debit, acc_transaction.Credit, acc_transaction.IsAppove, acc_transaction.COAID, acc_coa.HeadName, acc_coa.PHeadName, acc_coa.HeadType, acc_transaction.Narration 
                FROM acc_transaction INNER JOIN acc_coa ON acc_transaction.COAID = acc_coa.HeadCode
                WHERE acc_transaction.IsAppove =1 AND acc_transaction.VDate BETWEEN '$FromDate' AND '$ToDate' AND acc_transaction.COAID LIKE '$HeadCode%' ";



            $sql .= "GROUP BY acc_transaction.VNo, acc_transaction.Vtype, acc_transaction.VDate, acc_transaction.IsAppove, acc_transaction.COAID, acc_coa.HeadName, acc_coa.PHeadName, acc_coa.HeadType, acc_transaction.Narration
                       HAVING SUM(acc_transaction.Debit)-SUM(acc_transaction.Credit)<>0
                       ORDER BY  acc_transaction.VDate, acc_transaction.VNo";

            $oResult = $oAccount->SqlQuery($sql);
        }
        // $this->permission->method('accounts', 'read')->redirect();
        $data['title'] = display('cash_book');
        $data['module'] = "accounts";
        $data['page']   = "cash_book";
        return view('user/accounts/cash_book', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    public function bank_book()
    {

        if (isset($_POST['btnSave'])) {

            $oAccount = new CAccount();
            $oResult = new CResult();
            $HeadCode = $_POST['txtCode'];
            $HeadName = $_POST['txtName'];
            $FromDate = $_POST['dtpFromDate'];
            $ToDate = $_POST['dtpToDate'];


            $sql = Accounts_model::bankbook_firstqury($FromDate, $HeadCode);

            $oResult = $oAccount->SqlQuery($sql);
            $PreBalance = 0;

            if ($oResult->num_rows > 0) {
                $PreBalance = $oResult->row['Debit'];
                $PreBalance = $PreBalance - $oResult->row['Credit'];
            }

            $sql = Accounts_model::bankbook_secondqury($FromDate, $HeadCode, $ToDate);
            $oResult = $oAccount->SqlQuery($sql);
        }
        // $this->permission->method('accounts', 'read')->redirect();
        $data['title'] = display('bank_book');
        $data['module'] = "accounts";
        $data['page']   = "bank_book";
        return view('user/accounts/bank_book', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    public function voucher_report()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        //al hassan working
        $get_cash = Accounts_model::get_cash();
        $get_vouchar = Accounts_model::get_vouchar();
        $data = array(
            'get_cash' => $get_cash,
            'get_vouchar' => $get_vouchar,
        );
        $data['title']  = display('voucher_report');
        $data['module'] = "accounts";
        $data['page']   = "coa";

        return view('user/accounts/coa', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    public function voucher_report_print($id)
    {

        $HeadName2 = Accounts_model::voucher_report_print($id);

        $data = array(
            'HeadName2' => $HeadName2
        );

        $data['title']  = display('voucher_report');
        $data['module'] = "accounts";
        $data['page']   = "voucher_report_print";

        return view('user/accounts/voucher_report_print', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    public function vouchar_view($id)
    {

        $HeadName2 = Accounts_model::voucher_report_print($id);

        $data = array(
            'HeadName2' => $HeadName2
        );

        $data['title']  = display('voucher_report');
        $data['module'] = "accounts";
        $data['page']   = "voucher_report_print";

        return view('user/accounts/vouchar_view', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    public function coa_print()
    {

        // $this->permission->method('accounts', 'read')->redirect();
        $data['title'] = display('coa_print');
        $data['module'] = "accounts";
        $data['page']   = "coa_print";
        return view('user/accounts/coa_print', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //Profit loss report page
    public function profit_loss_report()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $data['title'] = display('profit_loss');
        $data['module'] = "accounts";
        $data['page']   = "profit_loss_report";
        return view('user/accounts/profit_loss_report', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //Profit loss serch result
    public function profit_loss_report_search(Request $request)
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $dtpFromDate = $request->dtpFromDate;
        $dtpToDate   = $request->dtpToDate;

        $get_profit  = Accounts_model::profit_loss_serach();

        $data['oResultAsset'] = $get_profit['oResultAsset'];
        $data['oResultLiability']  = $get_profit['oResultLiability'];
        $data['dtpFromDate']  = $dtpFromDate;
        $data['dtpToDate']    = $dtpToDate;
        $data['pdf']    = 'assets/data/pdf/Statement of Comprehensive Income From' . $dtpFromDate . ' To ' . $dtpToDate . '.pdf';
        $data['title']  = display('profit_loss');
        $data['module'] = "accounts";
        $data['page']   = "profit_loss_report_search";
        return view('user/accounts/profit_loss_report_search', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //Cash flow page
    public function cash_flow_report()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $data['title']  = display('cash_flow');
        $data['module'] = "accounts";
        $data['page']   = "cash_flow_report";
        return view('user/accounts/cash_flow_report', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //Cash flow report search
    public function cash_flow_report_search(Request $request)
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $dtpFromDate = $request->dtpFromDate;
        $dtpToDate   = $request->dtpToDate;

        $data['dtpFromDate']  = $dtpFromDate;
        $data['dtpToDate']    = $dtpToDate;

        // PDF Generator 
        // $this->load->library('pdfgenerator');
        // $dompdf = new DOMPDF();
        // $page = $this->load->view('user/accounts/cash_flow_report_search_pdf', $data, true);
        // $dompdf->load_html($page);
        // $dompdf->render();
        // $output = $dompdf->output();
        // file_put_contents('assets/data/pdf/Cash Flow Statement' . $dtpFromDate . ' To ' . $dtpToDate . '.pdf', $output);

        $data['pdf']    = 'assets/data/pdf/Cash Flow Statement' . $dtpFromDate . ' To ' . $dtpToDate . '.pdf';
        $data['title']  = display('cash_flow');
        $data['module'] = "accounts";
        $data['page']   = "cash_flow_report_search";
        return view('user/accounts/cash_flow_report_search', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    //Supplier payment information 
    //Supplier code 
    public function supplier_headcode($id)
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $supplier_info = DB::table('supplier')->where('supid', $id)->first();
        $head_name = $supplier_info->suplier_code . '-' . $supplier_info->supName;
        $supplierhcode =  DB::table('acc_coa')->select('*')
            ->where('HeadName', $head_name)
            ->first();
        $code = $supplierhcode->HeadCode;
        echo json_encode($code);
    }
    public function supplier_payments()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $data['supplier_list'] = Accounts_model::get_supplier();

        $data['voucher_no'] = Accounts_model::Spayment();
        $data['title']  = display('supplier_payment');
        $data['module'] = "accounts";
        $data['page']   = "supplier_payment_form";

        return view('user/accounts/supplier_payment_form', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
    public function banklist()
    {
        $allbank =  DB::table('tbl_bank')->select("*")->get();
        echo json_encode($allbank);
    }
    //supplier payment submit
    public function create_supplier_payment(Request $request)
    {

        // redirect('accounts/supplier_paymentreceipt/' . $supplier_id . '/' . $voucher_no . '/' . $dbtid);
        // return redirect()->route('accounts.supplier_paymentreceipt', ['voucher_no' => 'voucher_no', 'supplier_id' => 'supplier_id', 'coaid' => 'coaid']);
        // $this->permission->method('accounts', 'read')->redirect();
        // $validatedData = $request->validate([
        //     'txtCode' => display('txtCode'), 'max_length[100]',
        // ]);

        // $this->form_validation->set_rules('txtCode', display('txtCode'), 'max_length[100]');
        if ($request->txtCode) {
            $data =  Accounts_model::supplier_payment_insert();

            return Redirect::route('accounts.supplier_paymentreceipt', array('supplier_id' => $data['supplier_id'], 'voucher_no' => $data['voucher_no'], 'coaid' => $data['coaid']));
            // if (Accounts_model::supplier_payment_insert()) {

            //     return redirect()->route('accounts.supplier_payments')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
            // } else {
            //     return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
            // }
            // return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
    }
    public function supplier_paymentreceipt($supplier_id, $voucher_no, $coaid)
    {

        // $this->permission->method('accounts', 'read')->redirect();
        $seting =  DB::table('setting')->select("*")->first();

        $currencyinfo =  DB::table('currency')->select("*")->where('currencyid', '4')->first();

        $data['currency'] = $currencyinfo->curr_icon;
        $data['position'] = $currencyinfo->position;
        $data['supplier_info'] = Accounts_model::supplierinfo($supplier_id);

        $data['payment_info']  = Accounts_model::supplierpaymentinfo($voucher_no, $coaid);
        $data['company_info']  = $seting;
        // $data['currency']      = $currency_details[0]['currency'];
        // $data['position']      = $currency_details[0]['currency_position'];
        // $data['currency']      = $currencyinfo->currencyname;
        // $data['position']      = $currencyinfo->position;
        $data['title']         = display('supplier_payment');
        $data['module'] = "accounts";
        $data['page']   = "supplier_payment_receipt";

        return view('user/accounts/supplier_payment_receipt', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }

    // cash adjustment
    public function cash_adjustment()
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $data['voucher_no'] = Accounts_model::Cashvoucher();
        $data['title']  = display('cash_adjustment');
        $data['module'] = "accounts";
        $data['page']   = "cash_adjustment";
        return view('user/accounts/cash_adjustment', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }

    //Create Cash Adjustment
    public function create_cash_adjustment(Request $request)
    {
        if ($request->txtVNo) {
            $data =  Accounts_model::insert_cashadjustment();
            return redirect()->back()->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        } else {
            return redirect()->back()->with(['alert' => 'error', 'message' => 'Error...Something Went Wrong']);
        }
        // $this->permission->method('accounts', 'read')->redirect();
        // $this->form_validation->set_rules('txtAmount', display('amount'), 'max_length[100]');
        // if ($request->all()) {
        //     if (Accounts_model::insert_cashadjustment()) {
        //         $this->session->set_flashdata('message', display('save_successfully'));
        //         redirect('accounts/accounts/cash_adjustment/');
        //     } else {
        //         $this->session->set_flashdata('error_message',  display('please_try_again'));
        //     }
        //     redirect("accounts/accounts/cash_adjustment");
        // } else {
        //     $this->session->set_flashdata('error_message',  display('please_try_again'));
        //     redirect("accounts/accounts/cash_adjustment");
        // }
    }
    public function balance_sheet(Request $request)
    {
        // $this->permission->method('accounts', 'read')->redirect();
        $data['title']       = display('balance_sheet');
        $from_date           = (!empty($request->dtpFromDate) ? $request->dtpFromDate : date('Y-m-d'));
        $to_date             = (!empty($request->dtpToDate) ? $request->dtpToDate : date('Y-m-d'));
        $data['from_date']   = $from_date;
        $data['to_date']     = $to_date;
        $data['fixed_assets'] = Accounts_model::fixed_assets();
        $data['liabilities'] = Accounts_model::liabilities_data();
        $data['incomes']     = Accounts_model::income_fields();
        $data['expenses']    = Accounts_model::expense_fields();
        $data['module']      = "accounts";
        $data['page']        = "balance_sheet";
        return view('user/accounts/balance_sheet', get_defined_vars());
        // echo Modules::run('template/layout', $data);
    }
}
