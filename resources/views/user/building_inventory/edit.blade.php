@extends('property.layout.app')
@section('title', 'Update Floor Detail')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="post"
                                  action="{{ route('property_admin.floor_detail.update', ['building_id' => $building_id, 'floor_id' => $floor_id, 'id' => $floor_detail->id]) }}">
                                @csrf
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Shop/Apartment Number</label>
                                                <input type="text" class="form-control" name="number"
                                                       value="{{ old('number', $floor_detail->number) }}">
                                                @error('number')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Shop/Apartment Area</label>
                                                <input type="number" class="form-control" name="area"
                                                       value="{{ old('area', $floor_detail->area) }}">
                                                @error('area')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Shop/Apartment Total Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="total_price" value="{{ old('total_price', $floor_detail->total_price) }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('total_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Shop/Apartment First Booking Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="booking_price" value="{{ old('booking_price', $floor_detail->booking_price) }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('booking_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Shop/Apartment Per Month Installment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="per_month_installment" value="{{ old('per_month_installment', $floor_detail->per_month_installment) }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('per_month_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Shop/Apartment Half Year Installment</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="half_year_installment" value="{{ old('half_year_installment', $floor_detail->half_year_installment) }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('half_year_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Shop/Apartment Balloting Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="balloting_price" value="{{ old('balloting_price', $floor_detail->balloting_price) }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('balloting_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Shop/Apartment Possession Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RS</span>
                                                </div>
                                                <input type="number" class="form-control" aria-label="Amount"
                                                       name="possession_price" value="{{ old('possession_price', $floor_detail->possession_price) }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            @error('possession_price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">How Many Months Installment Plans</label>
                                            <input type="number" class="form-control" name="total_month_installment" value="{{ old('total_month_installment', $floor_detail->total_month_installment) }}">
                                            @error('total_month_installment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Apartment Bed</label>
                                                <select class="form-control" name="size">
                                                    <option value="{{ $floor_detail->size }}" selected>
                                                        {{ ucwords($floor_detail->size) }}</option>
                                                    <option label="" disabled>Select Apartment Bed</option>
                                                    <option value="1">1 Bed</option>
                                                    <option value="2">2 Bed</option>
                                                    <option value="3">3 Bed</option>
                                                </select>
                                                @error('size')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Building Types</label>
                                            <select class="form-control" name="type">
                                                <option value="{{ $floor_detail->type }}" selected>{{ ucwords($floor_detail->type) }}</option>
                                                <option label="" disabled>Select Building Types</option>
                                                <option value="apartment">Apartment</option>
                                                <option value="shop">Shop</option>
                                                <option value="office">Office</option>
                                                <option value="flat">Flats</option>
                                                <option value="studio">Studio</option>
                                                <option value="penthouse">Pent House</option>
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="{{ $floor_detail->status }}" selected>{{ ucwords($floor_detail->status) }}</option>
                                                <option label="" disabled>Select Apartment/Shop Status</option>
                                                <option value="reserved">Reserved</option>
                                                <option value="sold">Sold</option>
                                                <option value="cancel">Cancel</option>
                                                <option value="hold">Hold</option>
                                                <option value="available">Available</option>
                                                <option value="penthouse">Pent House</option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Shop/Apartment Premium Location</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="premium"
                                                       id="exampleRadios1" @if($floor_detail->premium == 'on') checked @endif>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Corner
                                                </label>
                                            </div>
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
