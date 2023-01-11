@extends('user.layout.app')
@section('title', 'Edit Sale')
@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <form method="POST" action="{{route('leads.update', ['RolePrefix' => RolePrefix(),$lead->id])}}">
            <div class="card mt-3">
                @csrf
                @method('put')
                <div class="card-header">
                    <h4>Basic Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label>Project List</label>
                                <select class="form-control" id="selectProject" onchange="{project(); submitForm()}" name="building_id">
                                    @if(!empty($lead['project_id']))
                                    <option value="{{ $lead['project_id'] }}" selected>{{ ($lead['project_id'])?$project->name:"" }}</option>
                                    @endif
                                    <option label="" disabled>Select Detail</option>
                                    @if (!empty($projects))
                                    @foreach ($projects as $data)
                                    <option value="{{ $data }}">{{ $data->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('project_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row" id="projectDetails">
                        <div class="form-group col-md-4" id="size">
                            <div class="form-group">
                                <label>Size</label>
                                <select class="form-control" name="size" id="selectSize">
                                    <option label="" disabled>Select Size ...</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4" id="premium">
                            <div class="form-group">
                                <label>Premium</label>
                                <select class="form-control" name="premium" id="selectPremium">
                                    <option label="" disabled>Select Premium ...</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4" id="buildingfloor">
                            <div class="form-group">
                                <label>Building Floor</label>
                                <select class="form-control" name="buildingFloor" id="selectBuildingFloor">
                                    <option label="" disabled>Select Building Floor ...
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4" id="quantity">
                            <div class="form-group">
                                <label>Quatity</label>
                                <select class="form-control" name="quantity" id="selectQuantity">
                                    <option label="" disabled>Select Quantity ...</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4" id="type">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="type" id="selectType">
                                    <option label="" disabled>Select Type ...</option>
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
                            <input type="text" class="form-control" name="name" autocomplete="false" required value="{{ $lead->name }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Father Name</label>
                            <input type="text" class="form-control" name="father_name" autocomplete="false" value="{{ $lead->father_name }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>CNIC Number</label>
                            <input type="number" class="form-control" name="cnic" value="{{ $lead->cnic }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Source</label>
                            <select class="form-control" name="source" value="{{ $lead->source }}">
                                <option label="" disabled>Select Detail</option>
                                <option value="Call">Call</option>
                                <option value="Reference">Reference</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Purpose</label>
                            <input type="text" class="form-control" name="purpose" value="{{ $lead->purpose }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Bugdet From</label>
                            <input type="number" class="form-control" name="bugdetFrom" value="{{ $lead->budget_from }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Bugdet To</label>
                            <input type="number" class="form-control" name="bugdetTo" value="{{ $lead->budget_to }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Sales Person</label>
                            <select class="form-control" name="sale_person_id" value="{{ $lead->sale_person_id }}">
                                @if(!empty($lead['user_id']))
                                <option value="{{ $lead['user_id'] }}" selected>{{ ($lead['user_id'])? $user->name:"" }}</option>
                                @endif
                                <option value="" disabled>Select Sale Person ...</option>
                                @if (!empty($sale_persons))
                                @foreach ($sale_persons as $sale_person_val)
                                <option value="{{ $sale_person_val->id }}">{{ $sale_person_val->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- <div class="form-group col-md-4">
                            <label>Client Information</label>
                            <input type="text" class="form-control" name="clientInfo">
                        </div> -->
                        <div class="form-group col-md-4">
                            <label>Country</label>
                            <select class="form-control" name="country">
                                @if(!empty($lead['country_id ']))
                                <option value="{{ $lead['country_id'] }}" selected>{{ ($lead['country_id'])?$countrys->name:"" }}</option>
                                @endif
                                <option label="" value="">Select Detail</option>
                                @if (!empty($country))
                                @foreach ($country as $country_value)
                                <option value="{{$country_value->id}}">{{$country_value->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>State</label>
                            <select class="form-control" name="state">
                                @if(!empty($state->id))
                                <option value="{{ $state->id }}" selected>{{ ($state->id)?$state->name:"" }}</option>
                                @endif
                                <option label="" disabled>Select Detail</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>City</label>
                            <select class="form-control" name="city">
                                @if(!empty($lead['city_id']))
                                <option value="{{ $lead['city_id'] }}" selected>{{ ($lead['city_id'])?$city->name:"" }}</option>
                                @endif
                                <option label="" disabled>Select Detail</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $lead['email'] }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Phone</label>
                            <input type="number" class="form-control" name="number" required value="{{ $lead['number'] }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Address (Optional)</label>
                            <input type="text" class="form-control" name="address" value="{{ $lead['location'] }}">
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

@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('select[name="country"]').on('change', function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: "{{route('state', ['RolePrefix' => RolePrefix(),2])}}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="state"]').empty();
                        if (data.length === 0) {
                            $('select[name="state"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="state"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="state"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });
        // City Select
        $('select[name="state"]').on('change', function() {
            var state = $(this).val();
           
            if (state) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/city') }}/" + state,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('select[name="city"]').empty();
                        if (data.length === 0) {
                            $('select[name="city"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="city"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="city"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });
    });
    document.getElementById("size").style.display = "none";
    document.getElementById("quantity").style.display = "none";
    document.getElementById("buildingfloor").style.display = "none";
    document.getElementById("premium").style.display = "none";
    document.getElementById("type").style.display = "none";
    // array.forEach(element => {

    // });

    function submitForm() {
        // var project = document.getElementById("selectProject").value;
        var project = document.getElementById("selectProject").value;

        project = JSON.parse(project);
        $.ajax({
            url: "{{ route('lead.getInventory', ['RolePrefix' => RolePrefix()]) }}",
            data: {
                id: project.id,
                type_id: project.type_id,
                _token: $('#csrf-token')[0].content
            },
            method: 'POST',
            cache: false,
            success: function(response) {
                var data = JSON.parse(response);
                console.log(data);
                var size = data[0];
                var floor = data[1];
                var type = data[2];
                var premium = data[3];
                
                $('#selectSize').empty();
                $('#selectBuildingFloor').empty();
                $('#selectType').empty();
                $('#selectPremium').empty();
                if (project.type_id == 1) {
                    size.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name + " " + element.unit;
                        option.value = element.id;
                        document.getElementById("selectSize").append(option);
                    });
                    floor.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name;
                        option.value = element.id;
                        document.getElementById("selectBuildingFloor").append(option);
                    });
                    type.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name;
                        option.value = element;
                        document.getElementById("selectType").append(option);
                    });
                } else if (project.type_id == 2) {
                    size.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name + " " + element.unit;
                        option.value = element.id;
                        document.getElementById("selectSize").append(option);
                    });
                    premium.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name;
                        option.value = element.id;
                        document.getElementById("selectPremium").append(option);
                    });
                } else if (project.type_id == 3) {
                    size.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name + " " + element.unit;
                        option.value = element.id;
                        document.getElementById("selectSize").append(option);
                    });
                    premium.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name;
                        option.value = element.id;
                        document.getElementById("selectPremium").append(option);
                    });
                }
            }
        });
    }

    function project() {
        var project = document.getElementById("selectProject").value;
        project = JSON.parse(project);
        switch (project.type_id) {
            case 1:
                document.getElementById("size").style.display = "block";
                document.getElementById("quantity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "block";
                document.getElementById("premium").style.display = "none";
                document.getElementById("type").style.display = "block";
                break;
            case 2:
                document.getElementById("size").style.display = "block";
                document.getElementById("quantity").style.display = "block";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("premium").style.display = "block";
                document.getElementById("type").style.display = "none";
                break;
            case 3:
                document.getElementById("size").style.display = "block";
                document.getElementById("quantity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("premium").style.display = "block";
                document.getElementById("type").style.display = "none";
                break;
            case 4:
                document.getElementById("size").style.display = "block";
                document.getElementById("quantity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("premium").style.display = "none";
                document.getElementById("type").style.display = "none";
                break;
        }
    }
</script>
@endsection