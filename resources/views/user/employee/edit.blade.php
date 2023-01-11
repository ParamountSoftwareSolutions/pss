@extends('user.layout.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="post" action="{{ route('employee.update', ['RolePrefix' => RolePrefix() , $employee->id]) }}">
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
                                                <input type="text" class="form-control" name="name"
                                                       value="{{ old('name', $employee->username) }}">
                                                @error('name')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Account Number</label>
                                            <input type="text" class="form-control" name="account_no"
                                                   value="{{ old('account_no', $employee->building_employee->account_no ?? 0) }}">
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
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email"
                                                   value="{{ old('email', $employee->email) }}">
                                            @error('email')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Phone Number</label>
                                            <input type="text" class="form-control" name="phone_number"
                                                   value="{{ old('phone_number', $employee->phone_number) }}">
                                            @error('phone_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address"
                                                   value="{{ old('address', $employee->building_employee->address ?? 0) }}">
                                            @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Salary</label>
                                            <input type="text" class="form-control" name="salary"
                                                   value="{{ old('salary', $employee->building_employee->salary ?? 0) }}">
                                            @error('salary')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>CNIC Number</label>
                                            <input type="text" class="form-control" name="cnic"
                                                   value="{{ old('cnic', $employee->building_employee->cnic ?? 0) }}">
                                            @error('cnic')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Document</label>
                                            <input type="file" class="form-control" name="document">
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
                                                </select>
                                                @error('job_title')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="">Working Days <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="number"
                                                name="working_days">
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
