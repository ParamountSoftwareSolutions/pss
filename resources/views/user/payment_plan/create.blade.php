@extends('user.layout.app')
@section('title', 'Payment Plan Create')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form id="payment_plan_form" method="post" action="{{ route('payment_plan.store',RolePrefix()) }}">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Project Type <small style="color: red">*</small></label>
                                            <select class="form-control" name="project_type_id" required>
                                                <option label="" disabled selected>Select Project Type</option>
                                                @foreach($project_type as $data)
                                                    <option value="{{ $data->id }}">{{ ucwords($data->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Payment Plan Name <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="name" required>
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Total Amount <small style="color: red">*</small></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="total_price" id="total_price" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('total_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select class="form-control" name="premium_id" required>
                                                    <option value="">Select Premium Type</option>
                                                </select>
                                                @error('premium_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 commission-box">
                                            <label class="d-block">Commission (In %)</label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" aria-label="Commission"
                                                       name="commission" id="commission">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            @error('commission')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 commission-box">
                                            <label class="d-block">Total Price After Commission</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input style="cursor: not-allowed;" type="number" class="form-control" aria-label="Commission"
                                                       id="after_commission_price" disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="after_commission_price">
                                            @error('after_commission_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Payment Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Select Down Payment</label>
                                            <div class="input-group mb-3">
                                                <select class="form-control" name="down_payment_select">
                                                    <option value="">Please Select</option>
                                                    <option value="100%">100%</option>
                                                    <option value="50%">50%</option>
                                                    <option value="less_50">Less Than 50%</option>
                                                </select>
                                            </div>
                                            @error('down_payment_select')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 down_payment">
                                            <label class="d-block">Down Payment Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="down_payment"value="{{old('down_payment')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('down_payment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 down_payment">
                                            <label class="d-block">Confirmation Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="confirmation_amount" value="{{old('confirmation_amount')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('confirmation_amount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Balloting Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="balloting_price" value="{{old('balloting_price')}}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('balloting_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Possession Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="possession_price" value="{{old('possession_price')}}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('possession_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Numbers of Installment</label>
                                            <input type="number" class="form-control" name="total_month_installment" value="{{old('total_month_installment')}}" required>
                                            @error('total_month_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Monthly Installment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="per_month_installment" id="per_month_installment" value="{{old('per_month_installment')}}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('per_month_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Bi-Annual Installment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="half_year_installment" id="half_year_installment" value="{{old('half_year_installment')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('half_year_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Quarterly Installment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="quarterly_payment" id="quarterly_payment" value="{{old('quarterly_payment')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('quarterly_payment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 discount">
                                            <label class="d-block">Discount Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="discount" value="{{old('discount')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('discount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 rent">
                                            <label class="d-block">Rent Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="rent_price" value="{{old('rent_price')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('rent_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 rent_installment">
                                            <label class="d-block">Number Of Payments</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="rent_installment" value="{{old('rent_installment')}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('rent_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="payment_plan" class="btn btn-primary" type="button">Submit</button>
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
    <script>
        $(document).ready(function () {
            $('.commission-box').hide();
            $('.rent').hide();
            $('.rent_installment').hide();
            $('select[name="project_type_id"]').change(function () {
                var type_id = $(this).val();
                $.ajax({
                    url: "{{ url(RolePrefix().'/get-premium') }}/" + type_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="premium_id"]').empty();
                        $('select[name="premium_id"]').append('<option value="">Please  Select</option>');
                        $('select[name="premium_id"]').append('<option value="regular">Regular</option>');
                        if (data.length > 0) {
                            $.each(data, function (key, value) {
                                let oldFloorDetailId = '{{ old('floor_detail_id') }}';
                                let selected = value.id == oldFloorDetailId ? "selected" : "";
                                $('select[name="premium_id"]').append('<option ' + selected + ' value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                        $('.commission-box').hide();
                    },
                });
                return;
            })
            $('select[name="premium_id"]').change(function () {
                var val = $(this).val();
                if(val !== 'regular'){
                    $('.commission-box').show();
                }else{
                    $('.commission-box').hide();
                }
            })
            $('#commission, #total_price').on('change keypress keyup', function (e) {
                let commission = Number($('#commission').val());
                let totalPrice = Number($('#total_price').val());
                let comPrice = (commission / 100) * totalPrice;
                let afterComPrice = totalPrice + comPrice;
                $('#after_commission_price').val(afterComPrice);
                $('input[name="after_commission_price"]').val(afterComPrice);
                let down_payment_select = $('select[name="down_payment_select"] option:selected').val();
                if(down_payment_select == '100%'){
                    $('input[name="down_payment"]').removeAttr('max');
                    $('input[name="down_payment"]').val(afterComPrice);
                }
                else if(down_payment_select == '50%'){
                    $('input[name="down_payment"]').removeAttr('max');
                    $('input[name="down_payment"]').val(afterComPrice / 2);
                }
                else if(down_payment_select == 'less_50'){
                    $('input[name="down_payment"]').attr('max',afterComPrice / 2);
                    $('input[name="down_payment"]').val('');
                }
            })

            $('select[name="down_payment_select"]').change(function () {
                var down_payment_select = $(this).val();
                var premium_id = $('select[name="premium_id"] option:selected').val();
                if(premium_id && premium_id != 'regular') {
                    var total_amount = Number($('input[name="after_commission_price"]').val());
                }else {
                    var total_amount = Number($('input[name="total_price"]').val());
                }
                var down_payment = $('input[name="down_payment"]');
                if(down_payment_select == '100%'){
                    down_payment.attr('readonly','true');
                    down_payment.val(total_amount);
                    $('.rent').show();
                    $('.rent_installment').show();
                }else if(down_payment_select == '50%'){
                    down_payment.attr('readonly','true');
                    down_payment.val(total_amount / 2);
                    $('.rent').show();
                    $('.rent_installment').show();
                }else if(down_payment_select == 'less_50'){
                    down_payment.removeAttr('readonly');
                    down_payment.val('');
                    $('.rent').hide();
                    $('.rent_installment').hide();
                }
            });
        });

        $('#payment_plan').click(function (e) {
            e.preventDefault();
            var premium_id = $('select[name="premium_id"] option:selected').val();
            if(premium_id){
                if (premium_id == 'regular') {
                    var total_amount = Number($('input[name="total_price"]').val());
                } else {
                    var total_amount = Number($('input[name="after_commission_price"]').val());
                }
                var down_payment = Number($('input[name="down_payment"]').val());
                var balloting_price = Number($('input[name="balloting_price"]').val());
                var possession_price = Number($('input[name="possession_price"]').val());
                var confirmation_amount = Number($('input[name="confirmation_amount"]').val());
                var total_month_installment = Number($('input[name="total_month_installment"]').val());
                var per_month_installment = Number($('input[name="per_month_installment"]').val());
                var half_year_installment = Number($('input[name="half_year_installment"]').val());
                var quarterly_payment = Number($('input[name="quarterly_payment"]').val());
                total_amount = total_amount - down_payment - balloting_price - possession_price - confirmation_amount;
                if(half_year_installment){
                    var months = parseInt((total_month_installment / 12) * 10);
                    var half_year = parseInt((total_month_installment / 12) * 2);
                    var monthly_installment = per_month_installment * months;
                    var bi_annual = half_year_installment * half_year;
                    var calculation = total_amount - monthly_installment - bi_annual;
                    if(calculation != 0){
                        errorMsg('Payment Calculation Error');
                        return;
                    }else{
                        $('#payment_plan_form').submit();
                    }
                }else if(quarterly_payment){
                    var months = parseInt((total_month_installment / 12) * 8);
                    var quaters = parseInt((total_month_installment / 12) * 4);
                    var monthly_installment = per_month_installment * months;
                    var quarterly = quarterly_payment * quaters;
                    var calculation = total_amount - monthly_installment - quarterly;
                    if(calculation != 0){
                        errorMsg('Payment Calculation Error');
                        return;
                    }else{
                        $('#payment_plan_form').submit();
                    }
                }else{
                    var monthly_installment = per_month_installment * total_month_installment;
                    var calculation = total_amount - monthly_installment;
                    if(calculation != 0){
                        errorMsg('Payment Calculation Error');
                        return;
                    }else{
                        $('#payment_plan_form').submit();
                    }
                }
            }else{
                errorMsg('Please select type first');
                return;
            }
        });
    </script>
@endsection
