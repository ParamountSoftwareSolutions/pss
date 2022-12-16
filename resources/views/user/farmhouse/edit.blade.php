@extends('user.layout.app')
@section('title', 'Add New Project')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('farmhouse.inventory.update', ['RolePrefix' => RolePrefix(),'farmhouse'=>$project->id, 'inventory' => $farmhouse->id]) }}"
                              enctype="multipart/form-data">
                            <div class="card">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h4>Farmhouse Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Farmhouse Name</label>
                                            <input type="text" class="form-control" name="name" readonly style="cursor: not-allowed" value="{{ $project->name }}">
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                @csrf
                                <div class="card-header">
                                    <h4>Inventory Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Block</label>
                                            <select class="form-control" name="size_id">
                                                <option label="" disabled selected>Select Block</option>
                                                @foreach($blocks as $data)
                                                    <option value="{{ $data->id }}"{{$farmhouse->block_id == $data->id ? 'selected' : ''}}>{{ $data->name }} Marla</option>
                                                @endforeach
                                            </select>
                                            @error('size_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Plot/Unit No <sup style="color: red">*</sup></label>
                                            <input type="text" class="form-control" name="unit_no" required
                                                   value="{{ old('unit_no', $farmhouse->unit_no) }}">
                                            @error('unit_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Size</label>
                                            <select class="form-control" name="size_id">
                                                <option value="">Select Size</option>
                                                @foreach($sizes as $data)
                                                    <option value="{{ $data->id }}" {{$farmhouse->size_id == $data->id ? 'selected' : ''}}>{{ $data->name }} Marla</option>
                                                @endforeach
                                            </select>
                                            @error('size_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="available" {{$farmhouse->status == 'available' ? 'selected' : ''}}>Available</option>
                                                <option value="sold" {{$farmhouse->status == 'sold' ? 'selected' : ''}}>Sold</option>
                                                <option value="hold" {{$farmhouse->status == 'hold' ? 'selected' : ''}}>Hold</option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Premium Type</label>
                                                <select class="form-control" name="premium_id">
                                                    <option value="">Select Type</option>
                                                    <option value="regular"{{$farmhouse->premium_id == null ? 'selected' : ''}}>Regular</option>
                                                    @foreach($premiums as $data)
                                                        <option value="{{ $data->id }}" {{$farmhouse->premium_id == $data->id ? 'selected' : ''}}>{{ ucwords($data->name) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('premium_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Select Payment Plan</label>
                                                <select class="form-control" name="payment_plan_id">
                                                    <option value="">Select Payment Plan</option>
                                                </select>
                                                @error('payment_plan_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Multi Image Upload -->
                            <div class="card card-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div class="row" id="coba">
                                                @if($farmhouse->files !== null)
                                                    @foreach($farmhouse->files as $img)
                                                        <div class="col-3">
                                                            <img style="height: 200px;width: 100%" class="banner-image"
                                                                 src="{{asset($img->file)}}">
                                                            <a href=""
                                                               style="margin-top: -35px;border-radius: 0"
                                                               class="btn btn-danger btn-block btn-sm remove-image-floor-detail"
                                                               data-id="{{ $img->id }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
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
            var premium_id = $('select[name="premium_id"]').val();
            var project_type_id = {{$project_type_id}};
            getPaymentPlan(premium_id,project_type_id);
            $('select[name="premium_id"]').change(function () {
                var premium_id = $(this).val();
                var project_type_id = {{$project_type_id}};
                getPaymentPlan(premium_id,project_type_id);
                return;
            })
        });
        function getPaymentPlan(premium_id,project_type_id) {
            $.ajax({
                url: "{{ url(RolePrefix().'/get-payment-plan') }}/" + premium_id + "/" + project_type_id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('select[name="payment_plan_id"]').empty();
                    if (data.length === 0) {
                        $('select[name="payment_plan_id"]').append('<option value="">N/A</option>');
                    } else {
                        $('select[name="payment_plan_id"]').append('<option value="">Please  Select</option>');
                        $.each(data, function (key, value) {
                            let oldlId = '{{ $farmhouse->payment_plan_id }}';
                            let selected = value.id == oldlId ? "selected" : "";
                            var price = value.after_commission_price ? value.after_commission_price : value.total_price;
                            $('select[name="payment_plan_id"]').append('<option value="' + value.id + '"'+selected+'>' + value.name +'('+ price +')'+ '</option>');
                        });
                    }
                },
            });
        }
    </script>
    <script type="text/javascript">
        $(function () {
            $("#main").spartanMultiImagePicker({
                fieldName: 'main_images[]',
                maxCount: 1,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset("public/panel/assets/img/img2.jpg")}}',
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
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 4,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset("public/panel/assets/img/img2.jpg")}}',
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
@endsection
