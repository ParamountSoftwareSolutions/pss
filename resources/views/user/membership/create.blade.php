@extends('user.layout.app')
@section('title', 'Create Membership Form')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post"
                              action="{{ route('membership.store',RolePrefix()) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Client</label>
                                            <select class="form-control" name="client_id">
                                                <option value="">Select Client</option>
                                                @foreach($clients as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Project Name</label>
                                            @if($projects->count() > 1)
                                            <select class="form-control" name="project_id">
                                                <option value="">Select Project</option>
                                                @foreach($projects as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @else
                                                <input type="text" class="form-control" name="project_name" readonly value="{{$projects->first()->name}}">
                                                <input type="hidden" name="project_id" value="{{$projects->first()->id}}">
                                            @endif
                                            @error('project_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Application Number</label>
                                            <input type="text" class="form-control" name="application_no"
                                                   value="{{old('application_no') }}">
                                            @error('application_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Fee</label>
                                            <input type="text" class="form-control" name="fee"
                                                   value="{{ old('fee') }}" required>
                                            @error('fee')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Passport No</label>
                                            <input type="text" class="form-control" name="passport_no"
                                                   value="{{ old('passport_no') }}">
                                            @error('passport_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Current Address</label>
                                            <input type="text" class="form-control" name="current_address"
                                                   value="{{ old('current_address') }}">
                                            @error('current_address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Permanent Address</label>
                                            <input type="text" class="form-control" name="permanent_address"
                                                   value="{{ old('permanent_address') }}">
                                            @error('permanent_address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Occupation</label>
                                            <input type="text" class="form-control" name="occupation"
                                                   value="{{ old('occupation') }}">
                                            @error('occupation')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Phone No Office</label>
                                            <input type="text" class="form-control" name="phone_no_office"
                                                   value="{{ old('phone_no_office') }}">
                                            @error('phone_no_office')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Phone No Residence</label>
                                            <input type="text" class="form-control" name="phone_no_res"
                                                   value="{{ old('phone_no_res') }}">
                                            @error('phone_no_req')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Nominee Name</label>
                                            <input type="text" class="form-control" name="nominee_name"
                                                   value="{{ old('nominee_name') }}">
                                            @error('nominee_name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Nominee Father Name</label>
                                            <input type="text" class="form-control" name="nominee_father_name"
                                                   value="{{ old('nominee_father_name') }}">
                                            @error('nominee_father_name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Nominee CNIC</label>
                                            <input type="text" class="form-control" name="nominee_cnic"
                                                   value="{{ old('nominee_cnic') }}">
                                            @error('nominee_cnic')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Nominee Passport No</label>
                                            <input type="text" class="form-control" name="nominee_passport_no"
                                                   value="{{ old('nominee_passport_no') }}">
                                            @error('nominee_passport_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Nominee Relation</label>
                                            <input type="text" class="form-control" name="relationship"
                                                   value="{{ old('relationship') }}">
                                            @error('relationship')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="section-title mt-0">Property Type</div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="property_type" name="property_type" class="custom-control-input" value="studio">
                                                <label class="custom-control-label" for="property_type">Studio</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="property_type1" name="property_type" class="custom-control-input" value="apartment">
                                                <label class="custom-control-label" for="property_type1">Apartment</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="property_type2" name="property_type" class="custom-control-input" value="flat">
                                                <label class="custom-control-label" for="property_type2">Flat</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="property_type3" name="property_type" class="custom-control-input" value="shop">
                                                <label class="custom-control-label" for="property_type3">Shop</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="property_type4" name="property_type" class="custom-control-input" value="penthouse">
                                                <label class="custom-control-label" for="property_type4">Penthouse</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="property_type5" name="property_type" class="custom-control-input" value="office">
                                                <label class="custom-control-label" for="property_type5">Office</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Total Price</label>
                                            <input type="text" class="form-control" name="total_price"
                                                   value="{{ old('total_price') }}">
                                            @error('total_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Booking Price</label>
                                            <input type="text" class="form-control" name="booking_price"
                                                   value="{{ old('booking_price') }}">
                                            @error('booking_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Down Payment</label>
                                            <input type="text" class="form-control" name="down_payment"
                                                   value="{{ old('down_payment') }}">
                                            @error('down_payment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Installment</label>
                                            <input type="text" class="form-control" name="installment"
                                                   value="{{ old('installment') }}">
                                            @error('installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Cash Receipt</label>
                                            <input type="text" class="form-control" name="cash_receipt"
                                                   value="{{ old('cash_receipt') }}">
                                            @error('cash_receipt')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="section-title mt-0">Payment Type</div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="payment-type" name="payment_type" class="custom-control-input" value="cash">
                                                <label class="custom-control-label" for="payment-type">Cash</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="payment-type1" name="payment_type" class="custom-control-input" value="bank_transfer">
                                                <label class="custom-control-label" for="payment-type1">Bank Transfer</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="payment-type2" name="payment_type" class="custom-control-input" value="pay_order">
                                                <label class="custom-control-label" for="payment-type2">Pay Order</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="payment-type3" name="payment_type" class="custom-control-input" value="cheque">
                                                <label class="custom-control-label" for="payment-type3">Cheque</label>
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
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Create Membership Form</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '200px';
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'project_logo[]',
                maxCount: 1,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset("assets/img/img2.jpg")}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>

@endsection
