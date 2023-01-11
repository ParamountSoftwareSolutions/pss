<script src="<?php echo url('application/modules/accounts/assets/js/general_ledger_report_script.js'); ?>" type="text/javascript"></script>

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
                                            Voucher Report
                                        </h4>
                                    </div>
                                </div>
                                <div id="printArea">
                                    <table width="99%" align="center" class="general_ledger_report_tble" cellpadding="5" cellspacing="5" border="2">

                                        <thead>
                                            <tr align="center">

                                                <td colspan="7">
                                           

                                                    <font size="+1" class="general_ledger_report_fontfamily"> <strong><?php echo ((!empty($data['HeadName2'][0]->VNo)) ? $data['HeadName2'][0]->VNo : "") ?></font><strong></th><h6 class="text-right">Date : <?php echo  $data['HeadName2'][0]->CreateDate; ?></h6></strong>
                                            </tr>

                                            <tr>
                                                <td height="25"><strong><?php echo display('sl'); ?></strong></td>
                                                <td><strong><?php echo "Head Code"; ?></strong></td>
                                                <td><strong><?php echo "Head Name"; ?></strong></td>
                                                <td><strong><?php echo "Remark"; ?></strong></td>
                                                <td><strong><?php echo "Date"; ?></strong></td>
                                                <td align="right"><strong><?php echo display('debit'); ?></strong></td>
                                                <td align="right"><strong><?php echo display('credit'); ?></strong></td>
                                                
                                              </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($error)) {
                                            ?>
                                                <tr>
                                                    <td height="25"></td>
                                                    <td></td>
                                                    <td><?php echo display('no_report') ?>.</td>
                                                   
                                                    <td align="right"></td>
                                                    <td align="right"></td>
                                                </tr>
                                                <?php
                                            } else {
                                              $TotalCredit = 0;
                                              $TotalDebit = 0;
                                              foreach ($data['HeadName2'] as $key => $val) {
                                              ?>
                                                  <tr>
                                                      <td height="25"><?php echo $key; ?></td>
                                                      <td><?php echo $val->COAID; ?></td>
                                                      <td><?php echo $val->HeadName; ?></td>
                                                      <td><?php echo $val->Narration; ?></td>
                                                      <td align="right"><?php echo $val->VDate; ?></td>
                                                      <td align="right"><?php echo $val->Debit; ?></td>
                                                      <td align="right"><?php echo $val->Credit; ?></td>
                                                      
                                                  </tr>
                                              <?php } ?>

                                     
                                    <?php
                                            }
                                    ?>
                                    </tbody>
                                    <h4>
                                    </h4>
                                    </table>
                                </div>
                                <div class="text-center general_ledger_report_btn" id="print">
                                    <input type="button" class="btn btn-warning" name="btnPrint" id="btnPrint" value="Print" onclick="printDiv();" />
                                </div>
                            </div>
                        </div>
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

    function printDiv() {
        var divName = "printArea";
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    $(function() {
        "use strict";
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

    });
</script>
@endsection