@extends('user.layout.app')
@section('title', 'Add Lead')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form method="POST" action="{{route('leads.store', ['RolePrefix' => RolePrefix()])}}">
                        <div class="card">
                            @csrf
                            <div class="card-header">
                                <h4>Basic Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Project List <small style="color: red">*</small></label>
                                            <select class="form-control" name="building_id">
                                                <option value=""> -- Select Building --</option>
                                                @if(!empty($building))
                                                @foreach($building as $data)
                                                <option value="{{ $data->id }}" @if($data->id == old('building_id')) selected @endif>{{ $data->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @error('building_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Budget</label>
                                        <input type="text" class="form-control" name="budget">
                                        @error('budget')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Source <small style="color: red">*</small></label>
                                            <select class="form-control" name="source" required>
                                                <option label="" disabled selected>Select Detail</option>
                                                <option value="walk_in">Walk In</option>
                                                <option value="call">Call</option>
                                                <option value="reference">Reference</option>
                                                <option value="social_media">Social Media</option>
                                            </select>
                                            @error('source')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Sales Person<small style="color: red">*</small></label>
                                            <select class="form-control" name="sale_person_id" id="sale_person_id">
                                                <option value="">Select Sales Person</option>
                                                @if(!empty($sale_person))
                                                @foreach($sale_person as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->username }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @error('sale_person_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Client Information</h4>
                            </div>
                            {{-- New Client Form --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Name <small style="color: red">*</small></label>
                                        <input type="text" class="form-control" name="name" autocomplete="false" required value="{{ old('name') }}">
                                        @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Father Name</label>
                                        <input type="text" class="form-control" name="father_name" autocomplete="false" value="{{ old('name') }}">
                                        @error('father_name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CNIC Number</label>
                                        <input type="number" class="form-control" name="cnic" autocomplete="off">
                                        @error('cnic')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email">
                                        @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Phone <small style="color: red">*</small></label>
                                        <input type="number" class="form-control" name="phone_number" required>
                                        @error('phone_number')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Password (Optional)</label>
                                        <input type="password" class="form-control" name="password" autocomplete="off">
                                        @error('password')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-md-4">
                                        <label>Address (Optional)</label>
                                        <input type="text" class="form-control" name="address">
                                        @error('address')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <input class="btn btn-primary" type="submit" value="Submit">
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

@endsection