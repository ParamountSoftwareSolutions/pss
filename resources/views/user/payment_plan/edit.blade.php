@extends('user.layout.app')
@section('title', 'Payment Plan Create')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form id="payment_plan_form" method="post" action="{{ route('payment_plan.update',['RolePrefix'=>RolePrefix(),'payment_plan'=>$id]) }}">
                            @csrf
                            @method('put')
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
                                                    <option value="{{ $data->id }}"
                                                            @if($payment_plan->project_type_id == $data->id) selected @endif
                                                    >{{ ucwords($data->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Payment Plan Name <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" value="{{$payment_plan->name}}" name="name" required>
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
                                                       name="total_price" id="total_price" value="{{$payment_plan->total_price}}" required>
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
                                                       name="commission" id="commission" value="{{$payment_plan->commission}}">
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
                                                       name="after_commission_price" value="{{$payment_plan->after_commission_price}}" readonly>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('after_commission_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Down Payment (In % or Rs.)</label>
                                            <input type="text" class="form-control" aria-label="Amount" id="down_payment_percent"
                                                   name="down_payment_percent" value="{{old('down_payment_percent', $payment_plan->down_payment_percent)}}">
                                            @error('down_payment_percent')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 down_payment">
                                            <label class="d-block">Down Payment Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount" readonly
                                                       name="down_payment"value="{{old('down_payment',$payment_plan->down_payment)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('down_payment')
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
                                                       name="discount" value="{{old('discount',$payment_plan->discount)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('discount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>Payment Information</h4>
                                    <input type="hidden" name="payment_method" value="installment">
                                    <button type="button" class="btn btn-primary baloon change_plan" data-val="baloon" style="margin-left: auto; display: block;">Baloon Payment</button>
                                    <button type="button" class="btn btn-primary install change_plan" data-val="install" style="margin-left: auto; display: block;">Installment Payment</button>
                                </div>
                                <div class="card-body baloon">
                                    <div class="row">
                                        <div class="form-group col-md-4 down_payment">
                                            <label class="d-block">Confirmation Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="confirmation_amount" value="{{old('confirmation_amount',$payment_plan->confirmation_amount)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('confirmation_amount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Balloting Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="balloting_price" value="{{old('balloting_price',$payment_plan->balloting_price)}}">
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
                                                       name="possession_price" value="{{old('possession_price',$payment_plan->possession_price)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('possession_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Choose Installment Plan</label>
                                            <select class="form-control" name="installment_plan" required>
                                                <option value="">Select Project Type</option>
                                                <option value="monthly" @if($payment_plan->installment_plan == 'monthly') selected @endif>Monthly</option>
                                                <option value="bi_anually" @if($payment_plan->installment_plan == 'bi_anually') selected @endif>Bi-Anually</option>
                                                <option value="quartrly" @if($payment_plan->installment_plan == 'quartrly') selected @endif>Quaterly</option>
                                                <option value="monthly_bi" @if($payment_plan->installment_plan == 'monthly_bi') selected @endif>Monthly + Bi-Anually</option>
                                                <option value="monthly_qa" @if($payment_plan->installment_plan == 'monthly_qa') selected @endif>Monthly + Quaterly</option>
                                            </select>
                                            @error('installment_plan')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="monthly" class="row">
                                        <div class="form-group col-md-12"><h5>Monthly</h5></div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Numbers of Installment (Monthly)</label>
                                            <input type="number" class="form-control" name="no_of_month" value="{{old('no_of_month',$payment_plan->no_of_month)}}">
                                            @error('no_of_month')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Per Month Installment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="monthly_installment"value="{{old('monthly_installment',$payment_plan->monthly_installment)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('monthly_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="bi_anually" class="row">
                                        <div class="form-group col-md-12"><h5>Bi Annually</h5></div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Numbers of Installment (Bi Annually)</label>
                                            <input type="number" class="form-control" name="no_of_half" value="{{old('no_of_half',$payment_plan->no_of_half)}}">
                                            @error('no_of_half')
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
                                                       name="half_year_installment" value="{{old('half_year_installment',$payment_plan->half_year_installment)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('half_year_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="quarterly" class="row">
                                        <div class="form-group col-md-12"><h5>Quaterly</h5></div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Numbers of Installment (Quaterly)</label>
                                            <input type="number" class="form-control" name="no_of_quarter" value="{{old('no_of_quarter',$payment_plan->no_of_quarter)}}">
                                            @error('no_of_quarter')
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
                                                       name="quarterly_installment" value="{{old('quarterly_installment',$payment_plan->quarterly_installment)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('quarterly_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 rent">
                                            <label class="d-block">Rent Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="rent_price" value="{{old('rent_price',$payment_plan->rent_price)}}">
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
                                                       name="rent_installment" value="{{old('rent_installment',$payment_plan->rent_installment)}}">
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
                                <div class="card-body install install_body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Date</label>
                                            <input type="date" min="{{date('Y-m-d')}}" class="form-control" name="baloon[0][date]">
                                        </div>
                                        <div class="form-group col-md-4 down_payment">
                                            <label class="d-block">Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control baloon_amount" name="baloon[0][amount]">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="payment_plan" class="btn btn-primary baloon" type="button">Submit</button>
                                    <button id="baloon_plan" class="btn btn-primary install" type="button">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" name="baloon_data" value="{{$payment_plan->baloon}}">
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var date = get_date();
            var project_type_id = {{$payment_plan->project_type_id}};
            var plan = "{{$payment_plan->installment_plan}}";
            installmentPlan(plan);
            getPremium(project_type_id);
            price_after_commission();
            var payment_method = "{{$payment_plan->payment_method}}";
            if(payment_method == 'installment'){
                $('.install').hide()
                $('.baloon').show()
                $('input[name="payment_method"]').val('installment');
            }else{
                $('input[name="payment_method"]').val('baloon');
                $('input[name="no_of_month"]').removeAttr('required')
                $('input[name="monthly_installment"]').removeAttr('required')
                $('input[name="no_of_half"]').removeAttr('required')
                $('input[name="half_year_installment"]').removeAttr('required')
                $('input[name="no_of_quarter"]').removeAttr('required')
                $('input[name="quarterly_installment"]').removeAttr('required')
                $('input[name="rent_price"]').removeAttr('required')
                $('input[name="rent_installment"]').removeAttr('required')
                $('.baloon').hide()
                $('.install').show()
                var baloon_data = $('input[name="baloon_data"]').val();
                if(baloon_data){
                    baloon_data = JSON.parse(baloon_data);
                }
                var count = baloon_data.length - 1;
                var btn = '<div class="add_new_btn form-group col-md-4 pb-1">' +
                    '       <input type="hidden" name="row_count" value="'+count+'">' +
                    '       <button class="btn btn-light btn-sm add_new" type="button">+</button>' +
                    '       <button class="btn btn-light btn-sm remove" type="button">-</button>' +
                    '      </div>';
                var detail = '';
                for(var i = 0; i < baloon_data.length; i++){
                    var input = '<div class="row">' +
                        '               <div class="form-group col-md-4">' +
                        '                   <label class="d-block">Date</label>' +
                        '                   <input type="date" min="'+date+'" class="form-control" name="baloon['+i+'][date]" value="'+baloon_data[i]['date']+'">' +
                        '               </div>' +
                        '               <div class="form-group col-md-4 down_payment">' +
                        '                   <label class="d-block">Amount</label>' +
                        '                   <div class="input-group mb-3">' +
                        '                       <div class="input-group-prepend">' +
                        '                           <span class="input-group-text">RS</span>' +
                        '                       </div>' +
                        '                       <input type="number" class="form-control baloon_amount" name="baloon['+i+'][amount]" value="'+baloon_data[i]['amount']+'">' +
                        '                       <div class="input-group-append">' +
                        '                           <span class="input-group-text">.00</span>' +
                        '                       </div>' +
                        '                   </div>' +
                        '               </div>' +
                        '           </div>';
                    detail = detail+input;
                }
                detail = detail+btn;
                $('.install_body').empty();
                $('.install_body').append(detail);
            }
            $('.add_new').click(function () {
                var count = Number($('input[name="row_count"]').val());
                count = count + 1;
                $('input[name="row_count"]').val(count);
                var bulk_input = '<div class="row">' +
                    '               <div class="form-group col-md-4">' +
                    '                   <label class="d-block">Date</label>' +
                    '                   <input type="date" min="'+date+'" class="form-control" name="baloon['+count+'][date]">' +
                    '               </div>' +
                    '               <div class="form-group col-md-4 down_payment">' +
                    '                   <label class="d-block">Amount</label>' +
                    '                   <div class="input-group mb-3">' +
                    '                       <div class="input-group-prepend">' +
                    '                           <span class="input-group-text">RS</span>' +
                    '                       </div>' +
                    '                       <input type="number" class="form-control baloon_amount" name="baloon['+count+'][amount]">' +
                    '                       <div class="input-group-append">' +
                    '                           <span class="input-group-text">.00</span>' +
                    '                       </div>' +
                    '                   </div>' +
                    '               </div>' +
                    '           </div>';
                $('.add_new_btn').before(bulk_input);
            })

            $('.remove').click(function () {
                var count = Number($('input[name="row_count"]').val());
                count = count - 1;
                $('input[name="row_count"]').val(count);
                $('.add_new_btn').prev().remove();
            })

            var premium = $('select[name="premium_id"] :selected').val();
            if(premium && premium != 'regular'){
                $('.commission-box').show();
                var price = Number("{{$payment_plan->after_commission_price}}");
            }else{
                $('.commission-box').hide();
                var price = Number("{{$payment_plan->total_price}}");
            }
            var downPayment = Number("{{$payment_plan->down_payment}}")
            var downPayment = downPayment * 2;
            if(downPayment >= price){
                $('input[name="rent_installment"]').attr('required');
                $('input[name="rent_price"]').attr('required');
                $('.rent').show();
                $('.rent_installment').show();
            }else{
                $('input[name="rent_installment"]').removeAttr('required');
                $('input[name="rent_price"]').removeAttr('required');
                $('.rent').hide();
                $('.rent_installment').hide();
            }
            $('select[name="project_type_id"]').change(function () {
                var type_id = $(this).val();
                getPremium(type_id);
            })
            $('select[name="premium_id"]').change(function () {
                var val = $(this).val();
                if(val !== 'regular'){
                    $('.commission-box').show();
                }else{
                    $('input[name="commission"]').val('');
                    $('input[name="after_commission_price"]').val('');
                    $('.commission-box').hide();
                }
                downPaymentPercent()
            })
            $('#commission, #total_price').on('change keypress keyup', function (e) {
                price_after_commission();
            })
            $('#commission, #total_price, #down_payment_percent').on('change keypress keyup', function () {
                downPaymentPercent();
            })
            $('select[name="installment_plan"]').change(function () {
                var plan = $(this).val();
                $('input[name="no_of_month"]').val('')
                $('input[name="monthly_installment"]').val('')
                $('input[name="no_of_half"]').val('')
                $('input[name="half_year_installment"]').val('')
                $('input[name="no_of_quarter"]').val('')
                $('input[name="quarterly_installment"]').val('')
                installmentPlan(plan);
            })
            $('#payment_plan').click(function (e) {
                e.preventDefault();
                var premium_id = $('select[name="premium_id"] option:selected').val();
                if(premium_id){
                    if (premium_id == 'regular') {
                        var total_price = Number($('input[name="total_price"]').val());
                    } else {
                        var total_price = Number($('input[name="after_commission_price"]').val());
                    }
                    var down_payment = Number($('input[name="down_payment"]').val());
                    var balloting_price = Number($('input[name="balloting_price"]').val());
                    var possession_price = Number($('input[name="possession_price"]').val());
                    var confirmation_amount = Number($('input[name="confirmation_amount"]').val());

                    var total_amount = total_price - down_payment - balloting_price - possession_price - confirmation_amount;

                    var no_of_month = Number($('input[name="no_of_month"]').val());
                    var monthly_installment = Number($('input[name="monthly_installment"]').val());
                    var no_of_half = Number($('input[name="no_of_half"]').val());
                    var half_year_installment = Number($('input[name="half_year_installment"]').val());
                    var no_of_quarter = Number($('input[name="no_of_quarter"]').val());
                    var quarterly_installment = Number($('input[name="quarterly_installment"]').val());

                    var plan = $('select[name="installment_plan"]').find(":selected").val();

                    var month = no_of_month * monthly_installment;
                    var half = no_of_half * half_year_installment;
                    var quarter = no_of_quarter * quarterly_installment;

                    var installment = 0;

                    if(plan == 'monthly'){
                        installment = month;
                    }
                    else if(plan == 'bi_anually'){
                        installment = half;
                    }
                    else if(plan == 'quartrly'){
                        installment = quarter;
                    }
                    else if(plan == 'monthly_bi'){
                        installment = month + half;
                    }
                    else if(plan == 'monthly_qa'){
                        installment = month + quarter;
                    }
                    else{
                        if(total_price > down_payment ){
                            errorMsg('Down Payment is not 100%, so installment plan is required');
                            return;
                        }else{
                            $('#payment_plan_form').submit();
                        }
                    }
                    var remaining = total_amount - installment;

                    if(remaining != 0){
                        if(!(remaining <= 100 && remaining >= -100)){
                            errorMsg('Payment plan calculation error....');
                            return;
                        }
                    }
                    $('#payment_plan_form').submit();
                }else{
                    errorMsg('Please select type first');
                    return;
                }
            });
            $('#baloon_plan').click(function (e) {
                e.preventDefault();
                var premium_id = $('select[name="premium_id"] option:selected').val();
                if(premium_id){
                    if (premium_id == 'regular') {
                        var total_price = Number($('input[name="total_price"]').val());
                    } else {
                        var total_price = Number($('input[name="after_commission_price"]').val());
                    }
                    var count = $('input[name="row_count"]').val();
                    var sum = 0;
                    for(var i = 0; i<=count; i++){
                        var amount = Number($('input[name="baloon['+i+'][amount]"]').val());
                        sum = sum + amount;
                    }
                    var remaining = total_price - sum;
                    if(remaining != 0){
                        if(!(remaining <= 100 && remaining >= -100)){
                            errorMsg('Payment plan calculation error....');
                            return;
                        }
                    }
                    $('#payment_plan_form').submit();
                }else{
                    errorMsg('Please select type first');
                    return;
                }
            });
        })
        function downPaymentPercent(){
            let commission = Number($('#commission').val());
            let totalPrice = Number($('#total_price').val());
            let comPrice = (commission / 100) * totalPrice;
            totalPrice = totalPrice+comPrice;
            let downPaymentPercent = $('#down_payment_percent').val();
            var str2 = "%";
            let downPayment = 0;
            if(downPaymentPercent.indexOf(str2) != -1){
                var percent = Number(downPaymentPercent .replace('%',''));
                downPayment = Number((percent * totalPrice) / 100);
            }else{
                downPayment = Number(downPaymentPercent);
            }
            $('input[name="down_payment"]').val(downPayment);
            downPayment = downPayment * 2;
            if(downPayment >= totalPrice){
                $('input[name="rent_installment"]').attr('required');
                $('input[name="rent_price"]').attr('required');
                $('.rent').show();
                $('.rent_installment').show();
            }else{
                $('input[name="rent_installment"]').removeAttr('required');
                $('input[name="rent_price"]').removeAttr('required');
                $('.rent').hide();
                $('.rent_installment').hide();
            }
        }
        function getPremium(id){
            $.ajax({
                url: "{{ url(RolePrefix().'/get-premium') }}/" + id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="premium_id"]').empty();
                    $('select[name="premium_id"]').append('<option value="">Please  Select</option>');
                    let old_id = '{{ $payment_plan->premium_id }}';
                    if(!old_id){
                        $('select[name="premium_id"]').append('<option selected value="regular">Regular</option>');
                    }else{
                        $('select[name="premium_id"]').append('<option value="regular">Regular</option>');
                    }
                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            let selected = value.id == old_id ? "selected" : "";
                            $('select[name="premium_id"]').append('<option ' + selected + ' value="' + value.id + '">' + value.name + '</option>');
                        });
                        let premium_id = $('select[name="premium_id"]').val();
                        if(premium_id != 'regular'){
                            $('.commission-box').show();
                        }else{
                            $('.commission-box').hide();
                        }
                    }
                },
            });
        }
        function price_after_commission(){
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
        }
        function installmentPlan(plan) {
            if(plan){
                if(plan == 'monthly'){
                    $('input[name="no_of_month"]').attr('required')
                    $('input[name="monthly_installment"]').attr('required')
                    $('input[name="no_of_half"]').removeAttr('required')
                    $('input[name="half_year_installment"]').removeAttr('required')
                    $('input[name="no_of_quarter"]').removeAttr('required')
                    $('input[name="quarterly_installment"]').removeAttr('required')
                    $('#monthly').show()
                    $('#bi_anually').hide()
                    $('#quarterly').hide()
                }
                else if(plan == 'bi_anually'){
                    $('input[name="no_of_month"]').removeAttr('required')
                    $('input[name="monthly_installment"]').removeAttr('required')
                    $('input[name="no_of_half"]').attr('required')
                    $('input[name="half_year_installment"]').attr('required')
                    $('input[name="no_of_quarter"]').removeAttr('required')
                    $('input[name="quarterly_installment"]').removeAttr('required')
                    $('#monthly').hide()
                    $('#bi_anually').show()
                    $('#quarterly').hide()
                }
                else if(plan == 'quartrly'){
                    $('input[name="no_of_month"]').removeAttr('required')
                    $('input[name="monthly_installment"]').removeAttr('required')
                    $('input[name="no_of_half"]').removeAttr('required')
                    $('input[name="half_year_installment"]').removeAttr('required')
                    $('input[name="no_of_quarter"]').attr('required')
                    $('input[name="quarterly_installment"]').attr('required')
                    $('#monthly').hide()
                    $('#bi_anually').hide()
                    $('#quarterly').show()
                }
                else if(plan == 'monthly_bi'){
                    $('input[name="no_of_month"]').attr('required')
                    $('input[name="monthly_installment"]').attr('required')
                    $('input[name="no_of_half"]').attr('required')
                    $('input[name="half_year_installment"]').attr('required')
                    $('input[name="no_of_quarter"]').removeAttr('required')
                    $('input[name="quarterly_installment"]').removeAttr('required')
                    $('#monthly').show()
                    $('#bi_anually').show()
                    $('#quarterly').hide()
                }
                else if(plan == 'monthly_qa'){
                    $('input[name="no_of_month"]').attr('required')
                    $('input[name="monthly_installment"]').attr('required')
                    $('input[name="no_of_half"]').removeAttr('required')
                    $('input[name="half_year_installment"]').removeAttr('required')
                    $('input[name="no_of_quarter"]').attr('required')
                    $('input[name="quarterly_installment"]').attr('required')
                    $('#monthly').show()
                    $('#bi_anually').hide()
                    $('#quarterly').show()
                }
                else{
                    $('input[name="no_of_month"]').removeAttr('required')
                    $('input[name="monthly_installment"]').removeAttr('required')
                    $('input[name="no_of_half"]').removeAttr('required')
                    $('input[name="half_year_installment"]').removeAttr('required')
                    $('input[name="no_of_quarter"]').removeAttr('required')
                    $('input[name="quarterly_installment"]').removeAttr('required')
                    $('#monthly').hide()
                    $('#bi_anually').hide()
                    $('#quarterly').hide()
                }
            }
        }
    </script>
@endsection
