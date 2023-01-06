@extends('user.layout.app')
@section('title', 'Payment Plan Create')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('dealer.update',['RolePrefix'=>RolePrefix(),'dealer'=>$dealer->id]) }}">
                            @method('put')
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Name <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="name" value="{{$dealer->name}}" required>
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">CNIC <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="cnic" value="{{$dealer->cnic}}" required>
                                            @error('cnic')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Phone Number <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="number" value="{{$dealer->number}}" required>
                                            @error('number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Address <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="address" value="{{$dealer->address}}" required>
                                            @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Agency <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="agency" value="{{$dealer->agency}}" required>
                                            @error('agency')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Actual Amount <small style="color: red">*</small></label>
                                            <input type="number" class="form-control" name="actual_amount" value="{{$dealer->actual_amount}}" required>
                                            @error('actual_amount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Rebate <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="rebate" value="{{$dealer->rebate}}" required>
                                            @error('rebate')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Received Amount</label>
                                            <input type="number" class="form-control" name="received" value="{{$dealer->received}}">
                                            @error('received')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Pending Amount</label>
                                            <input type="number" class="form-control" readonly name="pending" value="{{$dealer->pending}}">
                                            @error('pending')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Email</label>
                                            <input type="text" class="form-control" name="email" value="{{$dealer->email}}">
                                            @error('email')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Alternative Phone Number</label>
                                            <input type="text" class="form-control" name="alt_number" value="{{$dealer->alt_number}}">
                                            @error('alt_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Submit</button>
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
    <script type="text/javascript" src="{{ asset('assets/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        // State Select
        $(document).ready(function () {
            $('input[name="actual_amount"],input[name="rebate"],input[name="received"]')
                .on('keyup kepress change',function () {
                    var actual_amount = Number($('input[name="actual_amount"]').val());
                    var rebate_amount = $('input[name="rebate"]').val();
                    var received_amount = Number($('input[name="received"]').val());
                    if(actual_amount){
                        var str2 = "%";
                        if(rebate_amount.indexOf(str2) != -1){
                            var rb = Number(rebate_amount.replace('%',''));
                            var rebate = (rb * actual_amount) / 100;
                        }else{
                            rebate = Number(rebate_amount);
                        }
                        var pending = actual_amount - rebate - received_amount;
                        $('input[name="pending"]').val(pending);
                    }else{
                        $('input[name="pending"]').val(0);
                    }
                })
            $('input[name="actual_amount"]').on('keyup kepress change',function () {
                var actual_amount = $(this).val();
                $('input[name="received"]').attr('max',actual_amount);
            })
        });
    </script>
@endsection
