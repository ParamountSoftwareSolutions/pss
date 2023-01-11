@extends('user.layout.app')
@section('title', 'Update Profile')
@section('style')
    <link href="{{ asset('formprint/Styls/Main.css') }}" rel="stylesheet"/>
    <style>
        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }

            .no-print, .no-print * {
                display: none !important;
            }

            /*.example {
                position: fixed;
                overflow: auto;
                z-index: 100000; !* CSS doesn't support infinity *!

                !* Any other Print Properties *!
            }*/
        }

        .form-group {
            margin-bottom: 15px;
        }


    </style>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="print-window btn btn-primary btn-lg pull-right" id="print">
                            Print
                        </div>
                    </div>
                    <div class="example" id="example">

                        <div class="row">
                            <div class="col-sm-4 col-md-4 col-xs-4">
                                <img src="{{ asset($form->project_logo) }}" alt="logoppms"
                                     style="margin-bottom: 10px;width: 160px;"/>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-4">
                                <div class="header-title"><h4>{{ $form->project->name }}</h4></div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-xs-4" style="text-align: -webkit-right;">
                                <div>
                                    {!! DNS2D::getBarcodeHTML($form->barcode, 'QRCODE',3,3) !!}
                                </div>
                            </div>
                        </div>

                        <form role="form" method="post" enctype="multipart/form-data">

                            {{--<fieldset>--}}
                            <legend style="text-align: center; padding-bottom: 10px;">MEMBERSHIP FORM</legend>


                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label class="control-label"> Application No</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="ApplicationNo" type="text" class="form-control"
                                           placeholder="SK-520" required
                                           value="{{ $form->application_no }}">
                                </div>


                                <div class="col-sm-2">
                                    <h6 class="pull-right"
                                        style="font-size: 24px; font-weight: 500;padding-top: 20px;">
                                        RS.{{ $form->fee }}/-</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="information-title">PERSONAL INFORMATION</h4>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label" for="Applicant">Name of Applicant</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="Applicant" type="text" class="form-control"
                                           placeholder="Enter Applicant Name Here..." required
                                           value="{{ $form->client->username ?? '' }}">
                                </div>


                                <div class="col-sm-2">
                                    <label class="control-label" for="City">S/O.D/O.W/O</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="S-OF" type="text" class="form-control" placeholder="S/O.D/O.W/O"
                                           required
                                           value="{{ $form->client->father_name ?? '' }}">
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label" for="CNIC">CNIC#</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="CNIC" type="text" class="form-control"
                                           placeholder="Enter CNIC NUMBER..." required
                                           value="{{ $form->client->cnic ?? '' }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label" for="PASSPORT">Passport No</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="PASSPORT" type="text" class="form-control"
                                           placeholder="Enter PASSPORT NO" required
                                           value="{{ $form->passport_no }}">

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label" for="Address">Current Address</label>
                                </div>
                                <div class="col-sm-10">
                                    <input id="address" type="text" class="form-control"
                                           placeholder="Enter Current Address Here..."
                                           required
                                           value="{{ $form->current_address }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label" for="Address">Permanent Address</label>
                                </div>
                                <div class="col-sm-10">
                                    <input id="address" type="text" class="form-control"
                                           placeholder="Enter Permanent Address Here..."
                                           required
                                           value="{{ $form->permanent_address }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label"
                                           for="Designation">Occupation</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="Designation" type="text" class="form-control"
                                           placeholder="Enter Designation/Occupation" required
                                           value="{{ $form->occupation }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">E-mail</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="E-mail" type="email" class="form-control"
                                           placeholder="Enter E-mail..." required
                                           value="{{ $form->client->email ?? '' }}">
                                </div>
                            </div>
                            <div class=" form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label">Phone No: (Office)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="Phone-No" type="text" class="form-control"
                                           placeholder="xxxx-xxxxxxx" required
                                           value="{{ $form->phone_no_office }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Mobile</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="Phone-No" type="email" class="form-control"
                                           placeholder="xxxx-xxxxxxx" required
                                           value="{{ $form->client->phone_number ?? '' }}">
                                </div>

                            </div>
                            <!-- End of personal informatio -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="information-title">NOMINEE INFORMATION</h4>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label">Nominee Name </label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="Nominee" type="text" class="form-control"
                                           placeholder="Enter Nominee Name Here..."
                                           required value="{{ $form->nominee_name }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label" for="City">S/O.D/O.W/O</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="S-OF" type="text" class="form-control" placeholder="S/O.D/O.W/O"
                                           required
                                           value="{{ $form->nominee_father_name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label" for="CNIC">CNIC#</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="CNIC" type="text" class="form-control"
                                           placeholder="Enter CNIC NUMBER..." required
                                           value="{{ $form->nominee_cnic }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label" for="PASSPORT">Passport No</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="PASSPORT" type="text" class="form-control"
                                           placeholder="Enter PASSPORT NO" required
                                           value="{{ $form->nominee_passport_no }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label">Relationship with Applicant</label>
                                </div>
                                <div class="col-sm-10">
                                    <input id="Relationship-Applicant" type="text" class="form-control"
                                           placeholder="Relationship Applicant" required
                                           value="{{ $form->relationship }}">
                                </div>
                            </div>
                            <!-- End of Nominee information -->

                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="information-title">Property Type</h4>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 col-xs-4">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value="studio"
                                               @if($form->property_type == 'studio') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Studio
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-4">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->property_type == 'apartment') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Apartment
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-4">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->property_type == 'flat') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Flat
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-4">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->property_type == 'shop') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Shop
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-4">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->property_type == 'penthouse') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Penthouse
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-4">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->property_type == 'office') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Office
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- End of Plot Size  -->


                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="information-title">PAYMENT DETAIL</h4>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label">Total Plot Amount</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="TotalPlotPrice" type="text" class="form-control"
                                           placeholder="Total Plot Price"
                                           required value="{{ $form->total_price }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label"> Booking Amount</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="Booking-Amount " type="text" class="form-control"
                                           placeholder="Full Booking Amount Received" required
                                           value="{{ $form->booking_price }}">
                                </div>
                            </div>
                            <div class=" form-group row">
                                <div class="col-sm-2">
                                    <label class="control-label">Down Payment</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="DownPayment" type="text" class="form-control"
                                           placeholder="Down Payment..." required
                                           value="{{ $form->down_payment }}">
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">Installment</label>
                                </div>
                                <div class="col-sm-4">
                                    <input id="Installment" type="text" class="form-control"
                                           placeholder="Installment" required
                                           value="{{ $form->installment }}">
                                </div>
                            </div>

                            //row
                            <div class="form-group row">
                                <div class="col-sm-2 col-xs-6">
                                    <div class="form-group form-check">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Payment Through
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-6">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->payment_type == 'cash') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Cash
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-6">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->payment_type == 'bank_transfer') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Bank Transfer
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-6">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->payment_type == 'cheque') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Cheque
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-6">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                               @if($form->payment_type == 'pay_order') checked
                                               @endif id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Pay Order
                                        </label>
                                    </div>
                                </div>


                                <div class="col-sm-2 col-xs-6">
                                    <label class="control-label" for="PASSPORT">Cash Receip#</label>
                                </div>
                                <div class="col-sm-3 col-xs-6 " style="margin-left: -3px">
                                    <input id="PASSPORT" type="text" class="form-control"
                                           placeholder="Order/Cash Receip#" required
                                           value="{{ $form->cash_receipt }}">

                                </div>
                            </div>
                            <!-- End Of Payment Details -->


                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="Signature">ACCOUNTS DEPARTMENT</h4>
                                </div>
                                <div class="col-sm-4">
                                    <h4 class="Signature">APPLICANT'S SIGNATURE</h4>
                                </div>
                                <div class="col-sm-4">
                                    <h4 class="Signature">AUTHORITY SIGNATURE OFFICE STAMP</h4>
                                </div>
                            </div>
                            <!--End of Signature -->
                            {{--</fieldset>--}}
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div><!--End of Container-->
    <!--</div>-->
    <!--Scripts-->
