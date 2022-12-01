@extends('user.layout.app')
@section('title', 'Add New Project')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('farmhouse.update', ['RolePrefix' => RolePrefix(), 'farmhouse' => $project->id]) }}"
                              enctype="multipart/form-data">
                            <div class="card">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h4>Edit Farmhouse</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Farmhouse Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $project->name) }}">
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 simple">
                                            <label class="d-flex align-items-center">
                                                <label>Plot/Unit No <sup style="color: red">*</sup></label>
                                                <a href="#" style="margin-left: auto; display: block;" class="btn btn-primary bulk-btn" data-value="bulk">Bulk Create</a>
                                            </label>
                                            <input type="text" class="form-control simple-input" name="simple_unit_no" value="{{ old('unit_no') }}">
                                            @error('unit_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 bulk">
                                            <label class="d-flex align-items-center">
                                                <label>Plot/Unit No <sup style="color: red">*</sup></label>
                                                <a href="#" style="margin-left: auto; display: block;" class="btn btn-primary bulk-btn" data-value="simple">Simple Create</a>
                                            </label>
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control bulk_unit_no" name="bulk_unit_no" class="input-group-text" value="{{ old
                                                ('unit_no') }}" placeholder="unit name">
                                                <div class="input-group-prepend preselection-prepend">
                                                    <div class="input-group-text">-</div>
                                                </div>
                                                <input type="number" class="form-control start_unit_no" name="start_unit_no" value="{{ old('start_unit_no') }}"
                                                       placeholder="start unit">
                                                <div class="input-group-prepend preselection-prepend">
                                                    <div class="input-group-text">-</div>
                                                </div>
                                                <input type="number" class="form-control end_unit_no" name="end_unit_no" value="{{ old('end_unit_no') }}"
                                                       placeholder="end
                                                 unit">
                                            </div>

                                            @error('simple_unit_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Down Payment </label>
                                            <input type="text" class="form-control" name="down_payment" value="{{ old('down_payment') }}">
                                            @error('down_payment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Nature <sup style="color: red">*</sup></label>
                                                <select class="form-control" name="nature" required>
                                                    <option label="" disabled selected>Select Nature</option>
                                                    <option value="commercial">Commercial</option>
                                                    <option value="semi_commercial">Semi Commercial</option>
                                                    <option value="residential">Residential</option>
                                                </select>
                                                @error('nature')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select class="form-control" name="type">
                                                    <option label="" disabled selected>Select Type</option>
                                                    <option value="corner">Corner</option>
                                                    <option value="front_facing">Front Facing</option>
                                                    <option value="main_boulevard">Main Boulevard</option>
                                                    <option value="park_facing">Park Facing</option>
                                                </select>
                                                @error('nature')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Size</label>
                                            <select class="form-control" name="size_id">
                                                <option label="" disabled selected>Select Size</option>
                                                @foreach($sizes as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }} Marla</option>
                                                @endforeach
                                            </select>
                                            @error('size_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Staus</label>
                                            <select class="form-control" name="status">
                                                <option value="available">Available</option>
                                                <option value="sold">Sold</option>
                                                <option value="hold">Hold</option>
                                            </select>
                                            @error('status')
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
        $(document).ready(function () {
            $('.bulk').hide();
            $('.simple-input').attr('required', true);

            $('.bulk-btn').on('click', function () {
                var val = $(this).data('value');
                console.log(val);
                if (val == 'bulk') {
                    $('.bulk_unit_no').attr('required', true);
                    $('.start_unit_no').attr('required', true);
                    $('.end_unit_no').attr('required', true);

                    $('.simple-input').removeAttr('required', false);
                    $('.simple-input').css('display', 'none');
                    $('.simple-input').val('');

                    $('.bulk_unit_no').css('display', 'block');
                    $('.start_unit_no').css('display', 'block');
                    $('.end_unit_no').css('display', 'block');

                    $('.bulk').css('display', 'block');

                    $('.simple').hide();
                    $('.bulk').show();
                } else {
                    $('.simple-input').attr('required', true);

                    $('.bulk_unit_no').removeAttr('required', false);
                    $('.start_unit_no').removeAttr('required', false);
                    $('.end_unit_no').removeAttr('required', false);

                    $('.simple-input').css('display', 'block');

                    $('.bulk_unit_no').css('display', 'none');
                    $('.start_unit_no').css('display', 'none');
                    $('.end_unit_no').css('display', 'none');

                    $('.bulk_unit_no').val('');
                    $('.start_unit_no').val('');
                    $('.end_unit_no').val('');

                    $('.simple').show();
                    $('.bulk').hide();
                }
            });
        });
    </script>
@endsection
