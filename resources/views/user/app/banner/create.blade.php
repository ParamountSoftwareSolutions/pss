@extends('user.layout.app')
@section('title', 'Add New Banner')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('banner.store',RolePrefix()) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card card-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Add Banner</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="country">Project Type <small
                                                    style="color: red">*</small></label>
                                            <select class="form-control" name="project_type_id" required>
                                                <option>Select Type</option>
                                                @foreach($type as $data)
                                                    <option
                                                        value="{{ $data->id }}">{{ ucwords(str_replace('_','',$data->name)) }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="country">Select Project <small
                                                    style="color: red">*</small></label>
                                            <select class="form-control" name="project_id" required>
                                                <option> -- Select Project --</option>
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Banner Image <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div class="row" id="coba"></div>
                                            @error('images')
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
    <script type="text/javascript" src="{{ asset('assets/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        // State Select
        $(document).ready(function () {
            $('select[name="project_type_id"]').on('change', function () {
                var type_id = $(this).val();
                if (type_id) {
                    $.ajax({
                        url: "{{ url(RolePrefix().'/get-project') }}/" + type_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="project_id"]').empty();
                            if (data.length === 0) {
                                $('select[name="project_id"]').append('<option value="">N/A</option>');
                            } else {
                                $('select[name="project_id"]').append('<option value="">Please  Select</option>');
                                $.each(data, function (key, value) {
                                    $('select[name="project_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            }
                        },
                    });
                } else {
                    alert('danger');
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '2048',
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
@endsection
