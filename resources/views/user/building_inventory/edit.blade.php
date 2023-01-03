@extends('user.layout.app')
@section('title', 'Edit Floor Detail')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post"
                              action="{{ route('building.floor.building_inventory.update', ['RolePrefix' => RolePrefix(), 'building' => $building_id, 'floor' =>
                                $floor_id, 'building_inventory' => $inventory->id])}}"
                              enctype="multipart/form-data">
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
                                                <label>Project Name<small style="color: red">*</small></label>
                                                <input type="text" class="form-control" name="project"
                                                       value="{{ old('project', $inventory->project->name) }}" disabled>
                                                @error('project')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row field">
                                        <div class="form-group col-md-4 simple">
                                            <label class="d-flex align-items-center">
                                                <label>Plot/Unit No <sup style="color: red">*</sup></label>
                                            </label>
                                            <input type="text" class="form-control simple-input" name="unit_id" value="{{ old('unit_no', $inventory->unit_id) }}">
                                            @error('unit_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Project Types<small style="color: red">*</small></label>
                                            <select class="form-control" name="category_id" required>
                                                <option value="">Select Types</option>
                                                @foreach($category as $data)
                                                    <option value="{{ $data->id }}" @if($inventory->category_id == $data->id) selected @endif>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Nature <sup style="color: red">*</sup></label>
                                                <select class="form-control" name="nature_id" required>
                                                    <option label="" disabled selected>Select Nature</option>
                                                    @foreach($nature as $data)
                                                        <option value="{{ $data->id }}" @if($inventory->type_id == $data->id) selected @endif>{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('nature')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Area<small style="color: red">*</small></label>
                                                <input type="number" class="form-control" name="area"
                                                       value="{{ old('area', $inventory->area) }}" required>
                                                @error('area')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Bed</label>
                                                <select class="form-control" name="bed">
                                                    <option value="">Select Bed</option>
                                                    @foreach($bed as $data)
                                                        <option value="{{ $data->id }}" @if($inventory->bed_id == $data->id) selected @endif>{{ $data->name }} - {{
                                                        $data->unit
                                                        }}</option>
                                                    @endforeach
                                                </select>
                                                @error('bed')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Bath</label>
                                                <select class="form-control" name="bath">
                                                    <option value="">Select Bath</option>
                                                    @foreach($bath as $data)
                                                        <option value="{{ $data->id }}" @if($inventory->bath_id == $data->id) selected @endif>{{ $data->name }} - {{
                                                        $data->unit }}</option>
                                                    @endforeach
                                                </select>
                                                @error('bath')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Premium Location</label>
                                            <select class="form-control" name="premium_id">
                                                <option value="">Select Types</option>
                                                <option value="regular"{{$inventory->premium_id == null ? 'selected' : ''}}>Regular</option>
                                                @foreach($premium as $data)
                                                    <option value="{{ $data->id }}" @if($inventory->premium_id == $data->id) selected @endif>{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('premium_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Select Payment Plan<small style="color: red">*</small></label>
                                            <div class="input-group mb-3">
                                                <select name="payment_plan_id" class="form-control" required>
                                                    <option value="">Select Payment Plan</option>
                                                </select>
                                            </div>
                                            @error('payment_plan_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Inventory Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div class="row mb-3">
                                                @if($inventory->file !== null)
                                                    @foreach($inventory->file as $img)
                                                        <div class="col-3">
                                                            <img style="height: 200px;width: 100%" class="image"
                                                                 src="{{asset($img->file)}}">
                                                            <a href=""
                                                               style="margin-top: -35px;border-radius: 0"
                                                               class="btn btn-danger btn-block btn-sm remove-image"
                                                               data-id="{{ $img->id }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                    @error('banner_images')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
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
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 4,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset("assets/img/img2.jpg")}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var premium_id = $('select[name="premium_id"]').val();
            getPaymentPlan(premium_id);
            $('.remove-image').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                console.log(id);
                var inventory_id = {{ $inventory->id }};
                if (id) {
                    $.ajax({
                        url: "{{ url(RolePrefix().'/building/inventory/image/remove') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
                            inventory_id: inventory_id,
                        },
                        success: function (response) {
                            console.log(response.name);
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                width: '27rem',
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                            Toast.fire({
                                icon: 'success',
                                title: 'Image Remove Successfully'
                            })
                        },
                    });
                } else {
                    alert('danger');
                }
            });
            $('select[name="premium_id"]').change(function () {
                var premium_id = $(this).val();
                getPaymentPlan(premium_id);
                return;
            })
        });
        function getPaymentPlan(premium_id) {
            if(!premium_id){
                premium_id = 'regular';
            }
            $.ajax({
                url: "{{ url(RolePrefix().'/get-payment-plan') }}/" + premium_id + "/" + 1,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="payment_plan_id"]').empty();
                    if (data.length === 0) {
                        $('select[name="payment_plan_id"]').append('<option value="">N/A</option>');
                    } else {
                        $('select[name="payment_plan_id"]').append('<option value="">Please  Select</option>');
                        $.each(data, function (key, value) {
                            let oldlId = '{{ $inventory->payment_plan_id }}';
                            let selected = value.id == oldlId ? "selected" : "";
                            var price = value.after_commission_price ? value.after_commission_price : value.total_price;
                            $('select[name="payment_plan_id"]').append('<option value="' + value.id + '"'+selected+'>' + value.name +'('+ price +')'+ '</option>');
                        });
                    }
                },
            });
        }
    </script>

@endsection
