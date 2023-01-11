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
                    <h4><?php

use Illuminate\Support\Facades\DB;

 echo display('trial_balance') ?></h4>
                  </div>
                </div>
                <div id="printArea">
                  <div class="panel-body">
                    <table width="100%" class="table_boxnew" cellpadding="5" cellspacing="0">
                      <tr>
                        <td colspan="4" align="center">
                          <h3 class=" trial_balance_without_openingpxbtn_font_family"><?php echo display('trial_balance') ?><br />
                            <?php echo display('start_date'); ?> <?php echo $dtpFromDate; ?> <?php echo display('end_date'); ?> <?php echo $dtpToDate; ?></h3>
                        </td>
                      </tr>
                      <tr class="table_head">
                        <td width="20%" align="center" class="trial_balance_without_opening_tp"><strong><?php echo display('code') ?></strong></td>
                        <td width="50%" align="center" class="trial_balance_without_opening_tp"><strong><?php echo display('account_name') ?></strong></td>
                        <td width="15%" align="center" class="trial_balance_without_opening_tp"><strong><?php echo display('debit') ?></strong></td>
                        <td width="15%" align="center" class="trial_balance_without_opening_tp trial_balance_without_opening_tb_r"><strong><?php echo display('credit') ?></strong></td>
                      </tr>
                      <?php
                      $TotalCredit = 0;
                      $TotalDebit = 0;
                      $k = 0;
                    
                      for ($i = 0; $i < count($data['oResultTr']); $i++) {
                      
                        $COAID = $data['oResultTr'][$i]['HeadCode'];
                        $oResultTrial = DB::select(DB::raw("SELECT SUM(acc_transaction.Debit) AS Debit, SUM(acc_transaction.Credit) AS Credit FROM acc_transaction WHERE acc_transaction.IsAppove =1 AND VDate BETWEEN '" . $dtpFromDate . "' AND '" . $dtpToDate . "' AND COAID LIKE '$COAID%' "))[0];
                        // $q1 = $this->db->query($sql);
                        // $oResultTrial = $q1->row();
                        $bg = $k & 1 ? "#FFFFFF" : "#E7E0EE";
                        if ($oResultTrial->Credit + $oResultTrial->Debit > 0) {
                          $k++; ?>
                          <tr class="table_data">
                            <td align="left" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><a href="javascript:"><?php echo $data['oResultTr'][$i]['HeadCode']; ?>
                              </a>
                            </td>
                            <td align="left" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><?php echo $data['oResultTr'][$i]['HeadName']; ?></td>
                            <?php
                            if ($oResultTrial->Debit > $oResultTrial->Credit) {
                            ?>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><?php
                                                                                                                          $TotalDebit += $oResultTrial->Debit - $oResultTrial->Credit;
                                                                                                                          echo number_format($oResultTrial->Debit - $oResultTrial->Credit, 2);
                                                                                                                          ?></td>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_openingpxbtn__border"><?php
                                                                                                                                echo number_format('0.00', 2); ?></td>
                            <?php
                            } else {
                            ?>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><?php
                                                                                                                          echo number_format('0.00', 2);
                                                                                                                          ?></td>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_openingpxbtn__border"><?php
                                                                                                                                $TotalCredit += $oResultTrial->Credit - $oResultTrial->Debit;
                                                                                                                                echo number_format($oResultTrial->Credit - $oResultTrial->Debit, 2); ?></td>
                            <?php
                            }
                            ?>
                          </tr>
                        <?php
                        }
                      }

                      for ($i = 0; $i < count($data['oResultInEx']); $i++) {
                        $COAID = $data['oResultInEx'][$i]['HeadCode'];

                        $oResultTrial = DB::select(DB::raw("SELECT SUM(acc_transaction.Debit) AS Debit, SUM(acc_transaction.Credit) AS Credit FROM acc_transaction WHERE acc_transaction.IsAppove =1 AND VDate BETWEEN '" . $dtpFromDate . "' AND '" . $dtpToDate . "' AND COAID LIKE '$COAID%' "))[0];
                        // $q2 = $this->db->query($sql);
                        // $oResultTrial = $q2->row();

                        $bg = $k & 1 ? "#FFFFFF" : "#E7E0EE";
                        if ($oResultTrial->Credit + $oResultTrial->Debit > 0) {
                          $k++; ?>
                          <tr class="table_data">
                            <td align="left" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><a href="javascript:"><?php echo $data['oResultInEx'][$i]['HeadCode']; ?>
                              </a>
                            </td>
                            <td align="left" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><?php echo $data['oResultInEx'][$i]['HeadName']; ?></td>
                            <?php
                            if ($oResultTrial->Debit > $oResultTrial->Credit) {
                            ?>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><?php
                                                                                                                          $TotalDebit += $oResultTrial->Debit - $oResultTrial->Credit;
                                                                                                                          echo number_format($oResultTrial->Debit - $oResultTrial->Credit, 2);
                                                                                                                          ?></td>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_openingpxbtn__border"><?php
                                                                                                                                echo number_format('0.00', 2); ?></td>
                            <?php
                            } else {
                            ?>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_opening_tb_l_s"><?php
                                                                                                                          echo number_format('0.00', 2);
                                                                                                                          ?></td>
                              <td align="right" bgcolor="<?php echo $bg; ?>" class="trial_balance_without_openingpxbtn__border"><?php
                                                                                                                                $TotalCredit += $oResultTrial->Credit - $oResultTrial->Debit;
                                                                                                                                echo number_format($oResultTrial->Credit - $oResultTrial->Debit, 2); ?></td>
                            <?php
                            }
                            ?>
                          </tr>
                      <?php
                        }
                      }
                      ?>
                      <tr class="table_head">
                        <td colspan="2" align="right" class="trial_balance_without_opening_Right"><strong><?php echo display('total') ?></strong></td>
                        <td align="right" class="trial_balance_without_opening_Right"><strong><?php echo number_format($TotalDebit); ?></strong></td>
                        <td align="right" class="trial_balance_without_opening_Rights"><strong><?php echo number_format($TotalCredit, 2); ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="center">
                          <table width="100%" cellpadding="1" cellspacing="20" class="trial_balance_without_opening_right_50px">
                            <tr>
                              <td width="20%" class="trial_balance_without_openingpx" align="center"><?php echo display('prepared_by') ?></td>
                              <td width="20%" class="trial_balance_without_openingpx" align="center"><?php echo display('account_official') ?></td>
                              <td width="20%" class="trial_balance_without_openingpx" align='center'><?php echo display('chairman') ?></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                  </div>
                </div>

                <div class="text-center trial_balance_without_openingpxbtn" id="print">
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
</script>
@endsection