@extends('user.layout.app')
@section('title', 'Edit Society Detail')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="post" action="{{ route('society.update', ['RolePrefix' => RolePrefix(), 'society' => $society->id]) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h4>Edit Society</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Society Name</label>
                                            <input type="text" class="form-control" value="{{ $society->project->name }}" disabled>
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Developer</label>
                                            <input type="text" class="form-control" name="developer" value="{{ $society->developer }}">
                                            @error('developer')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <?php
                                    $type_check = json_decode($society->type);
                                    $block_check = json_decode($society->block);
                                    ?>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Society Types</label>
                                            <select class="form-control select2" multiple="" name="type[]">
                                                <option label="" disabled @if ($society->type == null)) selected
                                                    @endif>Select Society Types
                                                </option>
                                                @foreach($category as $data)
                                                    <option value="{{ $data->id }}" @if ($type_check !== null) @if (in_array($data->id, $type_check)) selected
                                                        @endif @endif>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Block</label>
                                            <select class="form-control select2" multiple="" name="block[]">
                                                <option label="" disabled @if ($society->block == null)) selected
                                                    @endif>Select Society Block
                                                </option>
                                                @foreach($block as $data)
                                                    <option value="{{ $data->id }}" @if ($block_check !== null) @if (in_array($data->id, $block_check)) selected
                                                        @endif @endif>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Society Types</label>
                                            <select class="form-control" name="noc_type_id">
                                                <option label="" disabled @if ($society->noc_type_id == null)) selected
                                                    @endif>Select Society Types
                                                </option>
                                                @foreach($noc as $data)
                                                    <option value="{{ $data->id }}" @if ($data->id == $society->noc_type_id)) selected
                                                        @endif>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address"
                                                   value="{{ old('address', $society->address) }}">
                                            @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Total Area</label>
                                            <input type="text" class="form-control" name="area"
                                                   value="{{ old('area', $society->area) }}">
                                            @error('area')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Country</label>
                                            <select class="form-control" name="country">
                                                <option label="" disabled @if ($society->country_id == null)) selected
                                                    @endif>Select Country
                                                </option>
                                                @foreach($country as $data)
                                                    <option value="{{ $data->id }}" @if($society->country_id !== null) @if ($data->id == $society->country_id)) selected
                                                        @endif @endif>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                @if($society->state_id == null)
                                                    <select class="form-control" name="state">
                                                        <option label="" disabled selected>Select State</option>
                                                    </select>
                                                @else
                                                    <select class="form-control" name="state">
                                                        <option value="{{ $society->state_id }}" selected>{{ $society->state->name }}</option>
                                                    </select>
                                                @endif
                                                @error('state')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>City</label>
                                                @if($society->state_id == null)
                                                    <select class="form-control" name="city">
                                                        <option label="" disabled selected>Select Detail</option>
                                                    </select>
                                                @else
                                                    <select class="form-control" name="city">
                                                        <option value="{{ $society->city_id }}" selected>{{ $society->city->name }}</option>
                                                    </select>
                                                @endif
                                                @error('city')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Society Logo</label>
                                            <input type="file" class="form-control" name="logo">
                                            <img src="" alt="" width="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Society Main Image</label>
                                            <input type="file" class="form-control" name="main_image">
                                            <img src="" alt="" width="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Society Banner Images</label>
                                            <input type="file" class="form-control" name="images[]" multiple>
                                            <img src="" alt="" width="">
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
        $('select[name="country"]').on('change', function () {
            var country_id = $(this).val();
            if (country_id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/state') }}/" + country_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="state"]').empty();
                        if (data.length === 0) {
                            $('select[name="state"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="state"]').append('<option value="">Please  Select</option>');
                            $.each(data, function (key, value) {
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
        $('select[name="state"]').on('change', function () {
            var state = $(this).val();
            if (state) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/city') }}/" + state,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="city"]').empty();
                        if (data.length === 0) {
                            $('select[name="city"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="city"]').append('<option value="">Please  Select</option>');
                            $.each(data, function (key, value) {
                                $('select[name="city"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        });
    </script>
@endsection
