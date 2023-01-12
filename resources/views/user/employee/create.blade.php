@extends('user.layout.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form method="post" action="{{ route('employee.store', ['RolePrefix' => RolePrefix()]) }}">
                            @csrf
                            <div class="card-header">
                                <h4>Basic Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>User Name <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Account Number</label>
                                        <input type="text" class="form-control" name="account_no" value="{{ old('account_no') }}">
                                        @error('account_no')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Project <small style="color: red">*</small></label>
                                            <select class="form-control" name="building_id" required>
                                                <option label="" disabled>Select Project</option>
                                                @foreach ($projects as $data)
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
                                        <label>Email <small style="color: red">*</small></label>
                                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                        @error('address')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CNIC Number <small style="color: red">*</small></label>
                                        <input type="number" class="form-control" name="cnic" value="{{ old('cnic') }}" required>
                                        @error('cnic')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Salary</label>
                                        <input type="number" class="form-control" name="salary" value="{{ old('salary') }}">
                                        @error('salary')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Document</label>
                                        <input type="file" class="form-control" name="document">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Phone Number <small style="color: red">*</small></label>
                                        <input type="number" class="form-control" name="phone_number" value="{{ old('phone_number') }}" required>
                                        @error('phone_number')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Employee Job <small style="color: red">*</small></label>
                                            <select class="form-control" name="job_title" required>
                                                <option label="" disabled selected>Select Employee Job</option>
                                                <option value="sale_person">Sale Person</option>
                                                <option value="office_staff">Office Staff</option>
                                                <option value="accountant">Accountant</option>
                                                <option value="property_manager">Property Manager</option>
                                                <option value="sale_manager">Sale Manager</option>
                                            </select>
                                            @error('job_title')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="">Working Days <span class="text-danger">*</span></label>
                                        <input class="form-control" type="number" id="number" name="working_days">
                                    </div>
                                    <div class="form-group col-md-4 commission">
                                        <label>Commission</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    %
                                                </div>
                                            </div>
                                            <input type="number" class="form-control currency" name="commission">
                                        </div>
                                        @error('commission')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4 password">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                                        @error('password')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 sale-manager">
                                        <div class="form-group">
                                            <label>Sale Manager</label>
                                            <select class="form-control" id="sale_manager_id" name="sale_manager_id" required>
                                                <option label="" disabled selected>Select Sale Manager</option>
                                                {{-- @foreach ($sale_manager as $data)
                                                        <option value="{{ $data->id }}">{{ $data->username }}
                                                </option>
                                                @endforeach --}}
                                            </select>
                                            @error('sale_manager_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
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
   $('select[name="job_title"]').on('change', function() {
                var job_title = $(this).val();
                if (job_title == 'sale_person') {
                    $(".commission").show();
                    // $(".sale-manager").show();
                    $(".password").show();
                } else if (job_title == 'accountant') {
                    $(".password").show();
                    $(".commission").hide();
                    $(".sale-manager").hide();
                } else if (job_title == 'sale_manager') {
                    $(".password").show();
                    $(".commission").hide();
                    $(".sale-manager").hide();
                } else if (job_title == 'property_managers') {
                    $(".password").show();
                    $(".commission").hide();
                    $(".sale-manager").hide();
                } else{
                    $(".commission").hide();
                    $(".password").hide();
                    $(".sale-manager").hide();
                }
            });
</script>
@endsection