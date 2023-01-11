
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
                                <div class="panel-body" id="printArea">
                                    <tr align="center">
                                        <td id="ReportName" class="vouchar_cash_tobody"><b><?php echo display('cscrv') ?></b></td>
                                    </tr>
                                    <div class="">
                                        <table class="datatable2 table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td width="7%" height="25"><strong><?php echo display('sl') ?></strong></td>
                                                    <td width="15%" align="center"><strong><?php echo display('ac_code') ?></strong></td>
                                                    <td width="48%" align="center"><strong><?php echo display('ac_head') ?></strong></td>
                                                    <td width="15%" align="right"><strong><?php echo display('credit') ?></strong></td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $TotalCredit = 0;
                                                foreach ($vouchar_view as $v_data) {
                                                ?>
                                                    <tr>
                                                        <td height="25">1</td>
                                                        <td><?php echo $v_data->COAID; ?></td>
                                                        <td><?php echo $v_data->HeadName; ?></td>
                                                        <td align="right"><?php
                                                                            $Amount = $v_data->Amount;
                                                                            $TotalCredit += $Amount;
                                                                            printf("%.2f", $Amount); ?></td>

                                                    </tr>
                                                <?php
                                                }
                                                ?>

                                                <tr class="table_data">
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td align="right"><strong><?php echo display('total') ?></strong></td>
                                                    <td align="right"><strong><?php printf("%.2f", $TotalCredit); ?></strong></td>
                                                </tr>

                                                <tr class="table_data">
                                                    <td height="45" valign="top" class="rptInWords" align="right"><?php echo display('iword') ?> :</td>
                                                    <td colspan="3" valign="top">
                                                        <?php
                                                        $Amount = number_format($TotalCredit, 2, '.', '');
                                                        $data = new CCommon();
                                                        echo ucwords($data->NumberToWord($Amount)) . " Only.";

                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">&nbsp;</td>
                                                    <td valign="top">&nbsp;</td>
                                                    <td align="right" valign="top">&nbsp;</td>
                                                    <td align="right" valign="top">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">&nbsp;</td>
                                                    <td valign="top"><?php echo display('ac_office') ?></td>
                                                    <td align="right" valign="top">&nbsp;</td>
                                                    <td align="right" valign="top">Print Date: <?php echo date("Y-m-d"); ?></td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <div class="text-center vouchar_cash__btn" id="print">
                                            <input type="button" class="btn btn-warning" name="btnPrint" id="btnPrint" value="Print" onclick="printDiv();" />
                                        </div>

                                    </div>
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
</script>
@endsection