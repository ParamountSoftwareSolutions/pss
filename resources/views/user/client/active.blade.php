@extends('user.layout.app')
@section('title', 'Add Client')
@section('style')

@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form method="POST" action="{{ route('clients.active', ['RolePrefix' => RolePrefix(), $client->id]) }}" novalidate>
                        @csrf
                        <!-- @method('PUT') -->
                        <?php if ($client->inventory_id) { ?>
                            <input type="hidden" name="client_inventory_id" value="{{$client->inventory_id}}">
                            <input type="hidden" name="project_id" value="{{$client->project_id}}">
                            <input type="hidden" name="project_type_id" value="{{$client->project_type_id}}">
                        <?php } else { ?>
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
                                                    <option value="" selected disabled>Select Project ...</option>
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
                                        <!-- Building -->
                                        <div class="form-group col-md-4" id="buildingfloor">
                                            <div class="form-group">
                                                <label>Building Floor</label>
                                                <select class="form-control" name="buildingFloor" id="selectBuildingFloor" required>
                                                    <option label="" selected>Select Building Floor ...
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" id="selectBuildingFloorInventoryHide">
                                            <div class="form-group">
                                                <label>Building Floor Invetory</label>
                                                <select class="form-control" name="building_inventory_id" id="selectBuildingFloorInventory" required>
                                                    <option label=""  value="" selected>Select Building Floor Invetory ... </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Building -->
                                        <!-- Society -->

                                        <div class="form-group col-md-4" id="premiumSocity">
                                            <div class="form-group">
                                                <label>Society Block</label>
                                                <select class="form-control" name="societyBlock" id="selectPremiumScocity" required>
                                                    <option label=""  value=""  selected>Select Society Block ...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" id="blockSocity">
                                            <div class="form-group">
                                                <label>Society Inventory</label>
                                                <select class="form-control" name="society_inventory_id" id="selectblock_id" required>
                                                    <option label="" value="" selected>Select Society Inventory ...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Society -->

                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        <div class="card">
                            <div class="card-header">
                                <h4>Client Information</h4>
                                <!-- <button class="btn btn-primary new-client" style="margin-left: auto; display: block;" type="button">New Client
                                </button> -->
                                <!-- <button class="btn btn-primary old-client" style="margin-left: 5px; display: block;" type="button">Old Client
                                </button> -->
                            </div>
                            <input type="hidden" name="client_type" value="new">
                            {{-- New Client Form --}}
                            <div class="card-body new-client-form">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Name <small style="color: red">*</small></label>
                                        <input type="text" class="form-control" name="name_new" autocomplete="false" required value="{{$client->name}}">
                                        @error('name_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Father Name <small style="color: red">*</small></label>
                                        <input type="text" class="form-control" name="father_name_new" autocomplete="false" required value="{{$client->father_name}}">
                                        @error('fathername_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CNIC Number <small style="color: red">*</small></label>
                                        <input type="number" class="form-control" name="cnic_new" autocomplete="off" required value="{{$client->cnic}}">
                                        @error('cnic_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Email <small style="color: red">*</small></label>
                                        <input type="email" class="form-control" name="email_new" required value="{{$client->email}}">
                                        @error('email_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Password <small style="color: red">*</small></label>
                                        <input type="password" class="form-control" name="password_new" autocomplete="off" required value="{{$client->password}}">
                                        @error('password_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Phone <small style="color: red">*</small></label>
                                        <input type="number" class="form-control" name="phone_number_new" required value="{{$client->number}}">
                                        @error('phone_number_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Alternative Phone (Optional)</label>
                                        <input type="text" class="form-control" name="alt_phone_new" autocomplete="off" value="{{$client->alt_phone}}">
                                        @error('alt_phone_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Sales Person</label>
                                        <select class="form-control" name="sale_person_id" required>
                                            @if(!empty($client->user_id ))
                                            <option value="{{$client->user_id }}" selected>{{$client->sale_person->name }}</option>
                                            @endif
                                            <option value="" disabled>Select Sale Person ...</option>

                                            @if (!empty($sale_persons))
                                            @foreach ($sale_persons as $sale_person_val)
                                            <option value="{{ $sale_person_val->id }}">{{ $sale_person_val->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Down Payment<small style="color: red">*</small></label>
                                        <input type="number" class="form-control" name="down_payment" required value="{{$client->down_payment}}">
                                        @error('down_payment')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Address <small style="color: red">*</small></label>
                                        <input type="text" class="form-control" name="address_new" autocomplete="off" required value="{{$client->address}}">
                                        @error('address_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Date of birth <small style="color: red">*</small></label>
                                        <input type="date" class="form-control" name="dob_new" autocomplete="off" required value="{{$client->dob}}">
                                        @error('dob_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="country">Country <small style="color: red">*</small></label>
                                        <select class="form-control" name="country_id_new" required>
                                            @if(!empty($client->country_id))
                                            <option value="{{$client->country_id}}" selected>{{$client->country->name}}</option>
                                            @endif
                                            <option>Select Country</option>
                                            @foreach($country as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id_new')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>State <small style="color: red">*</small></label>
                                            <select class="form-control" name="state_id_new" required>
                                                @if(!empty($client->state_id))
                                                <option value="{{$client->state_id}}" selected>{{$client->state->name}}</option>
                                                @endif
                                                <option label="" disabled>Select State</option>
                                            </select>
                                            @error('state_id_new')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <select class="form-control" name="city_id_new">
                                                @if(!empty($client->city_id))
                                                <option value="{{$client->city_id}}" selected>{{$client->city->name}}</option>
                                                @endif
                                                <option label="" disabled>Select Detail</option>
                                            </select>
                                            @error('city_id_new')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Comment</label>
                                        <textarea class="form-control" name="comment" id="comment" cols="30" rows="10" required></textarea>
                                        @error('comment')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- Old Client Form --}}

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
<script>
    $(document).ready(function() {

        // State Select
        $('select[name="country_id_new"]').on('change', function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/state') }}/" + country_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('select[name="state_id_new"]').empty();
                        if (data.length === 0) {
                            $('select[name="state_id_new"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="state_id_new"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="state_id_new"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });
        // City Select
        $('select[name="state_id_new"]').on('change', function() {
            var state_id = $(this).val();

            if (state_id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/city') }}/" + state_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('select[name="city_id_new"]').empty();
                        if (data.length === 0) {
                            $('select[name="city_id_new"]').append('<option value="">N/A</option>');

                        } else {
                            $('select[name="city_id_new"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="city_id_new"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });

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
                        $('#selectBuildingFloorInventory').empty();
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
        // Bulding Invertory
        $('select[name="societyBlock"]').on('change', function() {
            var id = $(this).val();

            if (id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/societyBlock_inventory') }}/" + id,
                    type: "GET",
                    // dataType: "json",
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#selectblock_id').empty();
                        $.each(data, function(i, item) {
                            $('#selectblock_id').append($('<option>', {
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



        //Old Client
        $(".old-client-form").hide();
        // Show hidden paragraphs
        $(".old-client").on('click', function() {
            $(".old-client-form").show();
            $(".new-client-form").hide();
            $('input[name=client_type]').val('old');
            $('input[name="down_payment"]').removeAttr("required");
            $('input[name="name_new"]').removeAttr("required");
            $('input[name="father_name_new"]').removeAttr("required");
            $('input[name="cnic_new"]').removeAttr("required");
            $('input[name="email_new"]').removeAttr("required");
            $('input[name="phone_number_new"]').removeAttr("required");
            $('input[name="address_new"]').removeAttr("required");
            $('input[name="dob_new"]').removeAttr("required");
            $('select[name="country_id_new"]').removeAttr("required");
            $('select[name="state_id_new"]').removeAttr("required");
        });
        $(".new-client").on('click', function() {
            location.reload();
        });
    });
</script>

<!-- Basic Information -->
<script>
    document.getElementById("buildingfloor").style.display = "none";
    document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
    document.getElementById("premiumSocity").style.display = "none";
    document.getElementById("blockSocity").style.display = "none";

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
                var block = data[4];
                console.log(block);
                // console.log(block);
                $('#selectSize').empty();
                $('#selectBuildingFloor :first-child').nextAll().remove();

                // emptyOp.nextAll().remove();
                $('#selectBuildingFloorInventory').empty();
                $('#selectType').empty();
                $('#selectPremium').empty();
                if (project.type_id == 1) {
                    floor.forEach(element => {
                        var option = document.createElement('option');
                        option.text = element.name;
                        option.value = element.id;
                        document.getElementById("selectBuildingFloor").append(option);
                    });
                } else if (project.type_id == 2) {
                    block.forEach(element => {
                        console.log(element.block);
                        var option = document.createElement('option');
                        option.text = element.name;
                        option.value = element.id;
                        document.getElementById("selectPremiumScocity").append(option);
                    });
                } else if (project.type_id == 3) {
                    // block.forEach(element => {
                    // var option = document.createElement('option');
                    // option.text = block.id;
                    // option.value = element.id;
                    // document.getElementById("selectSize").append(option);
                    // });
                    // premium.forEach(element => {
                    //     var option = document.createElement('option');
                    //     option.text = element.name;
                    //     option.value = element.id;
                    //     document.getElementById("selectPremium").append(option);
                    // });
                }
            }
        });
    }

    function project() {
        var project = document.getElementById("selectProject").value;
        project = JSON.parse(project);
        switch (project.type_id) {
            case 1:
                document.getElementById("blockSocity").style.display = "none";
                document.getElementById("premiumSocity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "block";
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "block";

                break;
            case 2:
                document.getElementById("blockSocity").style.display = "block";
                document.getElementById("premiumSocity").style.display = "block";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
                break;
            case 3:
                document.getElementById("blockSocity").style.display = "none";
                document.getElementById("premiumSocity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
                break;
            case 4:
                document.getElementById("blockSocity").style.display = "none";
                document.getElementById("premiumSocity").style.display = "none";
                document.getElementById("buildingfloor").style.display = "none";
                document.getElementById("selectBuildingFloorInventoryHide").style.display = "none";
                break;
        }
    }
</script>
<script>

</script>
@endsection