@extends('user.layout.app')
@section('title', 'Payment Plan Create')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form id="payment_plan_form" method="post" action="{{ route('dealer.add_new_store',['RolePrefix'=>RolePrefix(),'dealer'=>$id]) }}">
                            @csrf
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
                                            <label class="d-block">Select Project <small style="color: red">*</small></label>
                                            <select class="form-control" name="project_id" required>
                                                <option value=""> -- Select Project -- </option>
                                                @forelse($projects as $data)
                                                    <option value="{{$data->id}}">{{ ucwords(str_replace('_','',$data->name)) }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger mt-2">
                                                {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row floor">
                                        <div class="form-group col-md-4">
                                            <label class="d-block floor">Floor/Block <small style="color: red">*</small></label>
                                            <select class="form-control" name="floor_id[]" multiple>
                                                <option value=""> -- Select Floor/Block -- </option>
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row bulk align-items-end">
                                        <div class="form-group col-md-4">
                                            <label class="d-flex align-items-center">
                                                <label>Unit No <sup style="color: red">*</sup></label>
                                            </label>
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control bulk_unit_no" name="bulk_unit_no[]" class="input-group-text" value="{{ old
                                                ('unit_no') }}" placeholder="unit name">
                                                <div class="input-group-prepend preselection-prepend">
                                                    <div class="input-group-text">-</div>
                                                </div>
                                                <input type="number" class="form-control start_unit_no" name="start_unit_no[]" value="{{ old('start_unit_no[]') }}"
                                                       placeholder="start unit">
                                                <div class="input-group-prepend preselection-prepend">
                                                    <div class="input-group-text">-</div>
                                                </div>
                                                <input type="number" class="form-control end_unit_no" name="end_unit_no[]" value="{{ old('end_unit_no[]') }}"
                                                       placeholder="end
                                                 unit">
                                            </div>
                                            @error('simple_unit_no')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="add_new_btn form-group col-md-4 pb-1">
                                            <button class="btn btn-primary btn-sm add_new" type="button">+</button>
                                            <button class="btn btn-primary btn-sm remove" type="button">-</button>
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
            $('.add_new').click(function () {
                var bulk_input = '' +
                    '<div class="form-group col-md-4">' +
                    '   <label class="d-flex align-items-center">' +
                    '       <label>Unit No <sup style="color: red">*</sup></label>' +
                    '   </label>' +
                    '   <div class="input-group mb-2">' +
                    '       <input type="text" class="form-control bulk_unit_no" name="bulk_unit_no[]" class="input-group-text"'+
                    '           placeholder="unit name" required>' +
                    '       <div class="input-group-prepend preselection-prepend">' +
                    '           <div class="input-group-text">-</div>' +
                    '       </div>' +
                    '      <input type="number" class="form-control start_unit_no" name="start_unit_no[]"' +
                    '           placeholder="start unit" required>' +
                    '      <div class="input-group-prepend preselection-prepend">' +
                    '           <div class="input-group-text">-</div>' +
                    '       </div>' +
                    '      <input type="number" class="form-control end_unit_no" name="end_unit_no[]"' +
                    '           placeholder="end unit" required>' +
                    '   </div>' +
                    '</div>';
                    $('.add_new_btn').before(bulk_input);
            })

            $('.remove').click(function () {
                $('.add_new_btn').prev().remove();
            })
            $('.floor').hide();
            $('.bulk').hide();
            $('select[name="project_id"]').on('change', function () {
                var project_id = $(this).val();
                if (project_id) {
                    var category = $('select[name="category"] :selected').val();
                    getFloorBlockOrBulkInventory(project_id,category)
                }
            });
            $('select[name="category"]').on('change', function () {
                var category = $(this).val();
                var project_id = $('select[name="project_id"] :selected').val();
                if(project_id){
                    getFloorBlockOrBulkInventory(project_id,category)
                }else{
                    $('input[name="bulk_unit_no[]"]').removeAttr('required');
                    $('input[name="start_unit_no[]"]').removeAttr('required');
                    $('input[name="end_unit_no[]"]').removeAttr('required');
                    $('input[name="floor_id[]"]').removeAttr('required');
                    $('.floor').hide();
                    $('.bulk').hide();
                }
            })
            $('input[name="actual_amount"],input[name="rebate"],input[name="received"]')
                .on('keyup kepress change',function () {
                var actual_amount = Number($('input[name="actual_amount"]').val());
                var rebate_amount = $('input[name="rebate"]').val();
                var received_amount = Number($('input[name="received"]').val());
                if(actual_amount){
                    var str2 = "%";
                    if(rebate_amount.indexOf(str2) != -1){
                        var rb = Number(rebate_amount.replace('%',''));
                        var rebate = (rb * actual_amount) / 100;
                    }else{
                        rebate = Number(rebate_amount);
                    }
                    var pending = actual_amount - rebate - received_amount;
                    $('input[name="pending"]').val(pending);
                }else{
                    $('input[name="pending"]').val(0);
                }
            })
            $('input[name="actual_amount"]').on('keyup kepress change',function () {
                var actual_amount = $(this).val();
                $('input[name="received"]').attr('max',actual_amount);
            })
        });
        function getFloorBlockOrBulkInventory(project_id,category)
        {
            var arr = ['floor','bulk']
            if(arr.includes(category)){
                if(category == 'bulk'){
                    $('input[name="bulk_unit_no[]"]').attr('required',true);
                    $('input[name="start_unit_no[]"]').attr('required',true);
                    $('input[name="end_unit_no[]"]').attr('required',true);
                    $('input[name="floor_id[]"]').removeAttr('required');
                    $('.floor').hide();
                    $('.bulk').show();
                }else if(category == 'floor'){
                    $.ajax({
                        url: "{{ url(RolePrefix().'/get-floor-block') }}/" + project_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="floor_id[]"]').empty();
                            if (data.length === 0) {
                                $('select[name="floor_id[]"]').append('<option value="">N/A</option>');
                            } else {
                                $('select[name="floor_id[]"]').append('<option value="">Please  Select</option>');
                                $.each(data, function (key, value) {
                                    $('select[name="floor_id[]"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                                });
                            }
                        },
                    });
                    $('input[name="bulk_unit_no[]"]').removeAttr('required');
                    $('input[name="start_unit_no[]"]').removeAttr('required');
                    $('input[name="end_unit_no[]"]').removeAttr('required');
                    $('input[name="floor_id[]"]').attr('required',true);
                    $('.floor').show();
                    $('.bulk').hide();
                }
            }else{
                $('input[name="bulk_unit_no[]"]').removeAttr('required');
                $('input[name="start_unit_no[]"]').removeAttr('required');
                $('input[name="end_unit_no[]"]').removeAttr('required');
                $('input[name="floor_id[]"]').removeAttr('required');
                $('.floor').hide();
                $('.bulk').hide();
            }
        }
    </script>
@endsection
