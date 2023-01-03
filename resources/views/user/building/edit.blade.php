@extends('user.layout.app')
@section('title', 'Add Building Detail')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="post" action="{{ route('building.update', ['RolePrefix' => RolePrefix(), 'building' => $building->id]) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h4>Edit Building</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Building Name</label>
                                            <input type="text" class="form-control" value="{{ $building->project->name }}" disabled>
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <?php
                                        $floor_check = json_decode($building->floor_list);
                                        $type_check = json_decode($building->type);
                                        $apartment_size_check = json_decode($building->apartment_size);
                                        ?>
                                        <div class="form-group col-md-4">
                                            <label>Building Floor</label>
                                            <select class="form-control select2" multiple="" name="floor_list[]">
                                                <option label="" disabled>Select All Building Floors</option>
                                                @foreach($floor as $data)
                                                    <option value="{{ $data->id }}"
                                                            @if($floor_check !== null) @if (in_array($data->id, $floor_check)) selected @endif @endif>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('floor_list')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Apartment Size</label>
                                            <select class="form-control select2" multiple="" name="apartment_size[]">
                                                <option label="" disabled>Select Bed</option>
                                                @foreach($size as $data)
                                                    <option value="{{ $data->id }}" @if ($apartment_size_check !== null) @if (in_array($data->id, $apartment_size_check)) selected
                                                        @endif @endif>{{ $data->name }} - {{ $data->unit }}</option>
                                                @endforeach
                                            </select>
                                            @error('apartment_size')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Building Types</label>
                                            <select class="form-control select2" multiple="" name="type[]" required>
                                                <option label="" disabled>Select Building Types</option>
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
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address"
                                                   value="{{ old('address', $building->address) }}">
                                            @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Total Area</label>
                                            <input type="text" class="form-control" name="total_area"
                                                   value="{{ old('total_area', $building->total_area) }}">
                                            @error('total_area')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Building Logo</label>
                                            <input type="file" class="form-control" name="logo">
                                            <img src="" alt="" width="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Building Main Image</label>
                                            <input type="file" class="form-control" name="main_image">
                                            <img src="" alt="" width="">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Building Banner Images</label>
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
