@extends('user.layout.app')
@section('title', 'Payment Plan Create')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form id="payment_plan_form" method="post" action="{{ route('dealer.store',RolePrefix()) }}">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Name <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="name" required>
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">CNIC <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="cnic" required>
                                            @error('cnic')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Phone Number <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="number" required>
                                            @error('number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Agency <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="agency" required>
                                            @error('agency')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Address <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="address" required>
                                            @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Rebate <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="rebate" required>
                                            @error('rebate')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Down Payment <small style="color: red">*</small></label>
                                            <input type="text" class="form-control" name="down_payment" required>
                                            @error('down_payment')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Email</label>
                                            <input type="text" class="form-control" name="email" required>
                                            @error('email')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Alternative Phone Number</label>
                                            <input type="text" class="form-control" name="alt_number" required>
                                            @error('alt_number')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Project Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Select Category (In which category you deal) <small style="color: red">*</small></label>
                                            <select class="form-control" name="category" required>
                                                <option value=""> -- Select Category -- </option>
                                                <option value="project">Project</option>
                                                <option value="floor">Floor/Block</option>
                                                <option value="bulk">Bulk Inventory</option>
                                            </select>
                                            @error('category')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Select Type <small style="color: red">*</small></label>
                                            <select class="form-control" name="project_type_id" required>
                                                <option value=""> -- Select Project Type -- </option>
                                                @forelse($types as $data)
                                                    <option value="{{$data->id}}">{{ ucwords(str_replace('_','',$data->name)) }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('project_type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{--<div class="form-group col-md-4">
                                            <label class="d-block">Select Category (In which category you deal) <small style="color: red">*</small></label>
                                            <select class="form-control" name="category" required>
                                                <option value=""> -- Select Category -- </option>
                                            </select>
                                            @error('category')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>--}}
                                        <div class="form-group col-md-4">
                                            <label class="d-block">Select Project <small style="color: red">*</small></label>
                                            <select class="form-control" name="project_id" required>
                                                <option value=""> -- Select Project -- </option>
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="d-block floor">Floor/Block <small style="color: red">*</small></label>
                                            <select class="form-control" name="floor_id" required>
                                                <option value=""> -- Select Floor/Block -- </option>
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 bulk">
                                            <label class="d-flex align-items-center">
                                                <label>Unit No <sup style="color: red">*</sup></label>
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
                                        {{--<div class="form-group col-md-4">
                                            <label class="d-block">Select Project <small style="color: red">*</small></label>
                                            <select class="form-control" name="project_id" required>
                                                <option value=""> -- Select Project -- </option>
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>--}}
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

            $('select[name="project_id"]').on('change', function () {
                var project_id = $(this).val();
                if (project_id) {
                    var arr = ['floor','bulk']
                    var category = $('select[name="category"] :selected').val();
                    if(arr.includes(category)){
                        if(category == 'bulk'){
                            $.ajax({
                                url: "{{ url(RolePrefix().'/get-project') }}/" + type_id,
                                type: "GET",
                                dataType: "json",
                                success: function (data) {
                                    $('.table_data').empty();
                                    if(data.length){
                                        $.each(data, function (key, value) {
                                            $('.table_data').append('<tr>' +
                                                '<td>'+value.id+'</td>' +
                                                '<td>'+value.name+'</td>' +
                                                '</tr>');
                                        });
                                    }else{
                                        $('.table_data').append('<tr>' +
                                            '<td colspan="3">No Projects Found</td>' +
                                            '</tr>');
                                    }
                                    // alert(data.length);
                                    // console.log(data);
                                    // $('select[name="project_id"]').empty();
                                    // if (data.length === 0) {
                                    //     $('select[name="project_id"]').append('<option value="">N/A</option>');
                                    // } else {
                                    //     $('select[name="project_id"]').append('<option value="">Please  Select</option>');
                                    //     $.each(data, function (key, value) {
                                    //         $('select[name="project_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                    //     });
                                    // }
                                },
                            });
                        }else if(category == 'floor'){
                            $.ajax({
                                url: "{{ url(RolePrefix().'/get-floor-block') }}/" + project_id,
                                type: "GET",
                                dataType: "json",
                                success: function (data) {
                                    $('select[name="floor_id"]').empty();
                                    if (data.length === 0) {
                                        $('select[name="floor_id"]').append('<option value="">N/A</option>');
                                    } else {
                                        $('select[name="floor_id"]').append('<option value="">Please  Select</option>');
                                        $.each(data, function (key, value) {
                                            $('select[name="floor_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                        });
                                    }
                                },
                            });
                        }

                    }else{
                        $.ajax({
                            url: "{{ url(RolePrefix().'/get-project') }}/" + type_id,
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                $('.table_data').empty();
                                if(data.length){
                                    $.each(data, function (key, value) {
                                        $('.table_data').append('<tr>' +
                                            '<td>'+value.id+'</td>' +
                                            '<td>'+value.name+'</td>' +
                                            '</tr>');
                                    });
                                }else{
                                    $('.table_data').append('<tr>' +
                                        '<td colspan="3">No Projects Found</td>' +
                                        '</tr>');
                                }
                                // alert(data.length);
                                // console.log(data);
                                // $('select[name="project_id"]').empty();
                                // if (data.length === 0) {
                                //     $('select[name="project_id"]').append('<option value="">N/A</option>');
                                // } else {
                                //     $('select[name="project_id"]').append('<option value="">Please  Select</option>');
                                //     $.each(data, function (key, value) {
                                //         $('select[name="project_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                //     });
                                // }
                            },
                        });
                    }

                }
                // console.log(arr)
                // var type_id = $('select[name="project_type_id"] :selected').val();
                // if (type_id) {
                //
                // } else {
                //     alert('danger');
                // }
            });

            // $('select[name="project_id"]').on('change', function () {
            //     var project_id = $(this).val();
            //     if (project_id) {
            //         $.ajax({
            {{--            url: "{{ url(RolePrefix().'/get-inventories') }}/" + project_id,--}}
            //             type: "GET",
            //             dataType: "json",
            //             success: function (data) {
            //                 $('select[name="project_id"]').empty();
            //                 if (data.length === 0) {
            //                     $('select[name="project_id"]').append('<option value="">N/A</option>');
            //                 } else {
            //                     $('select[name="project_id"]').append('<option value="">Please  Select</option>');
            //                     $.each(data, function (key, value) {
            //                         $('select[name="project_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
            //                     });
            //                 }
            //             },
            //         });
            //     } else {
            //         alert('danger');
            //     }
            // });

        });
    </script>
@endsection
