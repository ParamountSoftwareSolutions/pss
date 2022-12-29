@extends('user.layout.app')
@section('title', 'Update Banner')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('banner.update', ['RolePrefix'=>RolePrefix(),'banner'=>$banner->id]) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card card-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Add Banner</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="country">Project Type <small style="color: red">*</small></label>
                                            <select class="form-control" name="project_type_id" required>
                                                <option>Select Type</option>
                                                @foreach($type as $data)
                                                    <option value="{{ $data->id }}" {{$banner->project->type_id == $data->id ? 'selected' : ''}}>{{ ucwords(str_replace('_','',$data->name)) }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="country">Select Project <small style="color: red">*</small></label>
                                            <select class="form-control" name="project_id" required>
                                                <option> -- Select Project -- </option>
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
                                    <h4>Banner Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            @if($banner->file && file_exists('public/'.$banner->file) )
                                            <div class="row mb-3">
                                                <div class="col-3">
                                                    <img style="height: 200px;width: 100%" class="image"
                                                         src="{{asset($banner->file)}}">
                                                    <a href=""
                                                       style="margin-top: -35px;border-radius: 0"
                                                       class="btn btn-danger btn-block btn-sm remove-image"
                                                       data-id="{{ $banner->id }}">Remove</a>
                                                </div>
                                            </div>
                                            @else
                                                <div class="row" id="coba"></div>
                                            @endif
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
    <script type="text/javascript" src="{{ asset('assets/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        // State Select
        $(document).ready(function () {
            var id = "{{$banner->project->type_id}}";
            getProjects(id);
            $('select[name="project_type_id"]').on('change', function() {
                var type_id = $(this).val();
                getProjects(type_id)
            });
            $('.remove-image').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data("id");
                console.log(id);
                if (id) {
                    $.ajax({
                        url: "{{ url(RolePrefix().'/banner/image/remove') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id,
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
                                title: 'Image has been removed successfully!'
                            })
                        },
                    });
                } else {
                    alert('danger');
                }
            });
        });
        function getProjects(type_id){
            if (type_id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/get-project') }}/" + type_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="project_id"]').empty();
                        if (data.length === 0) {
                            $('select[name="project_id"]').append('<option value="">N/A</option>');
                        } else {
                            $('select[name="project_id"]').append('<option value="">Please  Select</option>');
                            $.each(data, function(key, value) {
                                var selected = value.id == {{$banner->project_id}} ? 'selected' : '';
                                $('select[name="project_id"]').append('<option value="' + value.id + '" '+selected+' >' + value.name + '</option>');
                            });
                        }
                    },
                });
            } else {
                alert('danger');
            }
        }
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
    <script>
        $('.remove-image').on('click', function (e) {
            var id = $(this).data("id");
            console.log(id);
            if (id) {
                $.ajax({
                    url: "{{ url(RolePrefix().'/banner/remove/image') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        type: 'payment_plan'
                    },
                    success: function (response) {
                        console.log(response.name);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Image Remove Successfully.',
                        });
                    },
                });
            } else {
                alert('danger');
            }
        });
    </script>
@endsection
