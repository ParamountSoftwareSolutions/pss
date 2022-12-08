<div class="card-body">
    <div class="row">
        <div class="form-group col-md-4">
            <label>Building Name</label>
            <input type="text" class="form-control" value="{{ $building->project->name }}" disabled>
            @error('name')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Building Floor</label>
            <select class="form-control select2" multiple="" name="floor_list[]" required>
                <option label="" disabled>Select All Building Floors</option>
                @foreach($floor as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                    <option value="{{ $data->id }}">{{ $data->name }} - {{ $data->unit->name }}</option>
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
                <option value="apartment">Apartment</option>
                <option value="shop">Shop</option>
                <option value="office">Office</option>
                <option value="flats">Flats</option>
                <option value="studio">Studio</option>
                <option value="penthouse">Pent House</option>
            </select>
            @error('type')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        {{--<div class="form-group col-md-4">
            <label>Developer Name</label>
            <input type="text" class="form-control" name="developer_name" value="{{ old('developer_name') }}">
            @error('developer_name')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>--}}
        <div class="form-group col-md-4">
            <label>Address</label>
            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
            @error('address')
            <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Total Area</label>
            <input type="text" class="form-control" name="total_area" value="{{ old('total_area') }}">
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
            <input type="file" class="form-control" name="main_image" required>
            <img src="" alt="" width="">
        </div>
        <div class="form-group col-md-4">
            <label>Building Banner Images</label>
            <input type="file" class="form-control" name="images[]" multiple>
            <img src="" alt="" width="">
        </div>
    </div>
</div>
