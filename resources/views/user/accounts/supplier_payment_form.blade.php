@extends('user.layout.app')
@section('title', 'Leads')
@section('style')
<link href="<?php echo asset('accounts/assets/css/treeview.css') ?>" rel="stylesheet" type="text/css" />
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
                                            <?php echo display('supplier_payment'); ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="{{route('accounts.create_supplier_payment')}}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="vo_no" class="col-sm-2 col-form-label"><?php echo display('voucher_no') ?></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="txtVNo" id="txtVNo" value="<?php if (!empty($voucher_no->voucher)) {
                                                                                                        $vn = substr($voucher_no->voucher, 3) + 1;
                                                                                                        echo $voucher_n = 'PM-' . $vn;
                                                                                                    } else {
                                                                                                        echo $voucher_n = 'PM-1';
                                                                                                    } ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="adress" class="col-sm-2 col-form-label"><?php echo display('ptype') ?></label>
                                            <div class="col-sm-4">
                                                <select name="paytype" class="form-control" required="" onchange="bank_paymet(this.value)">
                                                    <option>Select Option</option>
                                                    <option value="1"><?php echo display('casp') ?></option>
                                                    <option value="2"><?php echo display('bnkp') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row supplier_payment_form_dnone" id="showbank">
                                            <label for="adress" class="col-sm-2 col-form-label"><?php echo display('slbank') ?></label>
                                            <div class="col-sm-4">
                                                <select name="bank" id="bankid" class="form-control supplier_payment_form_w_100">
                                                    <option value=""><?php echo display('slbank') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-2 col-form-label"><?php echo display('date') ?></label>
                                            <div class="col-sm-4">
                                                <input type="text" name="dtpDate" id="dtpDate" class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="txtRemarks" class="col-sm-2 col-form-label"><?php echo display('remark') ?></label>
                                            <div class="col-sm-4">
                                                <textarea name="txtRemarks" id="txtRemarks" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="table-responsive supplier_payment_form_mr_t">
                                            <table class="table table-bordered table-hover" id="debtAccVoucher">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><?php echo display('supplier_name') ?></th>
                                                        <th class="text-center"><?php echo display('code') ?></th>
                                                        <th class="text-center"><?php echo display('amount') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="debitvoucher">
                                                    <tr>
                                                        <td class="supplier_payment_form_mr_w_200px">
                                                            <select name="supplier_id" id="supplier_id_1" class="form-control" onchange="load_code(this.value,1)" required>
                                                                <option value=""><?php echo display('slsuplier') ?></option>
                                                                <?php foreach ($data['supplier_list'] as $suplier) { ?>
                                                                    <option value="<?php echo $suplier->supid; ?>"><?php echo $suplier->supName; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="txtCode" value="" class="form-control " id="txtCode_1" readonly=""></td>
                                                        <td><input type="number" name="txtAmount" value="" class="form-control total_price text-right" id="txtAmount_1" onkeyup="calculation(1)" required>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>

                                                        </td>
                                                        <td colspan="1" class="text-right"><label for="reason" class="  col-form-label"><?php echo display('total') ?></label>
                                                        </td>
                                                        <td class="text-right">
                                                            <input type="text" id="grandTotal" class="form-control text-right " name="grand_total" value="" readonly="readonly" />
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
                        <?php foreach ($data['supplier_list'] as $suplier) { ?><option value='<?php echo $suplier->supid; ?>'><?php echo $suplier->supName; ?></option><?php } ?>
                    </div>
                </div>
            </div>
    </section>
</div>
@endsection
@section('script')
<script>
    "use strict";

    function load_code(id, sl) {
        // var csrf = $('#csrfhashresarvation').val();
        var baseurl = "{{url('/')}}";

        $.ajax({
            url: baseurl + '/accounts/supplier_headcode/' + id,
            type: "GET",
            dataType: "json",
            // data: {
            //     csrf_test_name: $('meta[name="csrf-token"]').attr('content')
            // },
            success: function(data) {

                $('#txtCode_' + sl).val(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(lang.errorajdata);
            }
        });
    }

    function addaccount(divName) {
        var supplier = $('#cntra').html();
        var row = $("#debtAccVoucher tbody tr").length;
        var count = row + 1;
        var limits = 500;
        var tabin = 0;
        if (count == limits) alert("'" + lang.total + "'" + count + "'" + lang.inpt + "'");
        else {
            var newdiv = document.createElement('tr');
            var tabin = "cmbCode_" + count;
            var tabindex = count * 2;
            newdiv = document.createElement("tr");

            newdiv.innerHTML = "<td> <select name='supplier_id[]' id='supplier_id_" + count + "' class='form-control' onchange='load_code(this.value," + count + ")' required><option value=''>'" + lang.slsuplier + "'</option>" + supplier + "</select></td><td><input type='text' name='txtCode[]' class='form-control'  id='txtCode_" + count + "' ></td><td><input type='number' name='txtAmount[]' class='form-control total_price text-right' id='txtAmount_" + count + "' onkeyup='calculation(" + count + ")' required></td><td><button class='btn btn-danger red text-right' type='button' value='" + lang.delete + "' onclick='supplierdeleteRow(this)'><i class='fa fa-trash-o'></i></button></td>";
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

        $("#grandTotal").val(gr_tot.toFixed(2, 2));
    }

    function supplierdeleteRow(e) {
        var t = $("#debtAccVoucher > tbody > tr").length;
        if (1 == t) alert(lang.cantdel);
        else {
            var a = e.parentNode.parentNode;
            a.parentNode.removeChild(a)
        }
        calculation()
    }

    function bank_paymet(id) {
        var csrf = $('#csrfhashresarvation').val();
        var dataString = 'bankid=' + id + '&csrf_test_name=' + csrf;
        if (id == 2) {
            $("#showbank").show();
            $('#bankid').attr('required', true);
            var baseurl = "{{url('/')}}";
            $.ajax({
                url: baseurl + "/accounts/banklist",
                dataType: 'json',
                type: "POST",
                data: dataString,
                async: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var options = data.map(function(val, ind) {
                        return $("<option></option>").val(val.bankid).html(val.bank_name);
                    });
                    $('#bankid').append(options);
                }

            });
        } else {
            $("#showbank").hide();
            $('#bankid').attr('required', false);
        }
    }


    $(function() {
        "use strict";
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

    });
</script>
@endsection