@extends('user.layout.app')
@section('title', 'Edit Sale')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form method="POST" action="{{route('leads.update', ['RolePrefix' => RolePrefix(),$lead->id])}}">
                        <div class="card">
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
                                            <select class="form-control" name="project_id" required>
                                                @if(!empty($lead->project_id))
                                                <option value="{{ $lead->project_id }}" selected>{{ ($lead->project_id)?$lead->prject->name:"" }}</option>
                                                <option label="">Select Detail</option>
                                                @forelse($lead as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @empty
                                                <option value="">N/A</option>
                                                @endforelse
                                                @else
                                                <option label="">Select Detail</option>
                                                @forelse($lead as $data)
                                                <option value="">name</option>
                                                @empty
                                                <option value="">N/A</option>
                                                @endforelse
                                                @endif
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Building Detail -->

                                    <!-- <div class="form-group col-md-4">
                                                    <div class="form-group">
                                                        <label>Floor List</label>
                                                        <select class="form-control" name="floor_id">
                                                            @if($lead->project_id !== null)
                                                            <option value="{{ $lead->project_id }}" selected>{{ $lead->project_id }}</option>
                                                            <option label="" disabled>Select Detail</option>
                                                            @else
                                                            <option label="" disabled>Select Detail</option>

                                                            @endif
                                                        </select>
                                                        @error('floor_id')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="form-group">
                                                        <label>Floor Details</label>
                                                        <select class="form-control" name="floor_detail_id">
                                                            @if($lead->project_id !== null)

                                                            <option value="Type" selected>Property
                                                                Number:  number  Property
                                                                Type: Type</option>
                                                            <option label="" disabled>Select Detail</option>

                                                            @else
                                                            <option label="" disabled>Select Detail</option>
                                                            @endif
                                                        </select>
                                                        @error('floor_detail_id')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> -->

                                    <!-- Building Detail -->

                                    <div class="row">
                                        <!-- <div class="form-group col-md-4">
                                            <label>Interested In</label>
                                            <select name="interested_in" class="form-control" id="interested_in" value="{{ old('interested_in') }}">
                                                <option value="{{ $lead->interested_in }}" selected>{{ $lead->interested_in }}</option>
                                                <option value=""> -- Please Select -- </option>
                                            </select>
                                            @error('interested_in')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div> -->
                                        <div class="form-group col-md-4">
                                            <label>Budget</label>
                                            <input type="text" class="form-control" name="budget" value="{{$lead->budget}}">
                                            @error('budget')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Source</label>
                                                <select class="form-control" name="source">
                                                    <option label="" disabled selected>Select Detail</option>
                                                    <option value="walk_in" @if($lead->source == 'walk_in') selected @endif>Walk In</option>
                                                    <option value="call" @if($lead->source == 'call') selected @endif>Call</option>
                                                    <option value="reference" @if($lead->source == 'reference') selected @endif>Reference</option>
                                                    <option value="social_media" @if($lead->source == 'social_media') selected @endif>Social Media</option>
                                                    <option value="facebook" @if($lead->facebook == 'facebook') selected @endif>Facebook</option>
                                                </select>
                                                @error('source')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Customer Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Customer Name</label>
                                        <input type="text" class="form-control" required="" name="name" value="{{ $lead->name }}">
                                        @error('name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Father Name</label>
                                        <input type="text" class="form-control" name="father_name" autocomplete="false" value="{{ $lead->name }}">
                                        @error('father_name')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CNIC Number</label>
                                        <input type="text" class="form-control" name="cnic" value="{{ $lead->cnic }}" autocomplete="off">
                                        @error('cnic')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Email (optional)</label>
                                        <input type="email" class="form-control" name="email" autocomplete="off" value="{{ $lead->email }}">
                                        @error('email')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone_number" value="{{ $lead->number }}">
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
<script>
    $(document).ready(function() {
        $('select[name="project_id"]').on('change', function() {
            var project_id = $(this).val();
            if (project_id) {
                $.ajax({
                    //  url: "{{ url('property-manager/sale/building') }}/" + project_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="floor_id"]').empty();
                        if (data.length === 0) {
                            $('select[name="floor_id"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="floor_id"]').append('<option value="">Please Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="floor_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });
        $('select[name="floor_id"]').on('change', function() {
            var floor_id = $(this).val();
            var project_id = $('select[name="project_id"]').find(":selected").val();
            if (floor_id) {
                $.ajax({
                    //    url: "{{ url('property-manager/sale/floor') }}/" + floor_id + "/" + project_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="floor_detail_id"]').empty();
                        if (data.length === 0) {
                            $('select[name="floor_detail_id"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="floor_detail_id"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="floor_detail_id"]').append('<option value="' + value.id + '">' + "Property Number: " + value.number + "  Property Type: " + value.type + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });
        $('select[name="project_id"]').on('change', function() {
            var id = $(this).val();
            $.ajax({
                type: 'GET',
                success: function(data) {
                    $('#interested_in').html('');
                    if (data['types'].length > 0) {
                        for (var i = 0; i < data['types'].length; i++) {
                            $('#interested_in').append('<option value="' + data['types'][i] + '">' + data['types'][i] + '</option>');
                        }
                    } else {
                        $('#interested_in').append('<option value="">N/A</option>');

                    }
                },
            });
        });
        $('select[name="country_id"]').on('change', function() {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="state_id"]').empty();
                        if (data.length === 0) {
                            $('select[name="state_id"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="state_id"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="state_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });
        // City Select
        $('select[name="state_id"]').on('change', function() {
            var state_id = $(this).val();
            if (state_id) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="city_id"]').empty();
                        if (data.length === 0) {
                            $('select[name="city_id"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="city_id"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                $('select[name="city_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });


        $('#leadUpdateForm').submit(function(e) {
            e.preventDefault();
            showLoader();
            let formData = $(this).serialize();
            $.ajax({
                type: "POST",
                data: formData,
                success: function(data) {
                    hideLoader();
                    if (data.status == 'success') {
                        successMsg(data.message);
                        setTimeout(function() {}, 1000);
                    }
                    if (data.status == 'error') {
                        errorMsg(data.message);
                    }
                },
            });
        });
    });
</script>
@endsection