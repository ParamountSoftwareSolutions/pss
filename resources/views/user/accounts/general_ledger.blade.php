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
                                            <?php echo display('general_ledger') ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="{{route('accounts.accounts_report_search')}}">
                                    @csrf    
                                    <!-- form_open_multipart('accounts/accounts/accounts_report_search') ?> -->
                                        <div class="row" id="">
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('gl_head') ?></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" name="cmbGLCode" id="cmbGLCode">
                                                            <option></option>
                                                            <?php
                                                            foreach ($data['general_ledger'] as $g_data) {
                                                            ?>
                                                                <option value="<?php echo $g_data->HeadCode; ?>"><?php echo $g_data->HeadName; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('transaction_head') ?></label>
                                                    <div class="col-sm-8">
                                                        <select name="cmbCode" class="form-control" id="ShowmbGLCode" required>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('from_date') ?></label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="dtpFromDate" value="" placeholder="<?php echo display('date') ?>" class="datepicker form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('to_date') ?></label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="dtpToDate" value="" placeholder="<?php echo display('date') ?>" class="datepicker form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"></label>
                                                    <div class="col-sm-8">
                                                        <input type="checkbox" id="chkIsTransction" name="chkIsTransction" size="40" />&nbsp;&nbsp;&nbsp;<label for="chkIsTransction" required><?php echo display('with_details') ?></label>
                                                    </div>
                                                </div>

                                                <div class="form-group text-right">
                                                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('find') ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
    $(document).ready(function() {
        "use strict";
        $('#cmbGLCode').on('change', function() {
            var csrf = $('#csrfhashresarvation').val();
            var Headid = $(this).val();
            var APP_URL = "{{url('/')}}";
            var baseurl = APP_URL + '/accounts/general_led/'+Headid;
            $.ajax({
                url: baseurl,
                type: 'GET',
                // data: {
                //     Headid: Headid,
                //     // _token : $('meta[name="csrf-token"]').attr('content')
                // },
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                success: function(data) {
                    $("#ShowmbGLCode").html(data);
                }
            });

        });
    });

    $(function() {
        "use strict";
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });

    });
</script>
@endsection