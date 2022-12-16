<!DOCTYPE html>
<html>

<head>
    <title>
        MEMBERSHIP FORM
    </title>
    <meta charset="utf-8" />
    <link href="{{asset('form_asset/')}}/FA/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="{{asset('form_asset/')}}/Styls/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('form_asset/')}}/Styls/Main.css" rel="stylesheet" />
</head>

<body>
<button onclick="window.print()">Print this page</button>
    <div class="container example" id="example">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div>
                    <button class="print-window btn btn-primary btn-lg pull-right" id="print">Print</button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-6 col-md-6 col-xs-6">
                    <div class="header-title pull-right">
                        <p>Professional Group (Land) Bahria Town Lahore</p>
                        <p>Commercial/Residental booking Application Form</p>
                        <p>139-A Commercial, 4th Floor Ammar Hight Bahria Town Lahore</p>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-xs-3">
                    <img src="{{asset('form_asset/')}}//Images/pgc-logo.png" alt="logoppms" style="margin-bottom: 10px;width: 160px;" class="pull-right" />
                </div>
            </div>

            <form action="{{url('reg_form_submit')}}" role="form" method="post" enctype="multipart/form-data" id="form_submit">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="form-group">
                            <label>Project List <small style="color: red">*</small></label>
                            <select class="form-control" id="selectProject" onchange="{project(); submitForm()}" name="building_id">
                                <option value="" disabled>Select Project ...
                                </option>
                                @if (!empty($building))
                                    @foreach ($building as $data)
                                        <option value="{{ $data }}">{{ $data->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-group">
                            <label>Project List <small style="color: red">*</small></label>
                            <select class="form-control" id="selectProject" onchange="{project(); submitForm()}" name="building_id">
                                <option value="" disabled>Select Project ...
                                </option>
                                @if (!empty($building))
                                    @foreach ($building as $data)
                                        <option value="{{ $data }}">{{ $data->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="form-group">
                            <label>Project List <small style="color: red">*</small></label>
                            <select class="form-control" id="selectProject" onchange="{project(); submitForm()}" name="building_id">
                                <option value="" disabled>Select Project ...
                                </option>
                                @if (!empty($building))
                                    @foreach ($building as $data)
                                        <option value="{{ $data }}">{{ $data->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                    <div class="form-group row">
                        <div class="col-md-1">
                            <label class="control-label"> Form No.</label>
                        </div>
                        <div class="col-md-2">
                            <input name="FormNo" id="FormNo" name="FormNo" type="text" class="form-control" placeholder="SK-520" required>
                        </div>
                        <div class="col-md-1">
                            <label class="control-label"> Reg No.</label>
                        </div>
                        <div class="col-md-2">
                            <input name="RegNo" id="RegNo" type="text" class="form-control" placeholder="M-k 1582...." required>
                        </div>
                    </div>
                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="control-label"> Form No.</label>
                    </div>
                    <div class="col-md-2">
                        <input name="FormNo" id="FormNo" name="FormNo" type="text" class="form-control" placeholder="SK-520" required>
                    </div>
                    <div class="col-md-1">
                        <label class="control-label"> Reg No.</label>
                    </div>
                    <div class="col-md-2">
                        <input name="RegNo" id="RegNo" type="text" class="form-control" placeholder="M-k 1582...." required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="information-title">Preference choice <span style="font-weight: 100;">(tick one) </span> 1-commercial 2-Residential</h4>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-1">
                        <label class="control-label">Block</label>
                    </div>
                    <div class="col-md-2">
                        <input name="Block" id="Block" type="text" class="form-control" placeholder="Enter Block...." required>
                    </div>
                    <div class="col-md-1">
                        <label class="control-label"> Plot Size</label>
                    </div>
                    <div class="col-md-2">
                        <input name="PlotSize" id="PlotSize" type="text" class="form-control" placeholder="Enter Plot Size...." required>
                    </div>
                    <div class="col-md-1">
                        <label class="control-label">Location/type</label>
                    </div>
                    <div class="col-md-2">
                        <input name="Location" id="Location" type="text" class="form-control" placeholder="Enter Location...." required>
                    </div>
                    <div class="col-md-1">
                        <label class="control-label"> Plot No.</label>
                    </div>
                    <div class="col-md-2">
                        <input name="PlotNo" id="PlotNo" type="text" class="form-control" placeholder="Enter Plot No...." required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="information-title">Preference of plot (tick one)</h4>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group ">
                            <input name="general" class="form-check-input" type="checkbox" value="" id="general">
                            <label class="form-check-label" for="flexCheckDefault">
                                General
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group ">
                            <input name="conrner" class="form-check-input" type="checkbox" value="" id="conrner">
                            <label class="form-check-label" for="flexCheckDefault">
                                Conrner
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group ">
                            <input name="boulevard" class="form-check-input" type="checkbox" value="" id="boulevard">
                            <label class="form-check-label" for="flexCheckDefault">
                                Boulevard
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="information-title">Payment <span style="font-weight: 100;">(tick one)</span></h4>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group ">
                            <input name="instalment" class="form-check-input" type="checkbox" value="" id="instalment">
                            <label class="form-check-label" for="flexCheckDefault">
                                1-Instalment
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label" for="Applicant">For office use only:Booking Date</label>
                    </div>
                    <div class="col-sm-3">
                        <input name="Booking" id="Booking-Date" type="text" class="form-control" placeholder="Enter Booking Date..." required>
                    </div>


                    <div class="col-sm-3">
                        <label class="control-label" for="City">Extra Land</label>
                    </div>
                    <div class="col-sm-3">
                        <input name="ExtraLand" id="Extra-Land" type="text" class="form-control" placeholder="Enter Extra Land....">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label" for="Applicant">Extra land cost</label>
                    </div>
                    <div class="col-sm-3">
                        <input name="ExtraLandCost" id="ExtraLand-cost" type="text" class="form-control" placeholder="Enter extra land cost....." required>
                    </div>


                    <div class="col-sm-3">
                        <label class="control-label" for="City">Total price</label>
                    </div>
                    <div class="col-sm-3">
                        <input name="TotalPrice" id="Total-price" type="text" class="form-control" placeholder="Enter Total price....">
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
                        <input name="ApplicantName" id="Applicant" type="text" class="form-control" placeholder="Enter Applicant Name Here..." required>
                    </div>


                    <div class="col-sm-2">
                        <label class="control-label" for="City">S/O.D/O.W/O</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="SO_Name" id="S-OF" type="text" class="form-control" placeholder="S/O.D/O.W/O" required>
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label" for="CNIC">CNIC#</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="CNIC" id="CNIC" type="text" class="form-control" placeholder="Enter CNIC NUMBER..." required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="PASSPORT">Passport No</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="PASSPORT" id="PASSPORT" type="text" class="form-control" placeholder="Enter PASSPORT NO" required>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">E-mail</label>
                    </div>
                    <div class="col-sm-10">
                        <input name="mail" id="E-mail" type="email" class="form-control" placeholder="Enter E-mail..." required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label" for="Address">Current Address</label>
                    </div>
                    <div class="col-sm-10">
                        <input name="address" id="address" type="text" class="form-control" placeholder="Enter Current Address Here..." required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label" for="Address">Permanent Address</label>
                    </div>
                    <div class="col-sm-10">
                        <input name="address2" id="address" type="text" class="form-control" placeholder="Enter Permanent Address Here..." required>
                    </div>
                </div>

                <div class=" form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">Phone No: (Office)</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Phone" id="Phone-No" type="text" class="form-control" placeholder="xxxx-xxxxxxx" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Mobile</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Phone2" id="Phone-No" type="email" class="form-control" placeholder="xxxx-xxxxxxx" required>
                    </div>

                </div>
                <!-- End of personal informatio -->
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="information-title">Nominee INFORMATION</h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label" for="Applicant">Nominee Name</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="NomineeName" id="Nominee-Name" type="text" class="form-control" placeholder="Enter Nominee Name Here..." required>
                    </div>


                    <div class="col-sm-2">
                        <label class="control-label" for="City">S/O.D/O.W/O</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Nominee_SO_Name" id="NomineeS-OF" type="text" class="form-control" placeholder="S/O.D/O.W/O" required>
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label" for="CNIC">CNIC#</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Nominee_CNIC" id="Nominee-CNIC" type="text" class="form-control" placeholder="Enter CNIC NUMBER..." required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="PASSPORT">Relationship</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Nominee_PASSPORT" id="Relationship" type="text" class="form-control" placeholder="Enter Relationship...." required>

                    </div>
                </div>

                <!--End of Nominee INFORMATION -->
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="information-title">Bank Details<span style="font-weight: 100;">/Acount Number</span></h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-6 text-center" style="padding-bottom: 10px;">
                            <input type="text" class="form-control" name="AccountNo">
                            <!-- <div id="otp" class="flex justify-center">
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="first" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="second" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="third" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fourth" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fifth" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="sixth" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="seven" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="eight" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="nine" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="ten" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="eleven" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="twalve" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="thirteen" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fourteen" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fifteen" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="sixteen" maxlength="1" />
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">DD/Pay Order Number</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="PayOrderNumber" id="PayOrder-Number" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Total Amount</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="TotalAmount" id="Total-Amount" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">Drawn on Bank</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="DrawnBank" id="Drawn-Bank" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Branch</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Branch" id="Branch" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>
                <!--End of Bank Details -->
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="information-title">Document to be attached with Form:</h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p style="padding-left: 20px;">1- Two recent passport size photographs 2- copy of Application CNIC 3- Copy of Nominne CNIC </p>
                    </div>
                </div>
                <div class="row" style="border-bottom: 1px solid #000000;">
                    <div class="col-sm-4">
                        <h4 class="Signature">Booking Officer</h4>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="Signature">Manager</h4>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="Signature">Applicant Signature</h4>
                    </div>
                </div>

                <!--End of Signature 1 -->
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <div class="header-title" style="margin-top: 10px;">
                            <p>Professional Group (Land)</p>
                            <p>Commercial/Residental Plot</p>
                            <p>139-A Commercial, 4th Floor Ammar Hight Bahria Town Lahore</p>
                        </div>
                    </div>
                </div>
                <!-- End of costomer copy for title -->
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">Form No.</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="FormNoCustomer" id="FormNo-customer" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Reg No.</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="RegNoCustomer" id="RegNo-customer" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">Block</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Block" id="Block-customer" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Plot Size</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="PlotSize" id="PlotSize-customer" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">Location/Type</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="Location" id="Location-customer" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Plot No.</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="PlotNo" id="PlotNo-customer" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">Applicant Name</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="ApplicantNameCustomer" id="ApplicantName-customer" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">CNIC</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="CNICCustomer" id="CNIC-customer" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>

                <!-- End of  Applicant information  -->
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="information-title">Bank Details<span style="font-weight: 100;">/Acount Number</span></h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-6 text-center" style="padding-bottom: 10px;">
                            <input name="ApplicantAccountNumber" type="text" class="form-control" placeholder="" required>
                            <!-- <div id="otp" class="flex justify-center">
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="first" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="second" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="third" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fourth" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fifth" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="sixth" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="seven" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="eight" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="nine" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="ten" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="eleven" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="twalve" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="thirteen" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fourteen" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="fifteen" maxlength="1" />
                                <input  name="FormNo" class="m-2 text-center form-control form-control-solid rounded focus:border-blue-400 focus:shadow-outline" type="text" id="sixteen" maxlength="1" />
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">DD/Pay Order Number</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="ApplicantPayOrderNumber" id="PayOrder-Number" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Total Amount</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="ApplicantTotalAmount" id="Total-Amount" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label class="control-label">Drawn on Bank</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="ApplicantDrawnBank" id="Drawn-Bank" type="text" class="form-control" placeholder="" required>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label">Branch</label>
                    </div>
                    <div class="col-sm-4">
                        <input name="ApplicantBranch" id="Branch" type="text" class="form-control" placeholder="" required>

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="information-title">Document to be attached with Form:</h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p style="padding-left: 20px;">1- Two recent passport size photographs 2- copy of Application CNIC 3- Copy of Nominne CNIC </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="Signature">Booking Officer</h4>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="Signature">Manager</h4>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="Signature">Applicant Signature</h4>
                    </div>
                </div>
                <!--End of Signature 2 -->
            </form>
        </div>
    </div>
    <div class="row text-center" style="margin: 20px;">
        <div class="col-md-12">
            <button type="button" id="form_btn" class="btn btn-success pb-2">Save</button>
        </div>
    </div>
    <script src="{{asset('form_asset/')}}/Scripts/jquery-1.9.1.min.js"></script>
    <script src="{{asset('form_asset/')}}/Scripts/app.min.js"></script>
    <script src="{{asset('form_asset/')}}/Scripts/bootstrap.min.js"></script>
    <script src="{{asset('form_asset/')}}/Scripts/jquery-printme.js"></script>
    <script>
        $('#form_btn').click(function() {
            $('#form_submit').submit();
        });
        document.addEventListener("DOMContentLoaded", function(event) {

            function OTPInput() {
                const editor = document.getElementById('first');
                editor.onpaste = pasteOTP;

                const inputs = document.querySelectorAll('#otp > *[id]');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('input', function(event) {
                        if (!event.target.value || event.target.value == '') {
                            if (event.target.previousSibling.previousSibling) {
                                event.target.previousSibling.previousSibling.focus();
                            }

                        } else {
                            if (event.target.nextSibling.nextSibling) {
                                event.target.nextSibling.nextSibling.focus();
                            }
                        }
                    });
                }
            }
            OTPInput();
        });

        function pasteOTP(event) {
            event.preventDefault();
            let elm = event.target;
            let pasteVal = event.clipboardData.getData('text').split("");
            if (pasteVal.length > 0) {
                while (elm) {
                    elm.value = pasteVal.shift();
                    elm = elm.nextSibling.nextSibling;
                }
            }
        }
        // End js for  bank acount number
        $(document).on('click', '#print', function() {
            $('#print').hide();
            $('#form_btn').hide();
            window.print();
            $('#print').show();
        });
    </script>
</body>

</html>
