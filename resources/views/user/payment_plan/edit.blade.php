@extends('user.layout.app')
@section('title', 'Payment Plan Edit')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form id="payment_plan_form" method="post" action="{{ route('payment_plan.update',['RolePrefix' => RolePrefix(),'payment_plan'=>$payment_plan->id]) }}">
                                @csrf
                                @method('put')
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
                                                    <option value="{{ $data->id }}" {{$payment_plan->project_type_id == $data->id ? 'selected' : ''}}>{{ ucwords($data->name) }}</option>
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
                                            <label class="d-block">Monthly Installment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="per_month_installment" id="per_month_installment" value="{{$payment_plan->per_month_installment}}">
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
                                                       name="half_year_installment" id="half_year_installment" value="{{$payment_plan->half_year_installment}}">
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
                                                       name="quarterly_payment" id="quarterly_payment" value="{{$payment_plan->quarterly_payment}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('quarterly_payment')
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
                                                       name="balloting_price" value="{{$payment_plan->balloting_price}}" required>
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
                                                       name="possession_price" value="{{$payment_plan->possession_price}}" required>
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
                                            <input type="number" class="form-control" name="total_month_installment" value="{{$payment_plan->total_month_installment}}" required>
                                            @error('total_month_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Rent Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="rent_price" value="{{$payment_plan->rent_price}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('rent_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Confirmation Amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="confirmation_amount" value="{{$payment_plan->confirmation_amount}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('confirmation_amount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Number Of Payments</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="number_of_payment" value="{{$payment_plan->number_of_payment}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('number_of_payment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Down Payment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="booking_price" value="{{$payment_plan->booking_price}}" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('booking_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Premium Type</label>
                                                <select class="form-control" name="premium_id" required>
                                                    <option value="">Select Premium Type</option>
                                                    @foreach($project_type as $data)
                                                        <option value="{{ $data->id }}">{{ ucwords($data->nature) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('nature')
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
                                            @error('number_of_payment')
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
                                                       name="price_after_commission" id="price_after_commission" disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('price_after_commission')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="payment_plan" class="btn btn-primary" type="button">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var project_type_id = {{$payment_plan->project_type_id}};
            getPremium(project_type_id);
            price_after_commission();
            $('select[name="project_type_id"]').change(function () {
                var type_id = $(this).val();
                getPremium(type_id);
                return;
            })
            $('select[name="premium_id"]').change(function () {
                var val = $(this).val();
                if(val){
                    $('.commission-box').show();
                }else{
                    $('.commission-box').hide();
                }
            })
            $('#commission, #total_price').on('change keypress keyup', function (e) {
                price_after_commission();
            })


            $('#payment_plan').click(function () {
                let a = $('#per_month_installment').val();
                let b = $('#per_month_installment').val();
                let c = $('#per_month_installment').val();
                if(!a || !b || !c){
                    errorMsg('You Have To Choose One of Three Given Installments')
                }else{
                    $('#payment_plan_form').submit();
                }
            })
        })
        function getPremium(id){
            $.ajax({
                url: "{{ url(RolePrefix().'/get-premium') }}/" + id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="premium_id"]').empty();
                    if (data.length === 0) {
                        $('select[name="premium_id"]').append('<option value="">N/A</option>');
                        $('.commission-box').hide();
                    } else {
                        $('select[name="premium_id"]').append('<option value="">Please  Select</option>');
                        $.each(data, function (key, value) {
                            let old_id = '{{ $payment_plan->premium_id }}';
                            let selected = value.id == old_id ? "selected" : "";
                            $('select[name="premium_id"]').append('<option ' + selected + ' value="' + value.id + '">' + value.name + '</option>');
                        });
                        let premium_id = $('select[name="premium_id"]').val();
                        if(premium_id){
                            $('.commission-box').show();
                        }else{
                            $('.commission-box').hide();
                        }
                    }
                },
            });
        }
        function price_after_commission(){
            let commission = $('#commission').val();
            let totalPrice = $('#total_price').val();
            let comPrice = (commission / 100) * totalPrice;
            let afterComPrice = (Number(totalPrice) + Number(comPrice));
            $('#price_after_commission').val(afterComPrice);
        }
    </script>
@endsection
