@extends('user.layout.app')
@section('title', 'Create Membership Form')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>MemberShip Form Detail</h4>
                                <a href="{{ route('membership.edit', ['RolePrefix'=>RolePrefix(),'membership'=>$form->id]) }}"
                                   class="btn btn-primary"
                                   style="margin-left: auto; display: block;">Edit</a>
                                <a href="{{ route('membership.print.form', ['RolePrefix'=>RolePrefix(),'id'=>$form->id]) }}"
                                   class="btn btn-primary"
                                   style="margin-left: 3px; display: block;">Print Form</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Client</label>
                                            <input type="text" class="form-control" name="client_id"
                                                   value="{{$form->client_id ? $form->client->name : '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Project Name</label>
                                        <input type="text" class="form-control" name="project_name"
                                               value="{{$form->project_id ? $form->project->name : ''}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Application Number</label>
                                        <input type="text" class="form-control" name="application_no"
                                               value="{{old('application_no', $form->application_no) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Fee</label>
                                        <input type="text" class="form-control" name="fee"
                                               value="{{ old('fee', $form->fee) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Passport No</label>
                                        <input type="text" class="form-control" name="passport_no"
                                               value="{{ old('passport_no', $form->passport_no) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Current Address</label>
                                        <input type="text" class="form-control" name="current_address"
                                               value="{{ old('current_address', $form->current_address) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Permanent Address</label>
                                        <input type="text" class="form-control" name="permanent_address"
                                               value="{{ old('permanent_address', $form->permanent_address) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Occupation</label>
                                        <input type="text" class="form-control" name="occupation"
                                               placeholder="PKR 1Lak to 10Lak"
                                               value="{{ old('occupation', $form->occupation) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Phone No Office</label>
                                        <input type="text" class="form-control" name="phone_no_office"
                                               value="{{ old('phone_no_office', $form->phone_no_office) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Phone No Residence</label>
                                        <input type="text" class="form-control" name="phone_no_res"
                                               value="{{ old('phone_no_res', $form->phone_no_res) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nominee Name</label>
                                        <input type="text" class="form-control" name="nominee_name"
                                               value="{{ old('nominee_name', $form->nominee_name) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nominee Father Name</label>
                                        <input type="text" class="form-control" name="nominee_father_name"
                                               value="{{ old('nominee_father_name', $form->nominee_father_name) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Nominee CNIC</label>
                                        <input type="text" class="form-control" name="nominee_cnic"
                                               value="{{ old('nominee_cnic', $form->nominee_cnic) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nominee Passport No</label>
                                        <input type="text" class="form-control" name="nominee_passport_no"
                                               value="{{ old('nominee_passport_no', $form->nominee_passport_no) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nominee Relation</label>
                                        <input type="text" class="form-control" name="relationship"
                                               value="{{ old('relationship', $form->relationship) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="section-title mt-0">Property Type</div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="property_type" name="property_type"
                                                   class="custom-control-input" value="studio"
                                                   @if($form->property_type == 'studio') checked @endif>
                                            <label class="custom-control-label" for="property_type">Studio</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="property_type1" name="property_type"
                                                   class="custom-control-input" value="apartment"
                                                   @if($form->property_type == 'apartment') checked @endif>
                                            <label class="custom-control-label"
                                                   for="property_type1">Apartment</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="property_type2" name="property_type"
                                                   class="custom-control-input" value="flat"
                                                   @if($form->property_type == 'flat') checked @endif>
                                            <label class="custom-control-label" for="property_type2">Flat</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="property_type3" name="property_type"
                                                   class="custom-control-input" value="shop"
                                                   @if($form->property_type == 'shop') checked @endif>
                                            <label class="custom-control-label" for="property_type3">Shop</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="property_type4" name="property_type"
                                                   class="custom-control-input" value="penthouse"
                                                   @if($form->property_type == 'penthouse') checked @endif>
                                            <label class="custom-control-label"
                                                   for="property_type4">Penthouse</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="property_type5" name="property_type"
                                                   class="custom-control-input" value="office"
                                                   @if($form->property_type == 'office') checked @endif>
                                            <label class="custom-control-label" for="property_type5">Office</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Total Price</label>
                                        <input type="text" class="form-control" name="total_price"
                                               value="{{ old('total_price', $form->total_price) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Booking Price</label>
                                        <input type="text" class="form-control" name="booking_price"
                                               value="{{ old('booking_price', $form->booking_price) }}">
                                        @error('booking_price')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Down Payment</label>
                                        <input type="text" class="form-control" name="down_payment"
                                               value="{{ old('down_payment', $form->down_payment) }}">
                                        @error('down_payment')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Installment</label>
                                        <input type="text" class="form-control" name="installment"
                                               value="{{ old('installment', $form->installment) }}">
                                        @error('installment')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Cash Receipt</label>
                                        <input type="text" class="form-control" name="cash_receipt"
                                               value="{{ old('cash_receipt', $form->cash_receipt) }}">
                                        @error('cash_receipt')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="section-title mt-0">Payment Type</div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="payment-type" name="payment_type"
                                                   class="custom-control-input" value="cash"
                                                   @if($form->payment_type == 'cash') checked @endif>
                                            <label class="custom-control-label" for="payment-type">Cash</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="payment-type1" name="payment_type"
                                                   class="custom-control-input" value="bank_transfer"
                                                   @if($form->payment_type == 'bank_transfer') checked @endif>
                                            <label class="custom-control-label" for="payment-type1">Bank
                                                Transfer</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="payment-type2" name="payment_type"
                                                   class="custom-control-input" value="pay_order"
                                                   @if($form->payment_type == 'pay_order') checked @endif>
                                            <label class="custom-control-label" for="payment-type2">Pay
                                                Pay Order</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="payment-type3" name="payment_type"
                                                   class="custom-control-input" value="cheque"
                                                   @if($form->payment_type == 'cheque') checked @endif>
                                            <label class="custom-control-label" for="payment-type3">Cheque</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="payment-type4" name="payment_type"
                                                   class="custom-control-input" value="bank_transfer"
                                                   @if($form->payment_type == 'bank_transfer') checked @endif>
                                            <label class="custom-control-label" for="payment-type4">Bank
                                                Transfer</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Multi Image Upload -->
                        <div class="card card-primary">
                            <div class="card-header ui-sortable-handle">
                                <h4>Project Logo <small style="color: red">* (ratio 1:1)</small></h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div>
                                        <div class="row mb-3">
                                            @if($form->project_logo !== null)
                                                <div class="col-3">
                                                    <img style="height: 200px;width: 100%" class="banner-image"
                                                         src="{{asset($form->project_logo)}}">
                                                    {{--<a href=""
                                                       style="margin-top: -35px;border-radius: 0"
                                                       class="btn btn-danger btn-block btn-sm remove-image"
                                                       data-id="{{ $form->id }}">Remove</a>--}}
                                                </div>
                                            @endif
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
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    <script type="text/javascript" src="{{ asset('public/panel/assets/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("input").prop('disabled', true);
            $("select").prop('disabled', true);
            /*$('.print-window').click(function() {
                window.print();
            });*/
        })
    </script>

@endsection
