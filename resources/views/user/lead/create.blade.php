@extends('user.layout.app')
@section('title', 'Add Lead')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form method="POST" action="{{ route('leads.store', ['RolePrefix' => RolePrefix()]) }}" novalidate>
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>Basic Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Project List <small style="color: red">*</small></label>
                                            <select class="form-control" id="selectProject" onchange="{project(); submitForm()}" name="building_id">
                                                <option value="">Select Project ...</option>
                                                @if (!empty($projects))
                                                @foreach ($projects as $data)
                                                <option value="{{ $data }}">{{ $data->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="projectDetails">
                                    <div class="form-group col-md-4" id="size">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <select class="form-control" name="size" id="selectSize" required>
                                                <option label="" disabled selected>Select Size ...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="premium">
                                        <div class="form-group">
                                            <label>Premium</label>
                                            <select class="form-control" name="premium" id="selectPremium" required>
                                                <option label="" disabled selected>Select Premium ...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="buildingfloor">
                                        <div class="form-group">
                                            <label>Building Floor</label>
                                            <select class="form-control" name="buildingFloor" id="selectBuildingFloor" required>
                                                <option label="" disabled selected>Select Building Floor ...
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="selectBuildingFloorInventoryHide">
                                            <div class="form-group">
                                                <label>Building Floor Invetory</label>
                                                <select class="form-control" name="inventory_id" id="selectBuildingFloorInventory" required>
                                                    <option label="" selected>Select Building Floor Invetory ... </option>
                                                </select>
                                            </div>
                                        </div>
                                    <div class="form-group col-md-4" id="quantity">
                                        <div class="form-group">
                                            <label>Quatity</label>
                                            <select class="form-control" name="quantity" id="selectQuantity" required>
                                                <option label="" disabled selected>Select Quantity ...</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="type">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select class="form-control" name="type" id="selectType" required>
                                                <option label="" disabled selected>Select Type ...</option>
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
                                        <select class="form-control" name="source">
                                            <option label="" disabled selected>Select Detail</option>
                                            <option value="Walk In">Walk In</option>
                                            <option value="Call">Call</option>
                                            <option value="Reference">Reference</option>
                                            <option value="Social Media">Social Media</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Purpose</label>
                                        <input type="text" class="form-control" name="purpose">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Interested In</label>
                                        <input type="text" class="form-control" name="interested">
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
                                        <select class="form-control" name="sale_person_id">
                                            <option value="" disabled selected>Select Sale Person ...
                                            </option>
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
                                            <option label="" value="" selected>Select Detail</option>
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
                                            <option label="" disabled selected>Select Detail</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>City</label>
                                        <select class="form-control" name="city">
                                            <option label="" disabled selected>Select Detail</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Your Email">
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
@endsection
@section('script')
<script>
    $(document).ready(function() {
//Building Inventory
        // Bulding Invertory
        $('select[name="buildingFloor"]').on('change', function() {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/building_inventory') }}/" + id,
                    type: "GET",
                    // dataType: "json",
                    success: function(response) {
                        var data = JSON.parse(response);
                        $.each(data, function(i, item) {
                            $('#selectBuildingFloorInventory').append($('<option>', {
                                value: item.id,
                                text: item.unit_id
                            }));
                        });
                        // data.forEach(element => {
                        //     var options = document.createElement('option');
                        //     options.text = element.id;
                        //     options.value = element.id;
                        //     const select = document.getElementById('selectBuildingFloorInventory');
                        //     select.appendChild(options);
                        // });
                    },
                });
            } else {
                alert('Building Floor Data Found');
            }
        });



        $('select[name="country"]').on('change', function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/state') }}/" + country_id,
                    // url: "{{route('state', ['RolePrefix' => RolePrefix(),2])}}",
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
    document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
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
                        option.value = element.id;
                        document.getElementById("selectType").append(option);
                    });
                } else if (project.type_id == 2) {
                    size.forEach(element => {
                        console.log(element.name);
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
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "block";
                break;
            case 2:
                document.getElementById("size").style.display = "block";
                document.getElementById("quantity").style.display = "block";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("premium").style.display = "block";
                document.getElementById("type").style.display = "none";
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
                break;
            case 3:
                document.getElementById("size").style.display = "block";
                document.getElementById("quantity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("premium").style.display = "block";
                document.getElementById("type").style.display = "none";
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
                break;
            case 4:
                document.getElementById("size").style.display = "block";
                document.getElementById("quantity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("premium").style.display = "none";
                document.getElementById("type").style.display = "none";
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
                break;
        }
    }
</script>
@endsection