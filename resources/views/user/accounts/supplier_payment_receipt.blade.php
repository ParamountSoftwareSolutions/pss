@extends('user.layout.app')
@section('title', 'Leads')
@section('style')


<!-- use Illuminate\Support\Facades\Auth; -->

@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <!-- Printable area start -->

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="panel panel-bd">
                                <div id="printableArea">
                                    <div class="panel-body">
                                        <div bgcolor='#e4e4e4' text='#ff6633' link='#666666' vlink='#666666' alink='#ff6633' class="supplier_payment_receipt_f_family">
                                            <table border="0" width="100%">
                                                <tr>
                                                    <td>

                                                        <table border="0" width="100%">

                                                            <tr>
                                                                <td align="center" class="supplier_payment_receipt_td">

                                                                    <span class="supplier_payment_receipt_f_17">
                                                                        <?php

use Illuminate\Support\Facades\Auth;

 echo $data['company_info']->storename; ?>
                                                                    </span><br>
                                                                    <?php echo $data['company_info']->address; ?><br>
                                                                    <?php echo $data['company_info']->phone; ?><br>


                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td align="center"><?php echo $data['supplier_info']->supName; ?><br>
                                                                    <?php if ($data['supplier_info']->supAddress) { ?>
                                                                        <?php echo $data['supplier_info']->supAddress; ?><br>
                                                                    <?php } ?>
                                                                    <?php if ($data['supplier_info']->supMobile) { ?>
                                                                        <?php echo $data['supplier_info']->supMobile; ?>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center">
                                                                    <nobr>
                                                                        <date>
                                                                            <?php echo display('date') ?>: <?php echo $data['payment_info']->VDate; ?>
                                                                        </date>
                                                                    </nobr>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left"><?php echo display('voucher_no'); ?> : <?php echo $data['payment_info']->VNo ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left"><?php echo display('payment_type'); ?> : <?php echo  'Payment'; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left"><?php echo display('amount'); ?> : <?php echo $data['payment_info']->Debit; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left"><?php echo display('remark'); ?> : <?php echo $data['payment_info']->Narration; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                <tr>

                                                    <td> <?php echo display('paid_by') ?>: <?php echo Auth::id(); ?>

                                                        <div class="supplier_payment_receipt_f_tp">
                                                            <?php echo display('signature') ?>

                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Powered By: <a href="#"><?php echo $data['company_info']->storename; ?></a></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-left">
                                    <a class="btn btn-danger" href="<?php echo route('accounts.supplier_payments'); ?>"><?php echo display('cancel') ?></a>
                                    <a class="btn btn-info" href="#" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></a>
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
<script src="<?php echo url('application/modules/accounts/assets/js/supplier_payment_receipt_script.js'); ?>" type="text/javascript"></script>
<script>

</script>
@endsection