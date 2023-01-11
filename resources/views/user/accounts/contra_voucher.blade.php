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
                      <?php echo display('contra_voucher') ?>
                    </h4>
                  </div>
                </div>
                <div class="panel-body">
                  <form method="POST" action="{{route('accounts.create_contra_voucher')}}">
                    @csrf
                    <!-- form_open_multipart('accounts/accounts/create_contra_voucher')  -->
                    <div class="form-group row">
                      <label for="vo_no" class="col-sm-2 col-form-label"> <?php echo display('voucher_no') ?></label>
                      <div class="col-sm-4">
                        <input type="text" name="txtVNo" id="txtVNo" value="<?php if (!empty($data['voucher_no']->VNo)) {
                                                                              $vn = substr($data['voucher_no']->VNo, 7) + 1;
                                                                              echo $voucher_n = 'Contra-' . $vn;
                                                                            } else {
                                                                              echo $voucher_n = 'Contra-1';
                                                                            } ?>" class="form-control" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="date" class="col-sm-2 col-form-label"> <?php echo display('date') ?></label>
                      <div class="col-sm-4">
                        <input type="text" name="dtpDate" id="dtpDate" class="form-control datepicker" value="<?php echo  date('Y-m-d') ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="txtRemarks" class="col-sm-2 col-form-label"> <?php echo display('remark') ?></label>
                      <div class="col-sm-4">
                        <textarea name="txtRemarks" id="txtRemarks" class="form-control"></textarea>
                      </div>
                    </div>
                    <div class="table-responsive contra_voucher_mr_t">
                      <table class="table table-bordered table-hover" id="debtAccVoucher">
                        <thead>
                          <tr>
                            <th class="text-center"> <?php echo display('account_name') ?></th>
                            <th class="text-center"> Remarks</th>
                            <th class="text-center"> <?php echo display('code') ?></th>
                            
                            <th class="text-center"> <?php echo display('debit') ?></th>
                            <th class="text-center"> <?php echo display('credit') ?></th>
                            <th class="text-center"> <?php echo display('action') ?></th>
                          </tr>
                        </thead>
                        <tbody id="debitvoucher">

                          <tr>
                            <td class="contra_voucher_w_200">
                              <select name="cmbCode[]" id="cmbCode_1" class="form-control" onchange="load_code(this.value,1)">
                                <?php foreach ($data['acc'] as $acc1) { ?>
                                  <option value="<?php echo $acc1->HeadCode; ?>"><?php echo $acc1->HeadName; ?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td><input type='text' name='remark[]' class='form-control'  id='remark" + count + "' ></td>
                            <td><input type="text" name="txtCode[]" class="form-control " id="txtCode_1"></td>
                            <td><input type="text" name="txtAmount[]" value="0" class="form-control total_price" id="txtAmount_1" onkeyup="calculation(1)">
                            </td>
                            <td><input type="text" name="txtAmountcr[]" value="0" class="form-control total_price1" id="txtAmount1_1" onkeyup="calculation(1)">
                            </td>
                            <td>
                              <button class="btn btn-danger red contra_voucher_btn_right" type="button" value="<?php echo display('delete') ?>" onclick="contradeleteRow(this)"><i class="fa fa-trash-o"></i></button>
                            </td>
                          </tr>

                        </tbody>
                        <tfoot>
                          <tr>
                            <td>
                              <input type="button" id="add_more" class="btn btn-info" name="add_more" onClick="addaccount('debitvoucher');" value="<?php echo display('add_more') ?>" />
                            </td>
                            <td colspan="1" class="text-right"><label for="reason" class="  col-form-label"><?php echo display('total') ?></label>
                            </td>
                            <td class="text-right">
                              <input type="text" id="grandTotal" class="form-control text-right " name="grand_total" readonly="readonly" value="0" />
                            </td>
                            <td class="text-right">
                              <input type="text" id="grandTotal1" class="form-control text-right " name="grand_total1" readonly="readonly" value="0" />
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="form-group row">

                      <div class="col-sm-12 text-right">
                        <input type="submit" id="add_receive" class="btn btn-success btn-large" name="save" value="<?php echo display('save') ?>" tabindex="9" />

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
  </section>
</div>
@endsection
@section('script')
@section('script')
<script>
    var allowSubmit = false;
    document.querySelector('#add_receive').addEventListener('click', function(event) {

        var grandTotal = $('#grandTotal').val();
        var grandTotal1 = $('#grandTotal1').val();


        if (grandTotal == grandTotal1) {
            return true;
        }
        alert('Your Total Value Is Not Equal');
        event.preventDefault();
        return false;
    });
</script>
<script>
  "use strict";

  function load_code(id, sl) {
    var baseurl = "{{url('/')}}";
    $.ajax({
      url: baseurl + '/accounts/debtvouchercode/' + id,
      type: "GET",
      dataType: "json",
      // data: {
      //   csrf_test_name: csrf
      // },
      success: function(data) {

        $('#txtCode_' + sl).val(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(errorajdata);
      }
    });
  }

  function addaccount(divName) {
    var cntra = $('#cntra').html();
    var row = $("#debtAccVoucher tbody tr").length;
    var count = row + 1;
    var limits = 500;
    var tabin = 0;
    if (count == limits) alert("'" + total + "'" + count + "'" + inpt + "'");
    else {
      var newdiv = document.createElement('tr');
      var tabin = "cmbCode_" + count;
      var tabindex = count * 2;
      newdiv = document.createElement("tr");

      newdiv.innerHTML = "<td> <select name='cmbCode[]' id='cmbCode_" + count + "' class='form-control' onchange='load_code(this.value," + count + ")'>" + cntra + "</select></td><input type='text' name='remark[]' class='form-control'  id='remark" + count + "' ><td><input type='text' name='txtCode[]' class='form-control'  id='txtCode_" + count + "' ></td><td><input type='text' name='txtAmount[]' class='form-control total_price' value='0' id='txtAmount_" + count + "' onkeyup='calculation(" + count + ")'></td><td><input type='text' name='txtAmountcr[]' class='form-control total_price1' id='txtAmount1_" + count + "' value='0' onkeyup='calculation(" + count + ")'></td><td><button class='text-right btn btn-danger red' type='button' onclick='contradeleteRow(this)'><i class='fa fa-trash-o'></i></button></td>";
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
    var gr_tot1 = 0;
    var gr_tot = 0;
    $(".total_price").each(function() {
      isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
    });

    $(".total_price1").each(function() {
      isNaN(this.value) || 0 == this.value.length || (gr_tot1 += parseFloat(this.value))
    });
    $("#grandTotal").val(gr_tot.toFixed(2, 2));
    $("#grandTotal1").val(gr_tot1.toFixed(2, 2));
  }

  function contradeleteRow(e) {
    var t = $("#debtAccVoucher > tbody > tr").length;
    if (1 == t) alert(cantdel);
    else {
      var a = e.parentNode.parentNode;
      a.parentNode.removeChild(a)
    }
    calculation()
  }



  $(function() {
    "use strict";
    $(".datepicker").datepicker({
      dateFormat: 'yy-mm-dd'
    });

  });
</script>
@endsection