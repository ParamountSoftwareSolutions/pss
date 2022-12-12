@extends('user.layout.app')
@section('title', 'Inventory Edit')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post"
                              action="{{ route('society.block.society_inventory.update', ['RolePrefix' => RolePrefix(), 'society' => $society_id, 'block' =>
                                $block_id, 'society_inventory' => $society_inventory->id])}}"
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
                                                       value="{{ $society_inventory->project->name }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row">
                                            <div class="form-group col-md-4 bulk">
                                                <label>Plot/Unit No <sup style="color: red">*</sup></label>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control bulk_unit_no" name="simple_unit" class="input-group-text" value="{{ old
                                                ('simple_unit', $society_inventory->unit_id) }}" placeholder="unit name">
                                                </div>
                                                @error('simple_unit')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Project Types<small style="color: red">*</small></label>
                                                <select class="form-control" name="category_id" required>
                                                    <option value="">Select Types</option>
                                                    @foreach($category as $data)
                                                        <option value="{{ $data->id }}" @if($society_inventory->category_id == $data->id) selected @endif>{{ $data->name
                                                        }}</option>
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
                                                            <option value="{{ $data->id }}" @if($society_inventory->type_id == $data->id) selected @endif>{{ $data->name
                                                            }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('nature')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <div class="form-group">
                                                    <label>Plot Size</label>
                                                    <select class="form-control" name="plot_size">
                                                        <option value="">Select Plot Size</option>
                                                        @foreach($plot_size as $data)
                                                            <option value="{{ $data->id }}" @if($society_inventory->size_id == $data->id) selected @endif>{{ $data->name
                                                            }} - {{ $data->unit }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('plot_size')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Premium Location</label>
                                                <select class="form-control" name="premium_id">
                                                    <option value="">Select Types</option>
                                                    @foreach($premium as $data)
                                                        <option value="{{ $data->id }}" @if($society_inventory->premium_id == $data->id) selected @endif>{{ $data->name
                                                        }}</option>
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
                                                        @foreach($payment_plan as $data)
                                                            <option value="{{$data->id}}" @if($society_inventory->payment_plan_id == $data->id) selected
                                                                @endif>{{$data->name.' ('.$data->total_price.')' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('payment_plan_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <div class="form-group">
                                                    <label>Bed</label>
                                                    <select class="form-control" name="bed">
                                                        <option value="">Select Bed</option>
                                                        @foreach($bed as $data)
                                                            <option value="{{ $data->id }}" @if($society_inventory->bed_id == $data->id) selected @endif>{{ $data->name
                                                            }} - {{ $data->unit->name }}</option>
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
                                                            <option value="{{ $data->id }}" @if($society_inventory->bath_id == $data->id) selected @endif>{{ $data->name
                                                            }} - {{ $data->unit }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('bath')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-primary">
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
        $(' button[name="addnew"]').on('click', function () {
            $('.card-body').children('.field').clone().appendTo('.brother');
        });
        $(' button[name="removenew"]').on('click', function () {
            $('.field:last-child').remove();
        });
    </script>

@endsection