@endsection
@section('script')
    {{--<script src="{{ asset('public/formprint/Scripts/jquery-1.9.1.min.js') }}"></script>--}}{{--
    <script src="{{ asset('public/panel/assets/js/app.min.js') }}"></script>
    --}}{{--<script src="{{ asset('public/formprint/Scripts/bootstrap.min.js') }}"></script>--}}
    <script src="{{ asset('public/panel/assets/js/jquery-printme.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("input").prop('disabled', true);
            $("select").prop('disabled', true);
            $("textarea").prop('disabled', true);
            $(".form-control[disabled]").css('background-color', '#fff');
            $(".input[type=checkbox]").css('background-color', '#ffffff');
            $(".example").css({
                "width": "100%",
                "margin-top": '-7px'
            });
        })
        $(document).on('click', '#print', function () {
            {{--$("#example").printMe({"path": ["{{ asset('public/formprint/Styls/bootstrap.min.css') }}", "{{ asset('public/formprint/Styls/Main.css') }}", "{{ asset('public/formprint/FA/font-awesome-4.7.0/css/font-awesome.css') }}"]});--}}

            $('#print').hide();
            $('.navbar').hide();
            $('.main-sidebar').hide();
            $('.main-footer').hide();
            $(".example").css({
                "width": "100%",
                "margin-top": '30px'
            });
            window.print();
            $('#print').show();
            $('.navbar').show();
            $('.main-sidebar').show();
            $('.main-footer').show();
            $(".example").css({
                "width": "100%",
                "margin-top": '-7px'
            });
        });
        /*$(document).ready(function () {
            setTimeout(() => {
                $('#print').hide();
                window.print();
                $('#print').show();
            }, 1000);
        });*/
    </script>
@endsection
