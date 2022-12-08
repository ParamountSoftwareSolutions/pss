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
        //dd($building->apartment_size, $apartment_size_check)
        ?>
        <div class="form-group col-md-4">
            <label>Building Floor</label>
            <select class="form-control select2" multiple="" name="floor_list[]">
                <option label="" disabled>Select All Building Floors</option>
                @foreach($floor as $data)
                    <option value="{{ $data->id }}"
                            @if (in_array($data->id, $floor_check)) selected @endif>{{ $data->name }}</option>
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
                        @endif @endif>{{ $data->name }} - {{ $data->unit->name
                    }}</option>
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
            <select class="form-control select2" multiple="" name="type[]">
                <option label="" disabled>Select Building Types</option>
                <option value="apartment"
                        @if (in_array("apartment", $type_check)) selected @endif>
                    Apartment
                </option>
                <option value="shop"
                        @if (in_array("shop", $type_check)) selected @endif>Shop
                </option>
                <option value="office"
                        @if (in_array("office", $type_check)) selected @endif>Office
                </option>
                <option value="flats"
                        @if (in_array("flats", $type_check)) selected @endif>Flats
                </option>
                <option value="studio"
                        @if (in_array("studio", $type_check)) selected @endif>Studio
                </option>
                <option value="penthouse"
                        @if (in_array("penthouse", $type_check)) selected @endif>Pent
                    House
                </option>
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
