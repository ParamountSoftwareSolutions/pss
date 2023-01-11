@extends('user.layout.app')
@section('title', 'Add New Employee')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="post" action="{{ route('property_manager.employee_payroll.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input type="text" class="form-control" name="name" required
                                                       value="{{ old('name') }}">
                                                @error('name')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Account Number</label>
                                            <input type="text" class="form-control" name="account_no"
                                                   value="{{ old('account_no') }}">
                                            @error('account_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Building</label>
                                                <select class="form-control" name="building_id" required>
                                                    <option label="" disabled>Select Building</option>
                                                    @foreach($building as $data)
                                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('building_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{ old('email') }}">
                                            @error('email')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address"
                                                   value="{{ old('address') }}">
                                            @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>CNIC Number</label>
                                            <input type="text" class="form-control" name="cnic" required 
                                                   value="{{ old('cnic') }}">
                                            @error('cnic')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Salary</label>
                                            <input type="number" class="form-control" name="salary" required
                                                   value="{{ old('salary') }}">
                                            @error('salary')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Document</label>
                                            <input type="file" class="form-control" name="document">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control" name="phone_number" required 
                                                   value="{{ old('phone_number') }}">
                                            @error('phone_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Employee Job</label>
                                                <select class="form-control" name="job_title" required>
                                                    <option label="" disabled selected>Select Employee Job</option>
                                                    <option value="sale_person">Sale Person</option>
                                                    <option value="office_staff">Office Staff</option>
                                                    <option value="accountant">Accountant</option>
                                                </select>
                                                @error('job_title')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 commission">
                                            <label>Commission</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        %
                                                    </div>
                                                </div>
                                                <input type="number" class="form-control currency" name="commission" required>
                                            </div>
                                            @error('commission')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 password">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" required
                                                   value="{{ old('password') }}">
                                            @error('password')
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
            $(".password").hide();
            // Hide displayed paragraphs
            $('select[name="job_title"]').on('change', function () {
                var job_title = $(this).val();
                if(job_title == 'sale_person'){
                    $(".commission").show();
                    $(".password").show();
                } else if(job_title == 'accountant'){
                    $(".password").show();
                    $(".commission").hide();
                } else{
                    $(".commission").hide();
                    $(".password").hide();
                }
            });
        });
    </script>
@endsection
