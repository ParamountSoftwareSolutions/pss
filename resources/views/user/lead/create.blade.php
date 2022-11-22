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
                                            <select class="form-control" id="selectProject" onchange="project()" name="building_id">
                                                <option value="" disabled selected> -- Select Building --</option>
                                                <option value="1">Farmhouse</option>
                                                <option value="2">Society</option>
                                                <option value="3">Building</option>
                                                <option value="4">Property</option>
                                                {{-- @if(!empty($building))
                                                    @foreach($building as $data)
                                                        <option value="{{ $data->id }}" @if($data->id == old('building_id')) selected @endif>{{ $data->name }}</option>
                                                    @endforeach
                                                @endif --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="buildingDetails">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Building Floor</label>
                                            <select class="form-control" name="buildingFloor" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Payment Plan</label>
                                            <select class="form-control" name="paymentPlan" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Units</label>
                                            <select class="form-control" name="units" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Area</label>
                                            <select class="form-control" name="area" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Building Floor</label>
                                            <select class="form-control" name="buildingFloor" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Bed</label>
                                            <select class="form-control" name="buildingFloor" required>
                                                <option label="" disabled selected>bed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Bath</label>
                                            <select class="form-control" name="bath" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Premium</label>
                                            <select class="form-control" name="premium" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="societyDetails">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" name="category" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Payment Plan</label>
                                            <select class="form-control" name="paymentPlan" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <select class="form-control" name="size" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Quatity</label>
                                            <select class="form-control" name="category" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Premium</label>
                                            <select class="form-control" name="premium" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="propertyDetails">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Payment Plan</label>
                                            <select class="form-control" name="paymentPlan" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Units</label>
                                            <select class="form-control" name="units" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <select class="form-control" name="size" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Bed</label>
                                            <select class="form-control" name="buildingFloor" required>
                                                <option label="" disabled selected>bed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Bath</label>
                                            <select class="form-control" name="bath" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Premium</label>
                                            <select class="form-control" name="premium" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="farmhouseDetails">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Payment Plan</label>
                                            <select class="form-control" name="paymentPlan" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Units</label>
                                            <select class="form-control" name="units" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <select class="form-control" name="size" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Bed</label>
                                            <select class="form-control" name="buildingFloor" required>
                                                <option label="" disabled selected>bed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Bath</label>
                                            <select class="form-control" name="bath" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Premium</label>
                                            <select class="form-control" name="premium" required>
                                                <option label="" disabled selected>Select Detail</option>
                                            </select>
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
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Father Name</label>
                                        <input type="text" class="form-control" name="father_name" autocomplete="false" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CNIC Number</label>
                                        <input type="number" class="form-control" name="cnic">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Source</label>
                                        <select class="form-control" name="source" >
                                            <option label="" disabled selected>Select Detail</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Purpose</label>
                                        <input type="text" class="form-control" name="purpose">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Bugdet From</label>
                                        <input type="number" class="form-control" name="bugdetFrom">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Bugdet To</label>
                                        <input type="number" class="form-control" name="bugdetTo">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Sales Person</label>
                                        <input type="text" class="form-control" name="salesPerson">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Client Information</label>
                                        <input type="text" class="form-control" name="clientInfo">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Country</label>
                                        <select class="form-control" name="country" >
                                            <option label="" disabled selected>Select Detail</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>State</label>
                                        <select class="form-control" name="state" >
                                            <option label="" disabled selected>Select Detail</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>City</label>
                                        <select class="form-control" name="city" >
                                            <option label="" disabled selected>Select Detail</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Phone</label>
                                        <input type="number" class="form-control" name="phone_number" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Password (Optional)</label>
                                        <input type="password" class="form-control" name="password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-md-4">
                                        <label>Address (Optional)</label>
                                        <input type="text" class="form-control" name="address">
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
<script>
    document.getElementById("farmhouseDetails").style.display="none";
    document.getElementById("societyDetails").style.display="none";
    document.getElementById("buildingDetails").style.display="none";
    document.getElementById("propertyDetails").style.display="none";
    function project(){
        var projectId = document.getElementById("selectProject").value;
        switch (projectId){
            case "1": 
            document.getElementById("farmhouseDetails").style.display="flex";
            document.getElementById("societyDetails").style.display="none";
            document.getElementById("buildingDetails").style.display="none";
            document.getElementById("propertyDetails").style.display="none";
            break;
            case "2": 
            document.getElementById("societyDetails").style.display="flex";
            document.getElementById("farmhouseDetails").style.display="none";
            document.getElementById("buildingDetails").style.display="none";
            document.getElementById("propertyDetails").style.display="none";
            break;
            case "3": 
            document.getElementById("buildingDetails").style.display="flex";
            document.getElementById("societyDetails").style.display="none";
            document.getElementById("farmhouseDetails").style.display="none";
            document.getElementById("propertyDetails").style.display="none";
            break;
            case "4": 
            document.getElementById("propertyDetails").style.display="flex";
            document.getElementById("societyDetails").style.display="none";
            document.getElementById("buildingDetails").style.display="none";
            document.getElementById("farmhouseDetails").style.display="none";
            break;
        }
    }
</script>
@endsection
@section('script')
@endsection
<!-- 
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

@endsection -->