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
                                        <h4><?php echo display('profit_loss') ?></h4>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <form method="POST" action="{{route('accounts.profit_loss_report_search')}}">
                                        @csrf
                                        <!--   form_open_multipart('accounts/accounts/profit_loss_report_search') ?> -->
                                        <div class="row" id="">
                                            <div class="col-sm-6">

                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('from_date') ?></label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="dtpFromDate" value="" placeholder="<?php echo display('from_date') ?>" class="datepicker form-control" autocomplete="off" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="date" class="col-sm-4 col-form-label"><?php echo display('to_date') ?></label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="dtpToDate" value="" placeholder="<?php echo display('to_date') ?>" class="datepicker form-control" autocomplete="off" required>
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
    $(function() {
        "use strict";
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
@endsection