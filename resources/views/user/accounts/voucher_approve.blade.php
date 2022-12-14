@extends('user.layout.app')
@section('title', 'Leads')
@section('style')
<style>
    table.dataTable {
        clear: both;
        margin-top: 6px !important;
        margin-bottom: 6px !important;
        max-width: none !important;
        border-collapse: separate !important
    }

    table.dataTable td,
    table.dataTable th {
        -webkit-box-sizing: content-box;
        box-sizing: content-box
    }

    table.dataTable td.dataTables_empty,
    table.dataTable th.dataTables_empty {
        text-align: center
    }

    table.dataTable.nowrap th,
    table.dataTable.nowrap td {
        white-space: nowrap
    }

    div.dataTables_wrapper div.dataTables_length label {
        font-weight: normal;
        text-align: left;
        white-space: nowrap
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 75px;
        display: inline-block
    }

    div.dataTables_wrapper div.dataTables_filter {
        text-align: right
    }

    div.dataTables_wrapper div.dataTables_filter label {
        font-weight: normal;
        white-space: nowrap;
        text-align: left
    }

    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: 0.5em;
        display: inline-block;
        width: auto
    }

    div.dataTables_wrapper div.dataTables_info {
        padding-top: 8px;
        white-space: nowrap
    }

    div.dataTables_wrapper div.dataTables_paginate {
        margin: 0;
        white-space: nowrap;
        text-align: right
    }

    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        margin: 2px 0;
        white-space: nowrap
    }

    div.dataTables_wrapper div.dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        margin-left: -100px;
        margin-top: -26px;
        text-align: center;
        padding: 1em 0
    }

    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>td.sorting {
        padding-right: 30px
    }

    table.dataTable thead>tr>th:active,
    table.dataTable thead>tr>td:active {
        outline: none
    }

    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc,
    table.dataTable thead .sorting_asc_disabled,
    table.dataTable thead .sorting_desc_disabled {
        cursor: pointer;
        position: relative
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        position: absolute;
        bottom: 8px;
        right: 8px;
        display: block;
        font-family: 'Glyphicons Halflings';
        opacity: 0.5
    }

    table.dataTable thead .sorting:after {
        opacity: 0.2;
        content: "\e150"
    }

    table.dataTable thead .sorting_asc:after {
        content: "\e155"
    }

    table.dataTable thead .sorting_desc:after {
        content: "\e156"
    }

    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        color: #eee
    }

    div.dataTables_scrollHead table.dataTable {
        margin-bottom: 0 !important
    }

    div.dataTables_scrollBody table {
        border-top: none;
        margin-top: 0 !important;
        margin-bottom: 0 !important
    }

    div.dataTables_scrollBody table thead .sorting:after,
    div.dataTables_scrollBody table thead .sorting_asc:after,
    div.dataTables_scrollBody table thead .sorting_desc:after {
        display: none
    }

    div.dataTables_scrollBody table tbody tr:first-child th,
    div.dataTables_scrollBody table tbody tr:first-child td {
        border-top: none
    }

    div.dataTables_scrollFoot table {
        margin-top: 0 !important;
        border-top: none
    }

    @media screen and (max-width: 767px) {

        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: center
        }
    }

    table.dataTable.table-condensed>thead>tr>th {
        padding-right: 20px
    }

    table.dataTable.table-condensed .sorting:after,
    table.dataTable.table-condensed .sorting_asc:after,
    table.dataTable.table-condensed .sorting_desc:after {
        top: 6px;
        right: 6px
    }

    table.table-bordered.dataTable th,
    table.table-bordered.dataTable td {
        border-left-width: 0
    }

    table.table-bordered.dataTable th:last-child,
    table.table-bordered.dataTable th:last-child,
    table.table-bordered.dataTable td:last-child,
    table.table-bordered.dataTable td:last-child {
        border-right-width: 0
    }

    table.table-bordered.dataTable tbody th,
    table.table-bordered.dataTable tbody td {
        border-bottom-width: 0
    }

    div.dataTables_scrollHead table.table-bordered {
        border-bottom-width: 0
    }

    div.table-responsive>div.dataTables_wrapper>div.row {
        margin: 0
    }

    div.table-responsive>div.dataTables_wrapper>div.row>div[class^="col-"]:first-child {
        padding-left: 0
    }

    div.table-responsive>div.dataTables_wrapper>div.row>div[class^="col-"]:last-child {
        padding-right: 0
    }

    div.dt-button-info {
        position: fixed;
        top: 50%;
        left: 50%;
        width: 400px;
        margin-top: -100px;
        margin-left: -200px;
        background-color: white;
        border: 2px solid #111;
        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);
        border-radius: 3px;
        text-align: center;
        z-index: 21
    }

    div.dt-button-info h2 {
        padding: 0.5em;
        margin: 0;
        font-weight: normal;
        border-bottom: 1px solid #ddd;
        background-color: #f3f3f3
    }

    div.dt-button-info>div {
        padding: 1em
    }

    button.dt-button,
    div.dt-button,
    a.dt-button {
        position: relative;
        display: inline-block;
        box-sizing: border-box;
        margin-right: 0.333em;
        padding: 0.5em 1em;
        border: 1px solid #999;
        border-radius: 2px;
        cursor: pointer;
        font-size: 0.88em;
        color: black;
        white-space: nowrap;
        overflow: hidden;
        background-color: #e9e9e9;
        background-image: -webkit-linear-gradient(top, #fff 0%, #e9e9e9 100%);
        background-image: -moz-linear-gradient(top, #fff 0%, #e9e9e9 100%);
        background-image: -ms-linear-gradient(top, #fff 0%, #e9e9e9 100%);
        background-image: -o-linear-gradient(top, #fff 0%, #e9e9e9 100%);
        background-image: linear-gradient(to bottom, #fff 0%, #e9e9e9 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='white', EndColorStr='#e9e9e9');
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        text-decoration: none;
        outline: none
    }

    button.dt-button.disabled,
    div.dt-button.disabled,
    a.dt-button.disabled {
        color: #999;
        border: 1px solid #d0d0d0;
        cursor: default;
        background-color: #f9f9f9;
        background-image: -webkit-linear-gradient(top, #fff 0%, #f9f9f9 100%);
        background-image: -moz-linear-gradient(top, #fff 0%, #f9f9f9 100%);
        background-image: -ms-linear-gradient(top, #fff 0%, #f9f9f9 100%);
        background-image: -o-linear-gradient(top, #fff 0%, #f9f9f9 100%);
        background-image: linear-gradient(to bottom, #fff 0%, #f9f9f9 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='#ffffff', EndColorStr='#f9f9f9')
    }

    button.dt-button:active:not(.disabled),
    button.dt-button.active:not(.disabled),
    div.dt-button:active:not(.disabled),
    div.dt-button.active:not(.disabled),
    a.dt-button:active:not(.disabled),
    a.dt-button.active:not(.disabled) {
        background-color: #e2e2e2;
        background-image: -webkit-linear-gradient(top, #f3f3f3 0%, #e2e2e2 100%);
        background-image: -moz-linear-gradient(top, #f3f3f3 0%, #e2e2e2 100%);
        background-image: -ms-linear-gradient(top, #f3f3f3 0%, #e2e2e2 100%);
        background-image: -o-linear-gradient(top, #f3f3f3 0%, #e2e2e2 100%);
        background-image: linear-gradient(to bottom, #f3f3f3 0%, #e2e2e2 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='#f3f3f3', EndColorStr='#e2e2e2');
        box-shadow: inset 1px 1px 3px #999999
    }

    button.dt-button:active:not(.disabled):hover:not(.disabled),
    button.dt-button.active:not(.disabled):hover:not(.disabled),
    div.dt-button:active:not(.disabled):hover:not(.disabled),
    div.dt-button.active:not(.disabled):hover:not(.disabled),
    a.dt-button:active:not(.disabled):hover:not(.disabled),
    a.dt-button.active:not(.disabled):hover:not(.disabled) {
        box-shadow: inset 1px 1px 3px #999999;
        background-color: #cccccc;
        background-image: -webkit-linear-gradient(top, #eaeaea 0%, #ccc 100%);
        background-image: -moz-linear-gradient(top, #eaeaea 0%, #ccc 100%);
        background-image: -ms-linear-gradient(top, #eaeaea 0%, #ccc 100%);
        background-image: -o-linear-gradient(top, #eaeaea 0%, #ccc 100%);
        background-image: linear-gradient(to bottom, #eaeaea 0%, #ccc 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='#eaeaea', EndColorStr='#cccccc')
    }

    button.dt-button:hover,
    div.dt-button:hover,
    a.dt-button:hover {
        text-decoration: none
    }

    button.dt-button:hover:not(.disabled),
    div.dt-button:hover:not(.disabled),
    a.dt-button:hover:not(.disabled) {
        border: 1px solid #666;
        background-color: #e0e0e0;
        background-image: -webkit-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
        background-image: -moz-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
        background-image: -ms-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
        background-image: -o-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
        background-image: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='#f9f9f9', EndColorStr='#e0e0e0')
    }

    button.dt-button:focus:not(.disabled),
    div.dt-button:focus:not(.disabled),
    a.dt-button:focus:not(.disabled) {
        border: 1px solid #426c9e;
        text-shadow: 0 1px 0 #c4def1;
        outline: none;
        background-color: #79ace9;
        background-image: -webkit-linear-gradient(top, #bddef4 0%, #79ace9 100%);
        background-image: -moz-linear-gradient(top, #bddef4 0%, #79ace9 100%);
        background-image: -ms-linear-gradient(top, #bddef4 0%, #79ace9 100%);
        background-image: -o-linear-gradient(top, #bddef4 0%, #79ace9 100%);
        background-image: linear-gradient(to bottom, #bddef4 0%, #79ace9 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='#bddef4', EndColorStr='#79ace9')
    }

    .dt-button embed {
        outline: none
    }

    div.dt-buttons {
        position: relative;
        float: left
    }

    div.dt-buttons.buttons-right {
        float: right
    }

    div.dt-button-collection {
        position: absolute;
        top: 0;
        left: 0;
        width: 150px;
        margin-top: 3px;
        padding: 8px 8px 4px 8px;
        border: 1px solid #ccc;
        border: 1px solid rgba(0, 0, 0, 0.4);
        background-color: white;
        overflow: hidden;
        z-index: 2002;
        border-radius: 5px;
        box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        z-index: 2002;
        -webkit-column-gap: 8px;
        -moz-column-gap: 8px;
        -ms-column-gap: 8px;
        -o-column-gap: 8px;
        column-gap: 8px
    }

    div.dt-button-collection button.dt-button,
    div.dt-button-collection div.dt-button,
    div.dt-button-collection a.dt-button {
        position: relative;
        left: 0;
        right: 0;
        display: block;
        float: none;
        margin-bottom: 4px;
        margin-right: 0
    }

    div.dt-button-collection button.dt-button:active:not(.disabled),
    div.dt-button-collection button.dt-button.active:not(.disabled),
    div.dt-button-collection div.dt-button:active:not(.disabled),
    div.dt-button-collection div.dt-button.active:not(.disabled),
    div.dt-button-collection a.dt-button:active:not(.disabled),
    div.dt-button-collection a.dt-button.active:not(.disabled) {
        background-color: #dadada;
        background-image: -webkit-linear-gradient(top, #f0f0f0 0%, #dadada 100%);
        background-image: -moz-linear-gradient(top, #f0f0f0 0%, #dadada 100%);
        background-image: -ms-linear-gradient(top, #f0f0f0 0%, #dadada 100%);
        background-image: -o-linear-gradient(top, #f0f0f0 0%, #dadada 100%);
        background-image: linear-gradient(to bottom, #f0f0f0 0%, #dadada 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, StartColorStr='#f0f0f0', EndColorStr='#dadada');
        box-shadow: inset 1px 1px 3px #666
    }

    div.dt-button-collection.fixed {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-left: -75px;
        border-radius: 0
    }

    div.dt-button-collection.fixed.two-column {
        margin-left: -150px
    }

    div.dt-button-collection.fixed.three-column {
        margin-left: -225px
    }

    div.dt-button-collection.fixed.four-column {
        margin-left: -300px
    }

    div.dt-button-collection>* {
        -webkit-column-break-inside: avoid;
        break-inside: avoid
    }

    div.dt-button-collection.two-column {
        width: 300px;
        padding-bottom: 1px;
        -webkit-column-count: 2;
        -moz-column-count: 2;
        -ms-column-count: 2;
        -o-column-count: 2;
        column-count: 2
    }

    div.dt-button-collection.three-column {
        width: 450px;
        padding-bottom: 1px;
        -webkit-column-count: 3;
        -moz-column-count: 3;
        -ms-column-count: 3;
        -o-column-count: 3;
        column-count: 3
    }

    div.dt-button-collection.four-column {
        width: 600px;
        padding-bottom: 1px;
        -webkit-column-count: 4;
        -moz-column-count: 4;
        -ms-column-count: 4;
        -o-column-count: 4;
        column-count: 4
    }

    div.dt-button-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        background: -ms-radial-gradient(center, ellipse farthest-corner, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        background: -moz-radial-gradient(center, ellipse farthest-corner, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        background: -o-radial-gradient(center, ellipse farthest-corner, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        background: -webkit-gradient(radial, center center, 0, center center, 497, color-stop(0, rgba(0, 0, 0, 0.3)), color-stop(1, rgba(0, 0, 0, 0.7)));
        background: -webkit-radial-gradient(center, ellipse farthest-corner, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        background: radial-gradient(ellipse farthest-corner at center, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.7) 100%);
        z-index: 2001
    }

    @media screen and (max-width: 640px) {
        div.dt-buttons {
            float: none !important;
            text-align: center
        }
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child {
        position: relative;
        padding-left: 30px;
        cursor: pointer
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
        top: 8px;
        left: 4px;
        height: 16px;
        width: 16px;
        display: block;
        position: absolute;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 16px;
        text-align: center;
        line-height: 14px;
        box-shadow: 0 0 3px #444;
        box-sizing: content-box;
        content: '+';
        background-color: #31b131
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr.child td:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child.dataTables_empty:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child.dataTables_empty:before {
        display: none
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th:first-child:before {
        content: '-';
        background-color: #d33333
    }

    table.dataTable.dtr-inline.collapsed.compact>tbody>tr>td:first-child,
    table.dataTable.dtr-inline.collapsed.compact>tbody>tr>th:first-child {
        padding-left: 27px
    }

    table.dataTable.dtr-inline.collapsed.compact>tbody>tr>td:first-child:before,
    table.dataTable.dtr-inline.collapsed.compact>tbody>tr>th:first-child:before {
        top: 5px;
        left: 4px;
        height: 14px;
        width: 14px;
        border-radius: 14px;
        line-height: 12px
    }

    table.dataTable.dtr-column>tbody>tr>td.control,
    table.dataTable.dtr-column>tbody>tr>th.control {
        position: relative;
        cursor: pointer
    }

    table.dataTable.dtr-column>tbody>tr>td.control:before,
    table.dataTable.dtr-column>tbody>tr>th.control:before {
        top: 50%;
        left: 50%;
        height: 16px;
        width: 16px;
        margin-top: -10px;
        margin-left: -10px;
        display: block;
        position: absolute;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 16px;
        text-align: center;
        line-height: 14px;
        box-shadow: 0 0 3px #444;
        box-sizing: content-box;
        content: '+';
        background-color: #31b131
    }

    table.dataTable.dtr-column>tbody>tr.parent td.control:before,
    table.dataTable.dtr-column>tbody>tr.parent th.control:before {
        content: '-';
        background-color: #d33333
    }

    table.dataTable>tbody>tr.child {
        padding: .5em 1em
    }

    table.dataTable>tbody>tr.child:hover {
        background: 0 0 !important
    }

    table.dataTable>tbody>tr.child ul {
        display: inline-block;
        list-style-type: none;
        margin: 0;
        padding: 0
    }

    table.dataTable>tbody>tr.child ul li {
        border-bottom: 1px solid #efefef;
        padding: .5em 0
    }

    table.dataTable>tbody>tr.child ul li:first-child {
        padding-top: 0
    }

    table.dataTable>tbody>tr.child ul li:last-child {
        border-bottom: none
    }

    table.dataTable>tbody>tr.child span.dtr-title {
        display: inline-block;
        min-width: 75px;
        font-weight: 700
    }
</style>

@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{$data['page']}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th><?php echo display('sl_no') ?></th>
                                                    <th><?php echo display('voucher_no') ?></th>
                                                    <th><?php echo display('remark') ?></th>
                                                    <th><?php echo display('debit') ?></th>
                                                    <th><?php echo display('credit') ?></th>
                                                    <th><?php echo display('action') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($data['aprrove'])) ?>
                                                <?php $sl = 1; ?>
                                                <?php foreach ($data['aprrove'] as $key => $approve) { ?>
                                                    <tr id="<?php echo "row" . $key ?>">
                                                        <td><?php echo $sl++; ?></td>
                                                        <td><?php echo $approve->VNo; ?></td>
                                                        <td><?php echo $approve->Narration; ?></td>
                                                        <td><?php echo $approve->Debit; ?></td>
                                                        <td><?php echo $approve->Credit; ?></td>
                                                        <td class="romove_td">
                                                        <a href="<?php echo url("accounts/voucher_update/$approve->VNo") ?>" class="btn btn-info btn-sm" title="Update"><i class="fa fa-edit"></i></a>
                                                            <a href="{{route('accounts.isactive',['id'=>$approve->VNo])}}" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="right" title="Inactive">Not Approved</a>
                                                            <a class="btn btn-warning btn-sm" href="<?php echo url("accounts/voucher_report_print/$approve->VNo") ?>" target="balnk">Print</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Appoved Vouchers</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-12">
                                            <thead>
                                                <tr>
                                                    <th><?php echo display('sl_no') ?></th>
                                                    <th><?php echo display('voucher_no') ?></th>
                                                    <th><?php echo display('remark') ?></th>
                                                    <th><?php echo display('debit') ?></th>
                                                    <th><?php echo display('credit') ?></th>
                                                    <th><?php echo display('Status') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($data['aprroved'])) ?>
                                                <?php $sl = 1; ?>
                                                <?php foreach ($data['aprroved'] as $key => $approve) { ?>
                                                    <tr id="<?php echo "row2" . $key ?>">
                                                        <td><?php echo $sl++; ?></td>
                                                        <td><?php echo $approve->VNo; ?></td>
                                                        <td><?php echo $approve->Narration; ?></td>
                                                        <td><?php echo $approve->totaldebit; ?></td>
                                                        <td><?php echo $approve->totalcredit; ?></td>
                                                        <td class="romove_td">
                                                            <a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="right" title="Active"><?php echo display('approved') ?></a>
                                                            <a class="btn btn-warning" href="<?php echo url("accounts/voucher_report_print/$approve->VNo") ?>">Print</a>
                                                            <!-- <button type="button" onclick="print_voucher('<?php echo 'row2' . $key; ?>')" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="right" title="Inactive">Print</button> -->
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
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

<div id="printArea" style="display:none;">
    <table class="table table-striped" id="myTablePrint">
        <thead>
            <tr>
                <th><?php echo display('sl_no') ?></th>
                <th><?php echo display('voucher_no') ?></th>
                <th><?php echo display('remark') ?></th>
                <th><?php echo display('debit') ?></th>
                <th><?php echo display('credit') ?></th>
            </tr>
        </thead>
        <tbody>
            <tr id="tbodyprint">

            </tr>
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#table-12').dataTable();
    });

    function print_voucher(rowId) {
        // $("#myTablePrint tr.tbodyprint").remove();
        const row = document.getElementById(rowId)
        $('#myTablePrint #tbodyprint').append(row.innerHTML);
        $("#myTablePrint td.romove_td").remove();

        // $('#myTablePrint').find('tbody > tr > td:last').remove();
        // alert($('#myTablePrint').html());
        // const rosw = document.getElementById('myTablePrint');
        // console.log(rosw);

        // var divName = "printArea";
        // var printContents = document.getElementById(divName).innerHTML;
        // newWin = window.open("");
        // newWin.document.write(printContents);
        // newWin.print();
        // newWin.close();

        var divName = "printArea";
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();

        // var divName = "printArea";
        // var printContents = document.getElementById(divName).innerHTML;
        // var originalContents = document.body.innerHTML;
        // document.body.innerHTML = printContents;
        // window.print();
        // document.body.innerHTML = originalContents;




        // var rowId = $("table").closest("tr").html();
        // const row = document.getElementById(rowId)
        // newWin = window.open("");
        // var table = "<table><thead><tr>"
        // "                                            <th>Voucher No</th>"
        // "                                            <th>Remark</th>"
        // "                                            <th>debit</th>"
        // "                                            <th>credit</th>"
        // "                                            <th>action</th>"
        // "                                        </tr>"
        // "                                    </thead>"
        // "                                    <tbody>"
        // "                                            <tr>"
        // "                                            <td>1</td>"
        // "                                            <td>1rema</td>"
        // "                                            <td>1remadebi</td>"
        // "                                            <td>credit</td>"
        // "                                            <td>credit</td>"
        // "</tr>"
        // "                                    </tbody>"
        // "                                </table>"
        //     function printDiv() {
        //     var divName = "printArea";
        //     var printContents = document.getElementById(divName).innerHTML;
        //     var originalContents = document.body.innerHTML;
        //     document.body.innerHTML = printContents;
        //     window.print();
        //     document.body.innerHTML = originalContents;
        // }
        // newWin.document.write(row.innerHTML);
        // newWin.print();
        // newWin.close();
        // console.log(row);
        // $("#myID").printThis();
    }
</script>
@endsection