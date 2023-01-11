<?php

namespace App\Models;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

// defined('BASEPATH') or exit('No direct script access allowed');
//->whereRaw("`VNo` LIKE 'CHV-%' ESCAPE '!'")
//
class Accounts_model extends Model
{
    public static function get_userlist()
    {
        $query =  DB::table('acc_coa')
            ->select('*')
            ->where('IsActive', 1)
            ->orderBy('HeadName');

        if ($query->count() >= 1) {
            return $query->get();
        } else {
            return false;
        }
    }
    public static function get_coahead()
    {
        $query =  DB::table('acc_coa')
            ->select('*')
            ->where('PHeadName', 'COA')
            ->where('IsActive', 1)
            ->orderBy('HeadName');


        if ($query->count() >= 1) {
            return $query->get();
        } else {
            return false;
        }
    }
    public function sub_parents($pheadname)
    {

        $query =  DB::table('acc_coa')
            ->select('*')
            ->where('PHeadName', $pheadname)
            ->where('IsActive', 1)
            ->orderBy('HeadName');
        $pheadlist = $query->get();
        $i = 0;
        foreach ($pheadlist as $p_cat) {
            $pheadlist[$i]->sub = $this->sub_parents($p_cat->HeadName);
            $i++;
        }
        return $pheadlist;
    }
    public static  function allphead_dropdown($pheadname)
    {

        $obj = new Accounts_model();
        $query =  DB::table('acc_coa')
            ->select('*')
            ->where('PHeadName', $pheadname)
            ->where('IsActive', 1)
            ->orderBy('HeadName');
        $pheadlist = $query->get();
        $i = 0;
        foreach ($pheadlist as $p_cat) {

            $pheadlist[$i]->sub = $obj->sub_parents($p_cat->HeadName);
            $i++;
        }
        return $pheadlist;
    }

    public static  function findById($id = null)
    {
        return  DB::table('acc_coa')
            ->select("*")
            ->where('HeadCode', $id)
            ->first();
    }
    public static function updarecoahead($data = array())
    {
        return DB::table('acc_coa')->where('HeadCode', $data["HeadCode"])
            ->update($data);
    }
    public static function head_delete($id)
    {
        $query =  DB::table('acc_coa')->where('HeadCode', $id)->delete();
        if ($query) {
            return true;
        } else {
            return false;
        }
        // ->where('HeadCode', $id)->delete('acc_coa');
        // if (->affected_rows()) {
        //     return true;
        // } else {
        //     return false;
        // }
    }


    public function dfs($HeadName, $HeadCode, $oResult, $visit, $d)
    {
        if ($d == 0) echo "<li>$HeadName";
        else      echo "<li><a href='javascript:' onclick=\"loadData('" . $HeadCode . "')\">$HeadName</a>";
        $p = 0;
        for ($i = 0; $i < count($oResult); $i++) {

            if (!$visit[$i]) {
                if ($HeadName == $oResult[$i]->PHeadName) {
                    $visit[$i] = true;
                    if ($p == 0) echo "<ul>";
                    $p++;
                    $this->dfs($oResult[$i]->HeadName, $oResult[$i]->HeadCode, $oResult, $visit, $d + 1);
                }
            }
        }
        if ($p == 0)
            echo "</li>";
        else
            echo "</ul>";
    }

    // Accounts list
    public static  function Transacc()
    {
        return  $data = DB::table('acc_coa')->select("*")
            //->where('IsTransaction', 1)
            ->where('IsActive', 1)
            ->orderBy('HeadName')
            ->get();
    }

    // Credit Account Head
    public static  function Cracc()
    {
        // donot remove
        // return  $data = DB::select("SELECT *
        // FROM `acc_coa`
        // WHERE `HeadCode` LIKE '1020102%' ESCAPE '!'
        // AND `IsTransaction` = 1
        // ORDER BY `HeadName`");
        return  $data = DB::select("SELECT *
        FROM `acc_coa`
        WHERE `IsTransaction` = 1
        ORDER BY `HeadName`");
    }

    // Insert Debit voucher 
    public static  function insert_debitvoucher()
    {
        $voucher_no = addslashes(trim($_POST['txtVNo']));
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

            DB::table('acc_transaction')->insert($debitinsert);
        }
        return true;
    }

    // Update debit voucher
    public static  function update_debitvoucher()
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

