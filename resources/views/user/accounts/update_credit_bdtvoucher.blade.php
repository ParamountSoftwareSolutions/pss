@extends('user.layout.app')
@section('title', 'Leads')
@section('style')

@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <h4>
                                            <?php echo display('update_credit_voucher') ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="{{route('accounts.update_credit_voucher')}}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="vo_no" class="col-sm-2 col-form-label"><?php echo display('voucher_no') ?></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="txtVNo" id="txtVNo" value="<?php echo $data['debit_info']->VNo; ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="ac" class="col-sm-2 col-form-label"><?php echo display('debit_account_head') ?></label>
                                            <div class="col-sm-4">
                                                <select name="cmbDebit" id="cmbDebit" class="form-control">
                                                    <option value='1020101'><?php echo display('cash_in_hand') ?></option>
                                                    <?php foreach ($data['crcc'] as $cracc) { ?>
                                                        <option value="<?php echo $cracc->HeadCode ?>" <?php if ($data['debit_info']->COAID == $cracc->HeadCode) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?php echo $cracc->HeadName ?></option>
                                                    <?php  } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-2 col-form-label">Date</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="dtpDate" id="dtpDate" class="form-control datepicker" value="<?php echo $data['debit_info']->VDate; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="txtRemarks" class="col-sm-2 col-form-label"><?php echo display('remark') ?></label>
                                            <div class="col-sm-4">
                                                <textarea name="txtRemarks" id="txtRemarks" class="form-control"><?php echo $data['debit_info']->Narration; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="table-responsive update_credit_bdtvoucher_mr_tp">
                                            <table class="table table-bordered table-hover" id="debtAccVoucher">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo display('account_name') ?></th>
                                                        <th class="text-center"><?php echo display('code') ?></th>
                                                        <th class="text-center"><?php echo display('amount') ?></th>
                                                        <th class="text-center"><?php echo display('action') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="debitvoucher">
                                                    <?php
                                                    $sl = 1;
                                                    foreach ($data['crvoucher_info'] as $upcrvoucher) { ?>

                                                        <tr>
                                                            <td class="update_credit_bdtvoucher_w_200">
                                                                <select name="cmbCode[]" id="cmbCode_<?php echo $sl; ?>" class="form-control" onchange="load_code(this.value,<?php echo $sl; ?>)">
                                                                    <?php foreach ($data['acc'] as $acc1) { ?>
                                                                        <option value="<?php echo $acc1->HeadCode; ?>" <?php if ($upcrvoucher->COAID == $acc1->HeadCode) {
                                                                                                                            echo 'selected';
                                                                                                                        } ?>><?php echo $acc1->HeadName; ?></option>
                                                                    <?php } ?>
                                                                </select>

                                                            </td>
                                                            <td><input type="text" name="txtCode[]" value="<?php echo $upcrvoucher->COAID ?>" class="form-control " id="txtCode_<?php echo $sl; ?>"></td>
                                                            <td><input type="text" name="txtAmount[]" value="<?php echo $upcrvoucher->Credit ?>" class="form-control total_price" id="txtAmount_<?php echo $sl; ?>" onkeyup="calculation(<?php echo $sl; ?>)">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger red update_credit_bdtvoucher_btn" type="button" value="<?php echo display('delete') ?>" onclick="ucreditdeleteRow(this)"><i class="fa fa-trash-o"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php $sl++;
                                                    } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>
                                                            <input type="button" id="add_more" class="btn btn-info" name="add_more" onClick="addaccount('debitvoucher');" value="<?php echo display('add_more') ?>" />
                                                        </td>
                                                        <td colspan="1" class="text-right"><label for="reason" class="  col-form-label"><?php echo display('total') ?></label>
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="text" id="grandTotal" class="form-control text-right " name="grand_total" value="<?php echo $data['debit_info']->Debit; ?>" readonly="readonly" />
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-sm-12 text-right">

                                                <input type="submit" id="add_receive" class="btn btn-success btn-large" name="save" value="<?php echo display('update') ?>" tabindex="9" />

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="cntra" hidden>
                        <?php foreach ($data['acc'] as $acc2) { ?><option value='<?php echo $acc2->HeadCode; ?>'><?php echo $acc2->HeadName; ?></option><?php } ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
 "use strict";
  function load_code(id,sl){
    var baseurl = "{{url('/')}}";
    $.ajax({
        url: baseurl + '/accounts/debtvouchercode/' + id,
        type: "GET",
        dataType: "json",
		// data:{csrf_test_name:csrf},
        success: function(data)
        {
          
           $('#txtCode_'+sl).val(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert(lang.errorajdata);
        }
    });
}
    function addaccount(divName){
    var credit = $("#cntra").html();
    var row = $("#debtAccVoucher tbody tr").length;
    var count = row + 1;
    var limits = 500;
    var tabin = 0;
    if (count == limits) alert("'"+lang.total+"'" + count + "'"+lang.inpt+"'");
    else {
          var newdiv = document.createElement('tr');
          var tabin="cmbCode_"+count;
          var tabindex = count * 2;
          newdiv = document.createElement("tr");
           
          newdiv.innerHTML ="<td> <select name='cmbCode[]' id='cmbCode_"+ count +"' class='form-control' onchange='load_code(this.value,"+ count +")'>"+credit+"</select></td><td><input type='text' name='txtCode[]' class='form-control'  id='txtCode_"+ count +"' ></td><td><input type='text' name='txtAmount[]' class='form-control total_price' id='txtAmount_"+ count +"' onkeyup='calculation("+ count +")'></td><td><button  class='btn btn-danger red text-right' type='button' value='"+delete+"' onclick='ucreditdeleteRow(this)'><i class='fa fa-trash-o'></i>-</button></td>";
          document.getElementById(divName).appendChild(newdiv);
          document.getElementById(tabin).focus();
          count++;
           
          $("select.form-control:not(.dont-select-me)").select2({
              placeholder: "Select option",
              allowClear: true
          });
        }
    }

function calculation(sl) {
       
        var gr_tot = 0;
        $(".total_price").each(function() {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });

        $("#grandTotal").val(gr_tot.toFixed(2,2));
    }

    function ucreditdeleteRow(e) {
        var t = $("#debtAccVoucher > tbody > tr").length;
        if (1 == t) alert(lang.cantdel);
        else {
            var a = e.parentNode.parentNode;
            a.parentNode.removeChild(a)
        }
        calculation()
    }


    
     $(function(){
     	"use strict";
        $(".datepicker").datepicker({ dateFormat:'yy-mm-dd' });
       
    });
</script>
@endsection