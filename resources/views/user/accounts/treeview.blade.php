<?php

use Illuminate\Support\Facades\DB;
?>

@extends('user.layout.app')
@section('title', 'Leads')
@section('style')
<link href="<?php echo asset('accounts/assets/css/treeview.css') ?>" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <!-- Button trigger modal -->
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
                Launch demo modal
            </button> -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{$data['page']}}</h4>
                </div>
                <div class="card-body">
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
                    <div id="edit" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <strong><?php echo display('update'); ?></strong>
                                </div>
                                <div class="modal-body editinfo">
                                </div>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6" id="newform"></div>
                                    </div>
                                    <form method="POST" action="{{route('accounts.insert_coa2')}}">
                                        @csrf
                                        <div class="row">
                                            @csrf
                                            <div class="col-lg-5">
                                                <div class="form-group row">
                                                    <label for="firstname" class="col-sm-4 col-form-label"><?php echo display('coa_head') ?> *</label>
                                                    <div class="col-sm-8">
                                                        <select name="coahead" class="form-control" onchange="selectparenthead()" id="coahead" required>
                                                            <option value="" selected="selected"><?php echo display('coa_head') ?></option>
                                                            <?php if (!empty($data['coa_head'])) { ?>
                                                                <?php foreach ($data['coa_head'] as $coa) { ?>
                                                                    <option value="<?php echo $coa->HeadName; ?>" class='bolden' data-lebel="<?php echo $coa->HeadType; ?>" data-pheadlevel="<?php echo $coa->HeadLevel; ?>" data-headcode="<?php echo $coa->HeadCode; ?>"><?php echo $coa->HeadName; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <input name="headcode" type="hidden" value="" id="headcode" />
                                                        <input name="pheadcode" type="hidden" value="" id="pheadcode" />
                                                        <input name="headlebel" type="hidden" value="" id="headlebel" />
                                                        <input name="headtype" type="hidden" value="" id="headtype" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="firstname" class="col-sm-4 col-form-label">Head Name *</label>
                                                    <div class="col-sm-8">
                                                        <input name="headname" class="form-control" type="text" placeholder="Head Name" id="headname" value="<?php echo (!empty($categoryinfo->Name) ? $categoryinfo->Name : null) ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group row">
                                                    <label for="lastname" class="col-sm-4 col-form-label">Parent Head Name</label>
                                                    <div class="col-sm-8">
                                                        <select name="Parentcategory" class="form-control" id="Parentcategory" onchange="getheadcode()">
                                                            <option value="" selected="selected">Parent Head Name</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="lastname" class="col-sm-6 col-form-label"><input type="checkbox" name="IsTransaction" value="1" id="IsTransaction" size="28"><label for="IsTransaction"> Transaction</label>
                                                        <input type="checkbox" value="1" name="IsActive" id="IsActive" checked="" size="28"><label for="IsActive"> Active</label>
                                                        <input type="checkbox" value="1" name="IsGL" id="IsGL" size="28"><label for="IsGL"> GL</label></label>
                                                    <div class="col-sm-6">
                                                        <div class="form-group text-right">
                                                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                                                            <button type="submit" class="btn btn-success w-md m-b-5">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped" id="table-1">
                                                        <thead>
                                                            <tr>
                                                                <th><?php echo "Head Code"; ?></th>
                                                                <th><?php echo "Head Name"; ?></th>
                                                                <th><?php echo "Parent Head"; ?></th>
                                                                <th><?php echo "Head Type"; ?></th>
                                                                <th><?php echo display('action') ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php allpheadtable($data['allheadname']); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- </form> -->
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<input type="hidden" id="posttoken" value="{{ csrf_token() }}">
@endsection
@section('script')
<script>
    $(document).ready(function() {
        "use strict"; // Start of use strict

        $.fn.extend({
            treed: function(o) {
                var openedClass = "fa-folder-open-o";
                var closedClass = "fa-folder-o";

                if (typeof o !== "undefined") {
                    if (typeof o.openedClass !== "undefined") {
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass !== "undefined") {
                        closedClass = o.closedClass;
                    }
                }
                //initialize each of the top levels
                var tree = $(this);
                tree.addClass("tree");
                tree.find("li")
                    .has("ul")
                    .each(function() {
                        var branch = $(this); //li with children ul
                        branch.prepend(
                            "<i class='indicator fa " + closedClass + "'></i>"
                        );
                        branch.addClass("branch");
                        branch.on("click", function(e) {
                            if (this === e.target) {
                                var icon = $(this).children("i:first");
                                icon.toggleClass(openedClass + " " + closedClass);
                                $(this).children().children().toggle();
                            }
                        });
                        branch.children().children().toggle();
                    });
                //fire event from the dynamically added icon
                tree.find(".branch .indicator").each(function() {
                    $(this).on("click", function() {
                        $(this).closest("li").click();
                    });
                });
                //fire event to open branch if the li contains an anchor instead of text
                tree.find(".branch>a").each(function() {
                    $(this).on("click", function(e) {
                        $(this).closest("li").click();
                        e.preventDefault();
                    });
                });
                //fire event to open branch if the li contains a button instead of text
                tree.find(".branch>button").each(function() {
                    $(this).on("click", function(e) {
                        $(this).closest("li").click();
                        e.preventDefault();
                    });
                });
            },
        });

        //Initialization of treeviews

        $("#tree3").treed({
            openedClass: "fa-folder-open-o",
            closedClass: "fa-folder",
        });
    });

    ("use strict");

    function loadData(id) {
        var baseurl = $("#csrfhashresarvation").val();
        $.ajax({
            url: baseurl + "accounts/accounts/selectedform/" + id,
            type: "GET",
            dataType: "json",
            // data: {
            //     csrf_test_name: csrf
            // },
            success: function(data) {
                $("#newform").html(data);
                $("#btnSave").hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus);
            },
        });
    }

    ("use strict");

    function newdata(id) {
        var csrf = $("#csrfhashresarvation").val();
        var baseurl = 'URL::url(' / ')';
        $.ajax({
            url: baseurl + "accounts/accounts/newform/" + id,
            type: "GET",
            dataType: "json",
            data: {
                csrf_test_name: csrf
            },
            success: function(data) {
                var headlabel = data.headlabel;
                $("#txtHeadCode").val(data.headcode);
                document.getElementById("txtHeadName").value = "";
                $("#txtPHead").val(data.rowdata.HeadName);
                $("#txtHeadLevel").val(headlabel);
                $("#btnSave").prop("disabled", false);
                $("#btnSave").show();
                $("#btnUpdate").hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(lang.errorajdata);
            },
        });
    }

    function selectparenthead() {
        var phead = $("#coahead").val();
        var headtype = $("#coahead option:selected").data("lebel");
        var headlebel = $("#coahead option:selected").data("pheadlevel");
        var headcode = $("#coahead option:selected").data("headcode");
        $("#headcode").val(headcode);
        $("#pheadcode").val(phead);
        $("#headlebel").val(headlebel);
        $("#headtype").val(headtype);
        // var csrf = $("#csrfhashresarvation").val();
        var APP_URL = "{{url('/')}}";

        var baseurl = APP_URL + '/accounts/selectphead';
        // var csrf = $('meta[name="csrf-token"]').attr('content');

        // var dataString = "phead=" + phead + "&csrf_test_name=" + csrf;
        var dataString = "phead=" + phead;
        $.ajax({
            type: "POST",
            url: baseurl,
            data: dataString,
            headers: {
                'X-CSRF-TOKEN': $('#posttoken').val()
            },
            success: function(data) {
                console.log(data);
                $("#Parentcategory").html(data);
            },
        });
    }

    function getheadcode() {
        var headleabel = $("#Parentcategory option:selected").data("id");
        var phead = $("#Parentcategory option:selected").data("phead");
        var headcode = $("#Parentcategory").val();
        $("#headcode").val(headcode);
        $("#pheadcode").val(phead);
        $("#headlebel").val(headleabel);
    }
</script>
@endsection