            DB::table('acc_transaction')->insert($debitinsert);
        }
        return true;
    }
    //Generate Voucher No
    public static  function voNO()
    {
        return $data = DB::table('acc_transaction')->where('Vtype','DV')->orderBy('id','desc')->first();
        return DB::select("SELECT Max(VNo) as voucher FROM `acc_transaction` WHERE `VNo` LIKE 'DV-%' ESCAPE '!'");
        return  $data = DB::select("SELECT Max(VNo) as voucher
        FROM `acc_transaction`
        WHERE `VNo` LIKE 'DV-' ESCAPE '!'");
    }
    // Credit voucher no
    public static  function crVno()
    {
       return $data = DB::table('acc_transaction')->where('Vtype','CV')->orderBy('id','desc')->first();
       
        return DB::select("SELECT Max(VNo) as voucher FROM `acc_transaction` WHERE `VNo` LIKE 'CV-%' ESCAPE '!'");
        return  $data = DB::select("SELECT Max(VNo) as voucher
        FROM `acc_transaction`
        WHERE `VNo` LIKE 'CV-' ESCAPE '!'");
        // return  $data = DB::table('acc_transaction')->select("Max(VNo) as voucher")

        //     ->like('VNo', 'CV-', 'after')

        //     ->first();
    }

    // Contra voucher 

    public static  function contra()
    {
        return $data = DB::table('acc_transaction')->where('Vtype','Contra')->orderBy('id','desc')->first();
        return DB::select("SELECT Max(VNo) as voucher FROM `acc_transaction` WHERE `VNo` LIKE 'Contra-%' ESCAPE '!'");
        return  $data = DB::select("SELECT Max(VNo) as voucher
        FROM `acc_transaction`
        WHERE `VNo` LIKE 'Contra-' ESCAPE '!'");
        // return  $data = DB::table('acc_transaction')->select("Max(VNo) as voucher")

        //     ->like('VNo', 'Contra-', 'after')

        //     ->first();
    }


    // Insert Credit voucher 
    public static  function insert_creditvoucher()
    {
        $voucher_no = addslashes(trim($_POST['txtVNo']));
        $Vtype = "CV";
        $dAID = $_POST['cmbDebit'];
        $cAID = $_POST['txtCode'];
        $remark = $_POST['remark'];
        $Credit = $_POST['txtAmount'];
        $debit = $_POST['grand_total'];
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
            'COAID'          =>  $dAID,
            'Narration'      =>  $Narration,
            'Debit'          =>  $debit,
            'Credit'         =>  0,
            'StoreID'        => 0,
            'IsPosted'       => $IsPosted,
            'CreateBy'       => $CreateBy,
            'CreateDate'     => $createdate,
            'IsAppove'       => 0
        );

        DB::table('acc_transaction')->insert($cinsert);
        for ($i = 0; $i < count($cAID); $i++) {
            $crtid = $cAID[$i];
            $Cramnt = $Credit[$i];
            $remarkT = $remark[$i];

            $debitinsert = array(
                'VNo'            =>  $voucher_no,
                'Vtype'          =>  $Vtype,
                'VDate'          =>  $VDate,
                'COAID'          =>  $crtid,
                'Narration'      =>  $remarkT,
                'Debit'          =>  0,
                'Credit'         =>  $Cramnt,
                'StoreID'        => 0,
                'IsPosted'       => $IsPosted,
                'CreateBy'       => $CreateBy,
                'CreateDate'     => $createdate,
                'IsAppove'       => 0
            );

            DB::table('acc_transaction')->insert($debitinsert);
        }
        return true;
    }

    // Insert Countra voucher 
    public static  function insert_contravoucher()
    {
        $voucher_no = addslashes(trim($_POST['txtVNo']));
        $Vtype = "Contra";
        // $dAID = $_POST['cmbDebit'];
        $cAID = $_POST['txtCode'];
        $debit = $_POST['txtAmount'];
        $remark = $_POST['remark'];
        $credit = $_POST['txtAmountcr'];
        $VDate = $_POST['dtpDate'];
        $Narration = addslashes(trim($_POST['txtRemarks']));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');
        for ($i = 0; $i < count($cAID); $i++) {
            $contrainsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $cAID[$i],
                'Narration' => $remark[$i],
                'Debit' => $debit[$i],
                'Credit' => $credit[$i],
                'StoreID' => 0,
                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );
            DB::table('acc_transaction')->insert($contrainsert);
        }
        return true;
    }
    // Insert journal voucher 
    public static  function insert_journalvoucher()
    {
        $voucher_no = addslashes(trim($_POST['txtVNo']));
        $Vtype = "JV";
        // $dAID = $_POST['cmbDebit'];
        $cAID = $_POST['txtCode'];
        $debit = $_POST['txtAmount'];
        $remark = $_POST['remark'];
        $credit = $_POST['txtAmountcr'];
        $VDate = $_POST['dtpDate'];
        $Narration = addslashes(trim($_POST['txtRemarks']));
        $IsPosted = 1;
        $IsAppove = 0;
        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');


        for ($i = 0; $i < count($cAID); $i++) {


            $contrainsert = array(
                'VNo' => $voucher_no,
                'Vtype' => $Vtype,
                'VDate' => $VDate,
                'COAID' => $cAID[$i],
                'Narration' =>  $remark[$i],
                'Debit' => $debit[$i],
                'Credit' => $credit[$i],

                'IsPosted' => $IsPosted,
                'CreateBy' => $CreateBy,
                'CreateDate' => $createdate,
                'IsAppove' => 0
            );

            DB::table('acc_transaction')->insert($contrainsert);
        }

        return true;
    }
    // journal voucher
    public static  function journal()
    {
        return $data = DB::table('acc_transaction')->where('Vtype','JV')->orderBy('id','desc')->first();
        return DB::select("SELECT Max(VNo) as voucher FROM `acc_transaction` WHERE `VNo` LIKE 'Journal-%' ESCAPE '!'");
        return  $data = DB::select("SELECT Max(VNo) as voucher
        FROM `acc_transaction`
        WHERE `VNo` LIKE 'Journal-' ESCAPE '!'");
        // return  $data = DB::table('acc_transaction')->select("Max(VNo) as voucher")

        //     ->like('VNo', 'Journal-', 'after')
        //     ->first();
    }
    public static  function approved_voucher()
    {
        return $approveinfo = DB::select("SELECT *, SUM(Debit) as totaldebit, SUM(Credit) as totalcredit
        FROM `acc_transaction`
        WHERE `Vtype` IN('DV', 'CV', 'JV', 'Contra')
        AND `IsAppove` =1
        GROUP BY `VNo`");
    }
    // voucher Aprove 
    public static  function approve_voucher()
    {

        //   return $approveinfo = DB::select("SELECT *, SUM(Debit) as totaldebit, SUM(Credit) as totalcredit
        //   FROM `acc_transaction`
        //   WHERE `Vtype` IN('DV', 'CV', 'JV', 'Contra')
        //   AND `IsAppove` =0
        //   GROUP BY `VNo`");


        //$values = array("DV", "CV", "JV", "Contra");
        //$approveinfo = DB::table('acc_transaction')->select('*',DB::raw('SUM(Debit) AS totaldebit'), DB::raw('SUM(Credit) AS totalcredit'))

        //return $approveinfo = DB::table('acc_transaction')
        //	->select(['*',DB::raw("SUM(Debit) as totaldebit"), DB::raw("SUM(Credit) as totalcredit")])
        //->whereIn('Vtype', $values)
        //->where('IsAppove', 0)
        //->groupBy('VNo')
        //->sum(DB::raw('SUM(Debit) AS totaldebit'))
        //->get();

        return $approveinfo = DB::table('acc_transaction')->select('*')
            ->where('IsAppove', 0)
            ->get();
    }
    //approved
    public static  function approved($data = [])
    {

        return DB::table('acc_transaction')->where('VNo', $data['VNo'])
            ->update($data);
    }

    //debit update voucher
    public static function dbvoucher_updata($id)
    {
        return  $vou_info = DB::table('acc_transaction')->select('*')

            ->where('VNo', $id)
            ->where('Credit', '<', 1)
            ->get();
    }

    //credit voucher update 
    public static function crdtvoucher_updata($id)
    {
        return  $vou_info = DB::table('acc_transaction')->select('*')

            ->where('VNo', $id)
            ->where('Debit', '<', 1)
            ->get();
    }

    public static function journalCrebitVoucher_edit($id)
    {
        return $vou_info = DB::table('acc_transaction')->select('*')

            ->where('VNo', $id)
            ->get();
    }
    //Debit voucher inof
    //credit voucher update 
    public static function debitvoucher_updata($id)
    {
        return $cr_info = DB::table('acc_transaction')->select('*')
            ->where('VNo', $id)
            ->where('Credit','<', 1)
            ->first();
    }
    // debit update voucher credit info
    public static function crvoucher_updata($id)
    {
        return $v_info = DB::table('acc_transaction')->select('*')
            ->from('acc_transaction')
            ->where('VNo', $id)
            ->where('Debit','<', 1)
            ->first();
    }

    // update Credit voucher
    public static function update_creditvoucher()
    {
        $voucher_no = addslashes(trim($_POST['txtVNo']));
        $Vtype = "CV";
        $dAID = $_POST['cmbDebit'];
        $cAID = $_POST['txtCode'];
        $Credit = $_POST['txtAmount'];
        $debit = $_POST['grand_total'];
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
            'COAID'          =>  $dAID,
            'Narration'      =>  $Narration,
            'Debit'          =>  $debit,
            'Credit'         =>  0,
            'StoreID'        => 0,
            'IsPosted'       => $IsPosted,
            'CreateBy'       => $CreateBy,
            'CreateDate'     => $createdate,
            'IsAppove'       => 0
        );
        DB::table('acc_transaction')->where('VNo', $voucher_no)
            ->delete();

        DB::table('acc_transaction')->insert($cinsert);
        for ($i = 0; $i < count($cAID); $i++) {
            $crtid = $cAID[$i];
            $Cramnt = $Credit[$i];

            $debitinsert = array(
                'VNo'            =>  $voucher_no,
                'Vtype'          =>  $Vtype,
                'VDate'          =>  $VDate,
                'COAID'          =>  $crtid,
                'Narration'      =>  $Narration,
                'Debit'          =>  0,
                'Credit'         =>  $Cramnt,
                'StoreID'        => 0,
                'IsPosted'       => $IsPosted,
                'CreateBy'       => $CreateBy,
                'CreateDate'     => $createdate,
                'IsAppove'       => 0
            );

            DB::table('acc_transaction')->insert($debitinsert);
        }
        return true;
    }
    //contra voucher update 
    public static function contravoucher_updata($id)
    {
        return  $vou_info = DB::table('acc_transaction')->select('*')
            ->where('VNo', $id)
            ->get();
    }
    //Trial Balance Report 
    public static function trial_balance_report($FromDate, $ToDate, $WithOpening)
    {

        if ($WithOpening) {
            $WithOpening = true;
        } else {
            $WithOpening = false;
        }
        $sql = "SELECT * FROM acc_coa WHERE IsGL=1 AND IsActive=1 AND HeadType IN ('A','L') ORDER BY HeadCode";
        $oResultTr = DB::select($sql);
        $oResultTr = array_map(function ($value) {
            return (array)$value;
        }, $oResultTr);
        // $oResultTr = DB::raw('acc_coa')->query($sql);

        $sql = "SELECT * FROM acc_coa WHERE IsGL=1 AND IsActive=1 AND HeadType IN ('I','E') ORDER BY HeadCode";
        $oResultInEx = DB::select($sql);
        $oResultInEx = array_map(function ($value) {
            return (array)$value;
        }, $oResultInEx);
        // $oResultInEx = ->query($sql);

        $data = array(
            'oResultTr'   => $oResultTr,
            'oResultInEx' => $oResultInEx,
            'WithOpening' => $WithOpening
        );

        return $data;
    }

    //al hassan working
    public static function get_vouchar()
    {


        $date = date('Y-m-d');
    
        // $sql = "SELECT VNo, Vtype,VDate, SUM(Debit+Credit)/2 as Amount FROM acc_transaction  WHERE VDate='$date' AND VType IN ('DV','JV','CV') GROUP BY VNO, Vtype, VDate ORDER BY VDate";
        $sql = "SELECT VNo, Vtype,VDate, SUM(Debit+Credit)/2 as Amount FROM acc_transaction  WHERE VType IN ('DV','JV','CV') GROUP BY VNO, Vtype, VDate ORDER BY VDate";
        return $query = DB::select($sql);
        
    }
    //al hassan working
    public static function get_vouchar_view($date)
    {
        $sql = "SELECT acc_income_expence.COAID,SUM(acc_income_expence.Amount) AS Amount, acc_coa.HeadName FROM acc_income_expence INNER JOIN acc_coa ON acc_coa.HeadCode=acc_income_expence.COAID WHERE Date='$date' AND acc_income_expence.IsApprove=1 AND acc_income_expence.Paymode='Cash' GROUP BY acc_income_expence.COAID, acc_coa.HeadName ORDER BY acc_coa.HeadName";
        return $query = DB::select($sql);
        // return $query->get();
    }
    //al hassan working
    public static   function get_cash()
    {
        $date = date('Y-m-d');

        return $sql = DB::select(DB::raw("SELECT SUM(Debit) as Amount FROM acc_transaction WHERE VDate='$date' AND COAID ='1020101' AND VType NOT IN ('DV','JV','CV') AND IsAppove='1'"))[0];
        // $sql = "SELECT SUM(Debit) as Amount FROM acc_transaction WHERE VDate='$date' AND COAID ='1020101' AND VType NOT IN ('DV','JV','CV') AND IsAppove='1'";
        // return  $query = DB::select($sql);
        // return $query->first();
    }
    //al hassan working
    public static function get_general_ledger()
    {
        $query =  DB::table('acc_coa')
            ->select('*')
            ->where('IsGL', 1)
            ->orderBy('HeadName', 'asc');
        return $query->get();
    }
    //al hassan working
    public static function general_led_get($Headid)
    {
        $sql = "SELECT * FROM acc_coa WHERE HeadCode='$Headid' ";
        $rs = DB::select(DB::raw($sql))[0];
        $sql1 = "SELECT * FROM acc_coa WHERE IsTransaction=1 AND PHeadName='" . $rs->HeadName . "' ORDER BY HeadName";
        return $sql = DB::select($sql1);
    }
    public static function voucher_report_serach($vouchar)
    {
        $sql = "SELECT SUM(Debit) as Amount FROM acc_transaction WHERE VDate='$vouchar' AND COAID ='1020101' AND VType NOT IN ('DV','JV','CV') AND IsAppove='1'";
        return $sql = DB::select(DB::raw($sql))[0];
    }


    public static function general_led_report_headname($cmbGLCode)
    {
        return $query = DB::table('acc_coa')->select('*')
            ->where('HeadCode', $cmbGLCode)
            ->first();
    }
    public static function voucher_report_print($id)
    {
        return $query = DB::table('acc_transaction')
        ->select('*', 'acc_coa.HeadName', 'acc_coa.PHeadName', 'acc_coa.HeadType','acc_coa.PHeadName','acc_coa.HeadType')
        ->select('*')
        ->join('acc_coa', 'acc_coa.HeadCode', '=', 'acc_transaction.COAID')
        // ->where('acc_transaction.COAID', $cmbCode)
        ->where('acc_transaction.VNo', $id)
        ->get();
    }
    public static function general_led_report_headname2($cmbGLCode, $cmbCode, $dtpFromDate, $dtpToDate, $chkIsTransction)
    {

        if ($chkIsTransction) {
            return $query = DB::table('acc_transaction')
                ->select('*', 'acc_coa.HeadName', 'acc_coa.PHeadName', 'acc_coa.HeadType','acc_coa.PHeadName','acc_coa.HeadType')
                ->select('*')
                ->join('acc_coa', 'acc_coa.HeadCode', '=', 'acc_transaction.COAID')
                ->where('acc_transaction.IsAppove', 1)
                ->whereRaw("VDate BETWEEN '$dtpFromDate 00:00:00' AND '$dtpToDate 00:00:00'")
                ->where('acc_transaction.COAID', $cmbCode)
                ->get();

         
            // SELECT `acc_transaction`.`COAID`, `acc_transaction`.`Debit`, `acc_transaction`.`Credit`, `acc_coa`.`HeadName`, `acc_transaction`.`IsAppove`, `acc_coa`.`PHeadName`, `acc_coa`.`HeadType`
            // FROM `acc_transaction`
            // LEFT JOIN `acc_coa` ON `acc_transaction`.`COAID` = `acc_coa`.`HeadCode`
            // WHERE `acc_transaction`.`IsAppove` = 1
            // AND `VDate` BETWEEN "" and ""
            // AND `acc_transaction`.`COAID` = '102020102'
            // if ($cmbCode) {
            //     $cmbCodes = $cmbCode;
            // } else {
            //     $cmbCodes = $cmbGLCode;
            // }

            // echo '<pre>';
            // print_r($dtpFromDate);
            // echo '<pre>';
            // print_r($dtpToDate);
            // echo '<pre>';
            // die();
            $sql1 = 'SELECT `acc_transaction`.`COAID`, `acc_transaction`.`Debit`, `acc_transaction`.`Credit`, `acc_coa`.`HeadName`, `acc_transaction`.`IsAppove`, `acc_coa`.`PHeadName`, `acc_coa`.`HeadType`
            FROM `acc_transaction`
            LEFT JOIN `acc_coa` ON `acc_transaction`.`COAID` = `acc_coa`.`HeadCode`
            WHERE `acc_transaction`.`IsAppove` = 1 AND `VDate` BETWEEN ' . $dtpFromDate . ' and  ' . $dtpToDate
                . ' AND `acc_transaction`.`COAID` = ' . $cmbCode;

          
            // $sql1 = "SELECT `acc_transaction`.`VNo`, `acc_transaction`.`Vtype`, `acc_transaction`.`VDate`, `acc_transaction`.`Narration`, `acc_transaction`.`Debit`, `acc_transaction`.`Credit`, `acc_transaction`.`IsAppove`, `acc_transaction`.`COAID`, `acc_coa`.`HeadName`, `acc_coa`.`PHeadName`, `acc_coa`.`HeadType` FROM `acc_transaction` LEFT JOIN `acc_coa` ON `acc_transaction`.`COAID` = `acc_coa`.`HeadCode` WHERE `acc_transaction`.`IsAppove` = 1 AND `VDate` BETWEEN $dtpFromDate and $dtpToDate AND `acc_transaction`.`COAID` = $cmbCode";
            return DB::select($sql1);
            // $query = DB::table('acc_transaction')
            //     ->select('acc_transaction.VNo, acc_transaction.Vtype, acc_transaction.VDate, acc_transaction.Narration, acc_transaction.Debit, acc_transaction.Credit, acc_transaction.IsAppove, acc_transaction.COAID,acc_coa.HeadName, acc_coa.PHeadName, acc_coa.HeadType')
            //     ->join('acc_coa', 'acc_transaction.COAID = acc_coa.HeadCode', 'left')
            //     ->where('acc_transaction.IsAppove', 1)
            //    // ->whereRaw("VDate BETWEEN '$dtpFromDate 00:00:00' AND '$dtpToDate 00:00:00'")
            //     //->where('acc_transaction.COAID', $cmbCode)
            //     ->get();

        } else {

            return $query = DB::table('acc_transaction')
            ->select('*', 'acc_coa.HeadName', 'acc_coa.PHeadName', 'acc_coa.HeadType','acc_coa.PHeadName','acc_coa.HeadType')
            ->select('*')
            ->join('acc_coa', 'acc_coa.HeadCode', '=', 'acc_transaction.COAID')
            ->where('acc_transaction.IsAppove', 1)
            ->whereRaw("VDate BETWEEN '$dtpFromDate 00:00:00' AND '$dtpToDate 00:00:00'")
            ->where('acc_transaction.COAID', $cmbCode)
            ->get();
            // if ($cmbCode) {
            //     $cmbCode = $cmbCode;
            // } else {
            //     $cmbCode = $cmbGLCode;
            // }
            $sql = 'SELECT `acc_transaction`.`VNo`, `acc_transaction`.`Vtype`, `acc_transaction`.`VDate`, `acc_transaction`.`Narration`, `acc_transaction`.`Debit`, `acc_transaction`.`Credit`, `acc_transaction`.`IsAppove`, `acc_transaction`.`COAID`, `acc_coa`.`HeadName`, `acc_coa`.`PHeadName`, `acc_coa`.`HeadType`
           FROM `acc_transaction`
           LEFT JOIN `acc_coa` ON `acc_transaction`.`COAID` = `acc_coa`.`HeadCode`
           WHERE `acc_transaction`.`IsAppove` = 1
           AND `VDate` BETWEEN ' . $dtpFromDate . ' and  ' . $dtpToDate
                . ' AND `acc_transaction`.`COAID` = ' . $cmbCode;

            return  DB::select($sql);
        }
    }
    // prebalance calculation
    public static function general_led_report_prebalance($cmbCode, $dtpFromDate)
    {

        $sql = 'SELECT sum(acc_transaction.Debit) as predebit, sum(acc_transaction.Credit) as precredit
        FROM `acc_transaction`
        WHERE `acc_transaction`.`IsAppove` = 1
        AND `VDate` < ' . $dtpFromDate
            . ' AND `acc_transaction`.`COAID` = ' . $cmbCode;

        $query = DB::select(DB::raw($sql))[0];

        return $balance = $query->predebit - $query->precredit;
    }

    public static function get_status()
    {
        return  $data = DB::select("SELECT *
        FROM `acc_coa`
        WHERE `IsTransaction` = 1
        AND  `HeadCode` LIKE '1020102%' ESCAPE '!'
        ORDER BY `HeadName` ASC");
        // return $query = DB::table('acc_coa')
        //     ->select('*')
        //     ->where('IsTransaction', 1)
        //     ->like('HeadCode', '1020102', 'after')
        //     ->order_by('HeadName', 'asc')
        //     ->get();
    }

    //Profict loss report search
    public static function profit_loss_serach()
    {

        // $sql = "SELECT * FROM acc_coa WHERE acc_coa.HeadType='I'";
        // $sql1 = ->query($sql);

        // $sql = "SELECT * FROM acc_coa WHERE acc_coa.HeadType='E'";
        // $sql2 = ->query($sql);

        // $data = array(
        //     'oResultAsset'     => $sql1->result(),
        //     'oResultLiability' => $sql2->result(),
        // );
        // return $data;
        $sql = "SELECT * FROM acc_coa WHERE acc_coa.HeadType='I'";
        $sql11 = DB::select($sql);
        //     $sql11 = array_map(function ($value) {
        //        return (array)$value;
        //    }, $sql11);

        $sql2 = "SELECT * FROM acc_coa WHERE acc_coa.HeadType='E'";
        $sql22 = DB::select($sql2);
        //     $sql22 = array_map(function ($value) {
        //        return (array)$value;
        //    }, $sql22);
        $data = array(
            'oResultAsset'     => $sql11,
            'oResultLiability' => $sql22,
        );

        return $data;
    }
    public static function profit_loss_serach_date($dtpFromDate, $dtpToDate)
    {
        $sqlF = "SELECT  acc_transaction.VDate, acc_transaction.COAID, acc_coa.HeadName FROM acc_transaction INNER JOIN acc_coa ON acc_transaction.COAID = acc_coa.HeadCode WHERE acc_transaction.VDate BETWEEN '$dtpFromDate' AND '$dtpToDate' AND acc_transaction.IsAppove = 1 AND  acc_transaction.COAID LIKE '301%'";
        return $query = DB::raw($sqlF);
        // return $query->result();
    }
    public static function get_supplier()
    {
        return $query = DB::table('supplier')
            ->select('*')
            ->orderBy('supid', 'desc')
            ->get();
    }
    public static  function Spayment()
    {
        return  $data = DB::select("SELECT `VNo` as `voucher`
        FROM `acc_transaction`
        WHERE `VNo` LIKE 'PM-%' ESCAPE '!'
        ORDER BY `ID` DESC");
        // return  $data = DB::table('acc_transaction')->select("VNo as voucher")
        //     ->like('VNo', 'PM-', 'after')
        //     ->order_by('ID', 'desc')
        //     ->first();
    }
    public static  function Cashvoucher()
    {
        // return  $data = DB::select("SELECT `VNo` as `voucher`
        // FROM `acc_transaction`
        // WHERE `VNo` LIKE 'CHV-%' ESCAPE '!'
        // ORDER BY `ID` DESC");
        return  $data = DB::table('acc_transaction')->select("VNo as voucher")
            ->whereRaw("`VNo` LIKE 'CHV-%' ESCAPE '!'")
            ->orderBy('ID', 'desc')
            ->first();
    }
    public static  function supplier_payment_insert()
    {

        $voucher_no = addslashes(trim($_POST['txtVNo']));

        $Vtype = "PM";
        // $cAID = $_POST['cmbDebit'];
        $dAID = $_POST['txtCode'];
        $Debit = $_POST['txtAmount'];
        $payment_type = $_POST['paytype'];
        $bakid = '';
        if ($payment_type == 2) {
            $bakid = $_POST['bank'];
            $bankinfo = DB::table('tbl_bank')->select('*')->where('bankid', $bakid)->first();
            $bankheadcode = DB::table('acc_coa')->select('*')->where('HeadName', $bankinfo->bank_name)->first();
        }
        $Credit = 0;
        $VDate = $_POST['dtpDate'];
        $Narration = addslashes(trim($_POST['txtRemarks']));
        $IsPosted = 1;
        $IsAppove = 1;
        $sup_id = $_POST['supplier_id'];

        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');

        $dbtid = $dAID;
        $Damnt = $Debit;
        $supplier_id = $sup_id;
        $supinfo = DB::table('supplier')->select('*')->where('supid', $supplier_id)->first();
        $supplierdebit = array(
            'VNo'            =>  $voucher_no,
            'Vtype'          =>  $Vtype,
            'VDate'          =>  $VDate,
            'COAID'          =>  $dbtid,
            'Narration'      =>  $Narration,
            'Debit'          =>  $Damnt,
            'Credit'         =>  0,
            'IsPosted'       => $IsPosted,
            'CreateBy'       => $CreateBy,
            'CreateDate'     => $createdate,
            'IsAppove'       => 1
        );
        $datapay = array(
            'transaction_id' => $voucher_no,
            'supplier_id'    => $supplier_id,
            'chalan_no'      => NULL,
            'deposit_no'     => $voucher_no,
            'amount'         => $Damnt,
            'description'    => 'Paid to ' . $supinfo->supName,
            'payment_type'   => 1,
            'cheque_no'      => '',
            'date'           => $VDate,
            'status'         => 1,
            'd_c'            => 'd'
        );

        DB::table('acc_transaction')->insert($supplierdebit);
        DB::table('supplier_ledger')->insert($datapay);
        if ($payment_type == 2) {
            $podebitpaidamount = array(
                'VNo'            =>  $voucher_no,
                'Vtype'          =>  $Vtype,
                'VDate'          =>  $VDate,
                'COAID'          =>  $bankheadcode->HeadCode,
                'Narration'      =>  'Paid On Bank to ' . $supinfo->supName,
                'Debit'          =>  0,
                'Credit'         =>  $Damnt, // paid amount*****
                'StoreID'        =>  0,
                'IsPosted'       =>  $IsPosted,
                'CreateBy'       => $CreateBy,
                'CreateDate'     => $createdate,
                'IsAppove'       =>  1
            );
            $banksummary = array(
                'date'          =>  $VDate,
                'ac_type'       =>  'Credit(-)',
                'bank_id'       =>  $bakid,
                'description'   =>  'Supplier Payments',
                'deposite_id'   =>  $voucher_no,
                'dr'            =>  null,
                'cr'            =>  $Damnt,
                'ammount'       =>  $Damnt,
                'status'        =>  1
            );

            DB::table('acc_transaction')->insert($podebitpaidamount);
            DB::table('bank_summary')->insert($banksummary);
        } else {
            $cc = array(
                'VNo'            =>  $voucher_no,
                'Vtype'          =>  $Vtype,
                'VDate'          =>  $VDate,
                'COAID'          =>  1020101,
                'Narration'      =>  'Paid to ' . $supinfo->supName,
                'Debit'          =>  0,
                'Credit'         =>  $Damnt,
                'IsPosted'       =>  1,
                'CreateBy'       =>  $CreateBy,
                'CreateDate'     =>  $createdate,
                'IsAppove'       =>  1
            );
            DB::table('acc_transaction')->insert($cc);
        }
        return $dtaa = array('supplier_id' => $supplier_id, 'voucher_no' => $voucher_no, 'coaid' => $dbtid);
        // return redirect()->route('accounts.show_tree')->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        // return redirect()->to(url('/accounts/supplier_paymentreceipt/' . $supplier_id . '/' . $voucher_no . '/' . $dbtid))->with(['alert' => 'success', 'message' => 'Insert Successfully']);
        // return Redirect::route('accounts.supplier_paymentreceipt',array('supplier_id' => $supplier_id,'voucher_no' => $voucher_no,'coaid' => $dbtid));
        // redirect('accounts/supplier_paymentreceipt/' . $supplier_id . '/' . $voucher_no . '/' . $dbtid);

    }
    //Retrieve company Edit Data
    public static  function supplierinfo($supplier_id)
    {
        return DB::table('supplier')->select('*')
            ->where('supid', $supplier_id)
            ->first();
    }
    public static  function supplierpaymentinfo($voucher_no, $coaid)
    {
        return $payments = DB::table('acc_transaction')->select('*')->where('VNo', $voucher_no)->where('COAID', $coaid)->first();
    }
    public static  function insert_cashadjustment()
    {
        $voucher_no = $_POST['txtVNo'];
        $Vtype = "AD";
        $amount = $_POST['txtAmount'];
        $type = $_POST['type'];
        if ($type == 1) {
            $debit = $amount;
            $credit = 0;
        }
        if ($type == 2) {
            $debit = 0;
            $credit = $amount;
        }
        $VDate = $_POST['dtpDate'];
        $Narration = $_POST['txtRemarks'];
        $IsPosted = 1;
        $IsAppove = 1;
        $CreateBy = Auth::id();
        $createdate = date('Y-m-d H:i:s');

        $cc = array(
            'VNo'            =>  $voucher_no,
            'Vtype'          =>  $Vtype,
            'VDate'          =>  $VDate,
            'COAID'          =>  1020101,
            'Narration'      =>  'Cash Adjustment ',
            'Debit'          =>  $debit,
            'Credit'         =>  $credit,
            'IsPosted'       =>  1,
            'CreateBy'       =>  $CreateBy,
            'CreateDate'     =>  $createdate,
            'IsAppove'       =>  1
        );
        DB::table('acc_transaction')->insert($cc);
        return true;
    }

    public static  function bankbook_firstqury($FromDate, $HeadCode)
    {

        $sql = "SELECT SUM(Debit) Debit, SUM(Credit) Credit, IsAppove, COAID FROM acc_transaction
              WHERE VDate < '$FromDate 00:00:00' AND COAID = '$HeadCode' AND IsAppove =1 GROUP BY IsAppove, COAID";
        return  $sql;
    }

    public static  function bankbook_secondqury($FromDate, $HeadCode, $ToDate)
    {
        $sql = "SELECT acc_transaction.VNo, acc_transaction.Vtype, acc_transaction.VDate, acc_transaction.Debit, acc_transaction.Credit, acc_transaction.IsAppove, acc_transaction.COAID, acc_coa.HeadName, acc_coa.PHeadName, acc_coa.HeadType, acc_transaction.Narration 
     FROM acc_transaction INNER JOIN acc_coa ON acc_transaction.COAID = acc_coa.HeadCode
         WHERE acc_transaction.IsAppove =1 AND VDate BETWEEN '$FromDate 00:00:00' AND '$ToDate 00:00:00' AND acc_transaction.COAID='$HeadCode' ORDER BY  acc_transaction.VDate, acc_transaction.VNo";

        return $sql;
    }
    public static  function fixed_assets()
    {

        $data =  DB::table('acc_coa')->select('*')
            ->where('PHeadName', 'Assets')
            ->get();
        return  $data->map(function ($obj) {
            return (array) $obj;
        })->toArray();
    }
    public static  function liabilities_data()
    {
        $data = DB::table('acc_coa')->select('*')
            ->where('PHeadName', 'Liabilities')
            ->get();
        return  $data->map(function ($obj) {
            return (array) $obj;
        })->toArray();
    }
    public static  function income_fields()
    {
        $data =  DB::table('acc_coa')->select('*')
            ->where('PHeadName', 'Income')
            ->get();
        return  $data->map(function ($obj) {
            return (array) $obj;
        })->toArray();
    }
    public static  function expense_fields()
    {
        $data =  DB::table('acc_coa')->select('*')
            ->from('acc_coa')
            ->where('PHeadName', 'Expence')
            ->get();
        return  $data->map(function ($obj) {
            return (array) $obj;
        })->toArray();
    }
    public static  function assets_info($head_name)
    {
        $data =  DB::table('acc_coa')->select("*")
            ->where('PHeadName', $head_name)
            ->groupBy('HeadCode')
            ->get();
        return  $data->map(function ($obj) {
            return (array) $obj;
        })->toArray();
    }

    public static  function asset_childs($head_name, $from_date, $to_date)
    {
        $data =  DB::table('acc_coa')->select("*")
            ->where('PHeadName', $head_name)
            ->groupBy('HeadCode')
            ->get();
        return  $data->map(function ($obj) {
            return (array) $obj;
        })->toArray();
    }

    public static  function assets_balance($head_code, $from_date, $to_date)
    {
        //   $data = DB::table('acc_transaction')->select("(sum(Debit)-sum(Credit)) as balance")
        //     ->where('COAID', $head_code)
        //     ->where('VDate >=', $from_date)
        //     ->where('VDate <=', $to_date)
        //     ->where('IsAppove', 1)
        //     ->get();
        $result =  DB::select("SELECT (sum(Debit)-sum(Credit)) as balance FROM `acc_transaction` WHERE `COAID` = ' .$head_code. ' AND `VDate` >= ' .$from_date. ' AND `VDate` <= ' .$to_date. ' AND `IsAppove` = 1 ");
        return $result = array_map(function ($value) {
            return (array)$value;
        }, $result);
        // return  $data->map(function($obj){
        //     return (array) $obj;
        //   })->toArray();

    }
    public static  function liabilities_info($head_name)
    {

        $data =  DB::table('acc_coa')->select("*")
            ->where('PHeadName', $head_name)
            ->get();
        return  $data->map(function ($obj) {
            return (array) $obj;
        })->toArray();
    }
    public static  function liabilities_balance($head_code, $from_date, $to_date)
    {
        $result =  DB::select("SELECT (sum(Credit)-sum(Debit)) as balance FROM `acc_transaction` WHERE `COAID` = ' .$head_code. ' AND `VDate` >= ' .$from_date. ' AND `VDate` <= ' .$to_date. ' AND `IsAppove` = 1 ");
        return $result = array_map(function ($value) {
            return (array)$value;
        }, $result);
    }
    public static  function income_balance($head_code, $from_date, $to_date)
    {
        $result =  DB::select("SELECT (sum(Debit)-sum(Credit)),COAID as balance  FROM `acc_transaction` WHERE `COAID` = ' .$head_code. ' AND `VDate` >= ' .$from_date. ' AND `VDate` <= ' .$to_date. ' AND `IsAppove` = 1 ");

        return $result = array_map(function ($value) {
            return (array)$value;
        }, $result);
        // return  $records =  DB::table('acc_transaction')->select("(sum(Debit)-sum(Credit)) as balance,COAID")
        //     ->where('COAID', $head_code)
        //     ->where('VDate >=', $from_date)
        //     ->where('VDate <=', $to_date)
        //     ->where('IsAppove', 1)
        //     ->get();
    }
}
