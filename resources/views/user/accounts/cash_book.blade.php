<?php
// @include('accountsClass/CConManager.php');
// @include('accountsClass/Ccommon.php');
// @include('accountsClass/CResult.php');
// @include('accountsClass/CAccount.php');

// include('Class/CConManager.php');
// include('Class/Ccommon.php');
// include('Class/CResult.php');
// include('Class/CAccount.php');
?>
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
                                            <?php echo display('cash_book') ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form method="POST" name="form1" id="form1" action="{{route('accounts.cash_book')}}">
                                    @csrf    
                                    <!-- form_open('','method="post" name="form1" id="form1"')?> -->
                                        <div class="row" id="">
                                            <div class="col-sm-6">
                                                <input type="hidden" id="txtCode" name="txtCode" value="1020101" />
                                                <input type="hidden" id="txtName" name="txtName" size="40" value="Cash In Hand" />
                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('from_date') ?></label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="dtpFromDate" value="" placeholder="<?php echo display('date') ?>" class="datepicker form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('to_date') ?></label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="dtpToDate" value="" placeholder="<?php echo display('date') ?>" class="datepicker form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group text-right">
                                                    <button type="submit" name="btnSave" class="btn btn-success w-md m-b-5"><?php echo display('find') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="panel-body" id="printArea">
                                        <tr align="center">
                                            <td id="ReportName" class="cash_book_reportname"><b><?php echo display('cash_book_voucher') ?></b></td>
                                        </tr>
                                        <div>

                                            <table width="100%" class="table_boxnew cash_book_lineheight" cellpadding="6" cellspacing="1">
                                                <tr>
                                                <tr align="center">
                                                    <td colspan="7">
                                                        <font size="+1" class="cash_book_family"> <strong><?php echo display('cash_book_report_on') ?> <?php echo $FromDate; ?> <?php echo display('to') ?> <?php echo $ToDate; ?></strong></font><strong>
                                                            </th>
                                                        </strong>
                                                </tr>
                                                <tr align="left">
                                                    <td colspan="8">
                                                        <font class="cash_book_family">&nbsp;&nbsp;</font>
                                                    </td>
                                                </tr>
                                                <tr class="table_data">
                                                    <td width="3%">&nbsp;</td>
                                                    <td width="10%">&nbsp;</td>
                                                    <td width="14%">&nbsp;</td>
                                                    <td width="5%">&nbsp;</td>
                                                    <td width="35%">&nbsp;</td>
                                                    <td colspan="2" align="right"><strong><?php echo display('opening_balance') ?></strong></td>
                                                    <td width="11%" align="right"><?php echo number_format($PreBalance, 2, '.', ','); ?></td>
                                                </tr>
                                                <tr class="table_head">
                                                    <td height="25"><strong><?php echo display('sl') ?></strong></td>
                                                    <td align="center"><strong><?php echo display('transaction_date') ?></strong></td>
                                                    <td align="center"><strong><?php echo display('voucher_no') ?></strong></td>
                                                    <td align="center"><strong><?php echo display('voucher_type') ?></strong></td>
                                                    <td align="center"><strong><?php echo display('particulars') ?></strong></td>
                                                    <td width="11%" align="right"><strong><?php echo display('debit') ?></strong></td>
                                                    <td width="11%" align="right"><strong><?php echo display('credit') ?></strong></td>
                                                    <td align="right"><strong><?php echo display('balance') ?></strong></td>
                                                </tr>
                                                <?php
                                                $TotalCredit = 0;
                                                $TotalDebit = 0;
                                                $VNo = "";
                                                $CountingNo = 1;
                                                if (empty($oResult)) {
                                                } else {
                                                    for ($i = 0; $i < $oResult->num_rows; $i++) {
                                                        if ($i & 1)
                                                            $bg = "#F8F8F8";
                                                        else
                                                            $bg = "#FFFFFF";
                                                ?>
                                                        <tr class="table_data">
                                                            <?php
                                                            if ($VNo != $oResult->rows[$i]['VNo']) {
                                                            ?>
                                                                <td height="25" bgcolor="<?php echo $bg; ?>"><?php echo $CountingNo++; ?></td>
                                                                <td bgcolor="<?php echo $bg; ?>"><?php echo substr($oResult->rows[$i]['VDate'], 0, 10); ?></td>
                                                                <td align="left" bgcolor="<?php echo $bg; ?>"><?php
                                                                                                                if ($oResult->rows[$i]['Vtype'] == "MR")
                                                                                                                    echo "<a href=\"?Acc=MoneyRecept&VNo=" . base64_encode($oResult->rows[$i]['VNo']) . "\" target='_blank'><img src='ic/page.png' alt='Money Receipt Reprint' title='Money Receipt Reprint'></a> &nbsp;";
                                                                                                                else if ($oResult->rows[$i]['Vtype'] == "AVR") {
                                                                                                                    $sql = "SELECT * FROM advising_register WHERE VNo='" . $oResult->rows[$i]['VNo'] . "'";
                                                                                                                    $oResultRegi = $oAccount->SqlQuery($sql);
                                                                                                                } else if ($oResult->rows[$i]['Vtype'] == "AD") {
                                                                                                                }

                                                                                                                echo $oResult->rows[$i]['VNo'];
                                                                                                                ?></td>
                                                                <td align="justify" bgcolor="<?php echo $bg; ?>"><?php echo $oResult->rows[$i]['Vtype'];
                                                                                                                    ?>


                                                                </td>

                                                            <?php
                                                                $VNo = $oResult->rows[$i]['VNo'];
                                                            } else {
                                                            ?>
                                                                <td bgcolor="<?php echo $bg; ?>" colspan="4">&nbsp;</td>
                                                            <?php
                                                            }
                                                            ?>
                                                            <td align="justify" bgcolor="<?php echo $bg; ?>"><?php echo $oResult->rows[$i]['HeadName']; ?></td>
                                                            <td align="right" bgcolor="<?php echo $bg; ?>"><?php
                                                                                                            $TotalDebit += $oResult->rows[$i]['Debit'];
                                                                                                            $PreBalance += $oResult->rows[$i]['Debit'];
                                                                                                            echo number_format($oResult->rows[$i]['Debit'], 2, '.', ','); ?></td>
                                                            <td align="right" bgcolor="<?php echo $bg; ?>"><?php
                                                                                                            $TotalCredit += $oResult->rows[$i]['Credit'];
                                                                                                            $PreBalance -= $oResult->rows[$i]['Credit'];
                                                                                                            echo number_format($oResult->rows[$i]['Credit'], 2, '.', ','); ?></td>
                                                            <td align="right" bgcolor="<?php echo $bg; ?>"><?php echo number_format($PreBalance, 2, '.', ','); ?></td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <tr class="table_data cash_book_table_data_color">
                                                    <td bgcolor="green">&nbsp;</td>
                                                    <td align="center" bgcolor="green">&nbsp;</td>
                                                    <td align="center" bgcolor="green">&nbsp;</td>
                                                    <td align="center" bgcolor="green">&nbsp;</td>
                                                    <td align="right" bgcolor="green"><strong><?php echo display('total') ?></strong></td>
                                                    <td align="right" bgcolor="green"><?php echo number_format($TotalDebit, 2, '.', ','); ?></td>
                                                    <td align="right" bgcolor="green"><?php echo number_format($TotalCredit, 2, '.', ','); ?></td>
                                                    <td align="right" bgcolor="green"><?php echo number_format($PreBalance, 2, '.', ','); ?></td>
                                                </tr>

                                            </table>


                                        </div>

                                    </div>
                                    <div class="text-center cash_book_btn_color" id="print">
                                        <input type="button" class="btn btn-warning" name="btnPrint" id="btnPrint" value="Print" onclick="printDiv();" />
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