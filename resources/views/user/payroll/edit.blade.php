@extends('user.layout.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="post" action="{{ route('payroll.updatePayroll', ['RolePrefix' => RolePrefix(), $employee->id]) }}">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input type="text" class="form-control" name="name" readonly="true"
                                                       value="{{ old('name', $employee->name) }}">
                                                @error('name')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Salary Amount</label>
                                            <input type="number" class="form-control" name="amount"
                                                   value="{{ old('amount', $employee->amount) }}">
                                            @error('amount')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Payment Method</label>
                                            <input type="text" class="form-control" name="payment_mode" 
										    	value="{{ old('payment_mode', $employee->payment_method) }}">
                                            @error('payment_mode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
										<div class="form-group col-md-4">
                                            <label>Working Days</label>
											<input type="number" class="form-control" name="working_days"
												   value="{{ old('working_days', $employee->working_days ?? 0) }}">
                                            @error('payment_mode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
										<div class="form-group col-md-4">
                                            <label>Present Days</label>
											<input type="number" class="form-control" name="present_days"
												   value="{{ old('present_days', $employee->present_days ?? 0) }}">
                                            @error('payment_mode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
										<div class="form-group col-md-4">
                                            <label>Absent Days</label>
											<input type="number" class="form-control" name="absent_days"
												   value="{{ old('absent_days', $employee->absent_days ?? 0) }}">
                                            @error('payment_mode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
										<div class="form-group col-md-4">
                                            <label>Advance</label>
											<input type="number" class="form-control" name="advance"
												   value="{{ old('advance', $employee->advance ?? 0) }}">
                                            @error('payment_mode')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
										<div class="form-group col-md-4">
                                            <label>Total Leaves</label>
											<input type="number" class="form-control" name="total_leaves"
												   value="{{ old('total_leaves', $employee->total_leaves ?? 0) }}">
                                            @error('total_leaves')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
										<div class="form-group col-md-4">
                                            <label>Leaves Approved</label>
											<input type="number" class="form-control" name="leaves_approved"
												   value="{{ old('leaves_approved', $employee->leaves_approved ?? 0) }}">
                                            @error('leaves_approved')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Submit</button>
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
            $(".commission").hide();
            if({{ $employee->job_title == 'sale_person'}}){
                $(".commission").show();
            }
            else {
                $(".commission").hide();
                $(".password").hide();
            }
            // Hide displayed paragraphs
            $('select[name="job_title"]').on('change', function () {
                var job_title = $(this).val();
                if(job_title == 'sale_person'){
                    $(".commission").show();
                    $(".password").hide();
                } else if(job_title == 'accountant'){
                    $(".password").hide();
                    $(".commission").hide();
                } else{
                    $(".commission").hide();
                    $(".password").hide();
                }
            });
        });
    </script>
@endsection
