@extends((new App\Helpers\Helpers)->user_login_route()['file'].'.layout.app')
@section('title', 'Add Lead')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('property.store', ['panel' => Helpers::user_login_route()['panel']]) }}">
                            <div class="card">
                                @csrf
                                <div class="card-header">
                                    <h4>Assign To</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="inbox-header text-right">
                                                @if(Helpers::isPropertyAdmin())
                                                    <button type="button" class="btn btn-primary assign" data-value="self">Self</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="all_property_manager">All Property Manager</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="all_sale_manager">All Sale Manager</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="all_sales_person">All Sales Person</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="individual">Individual</button>
                                                @endif
                                                @if(Helpers::isPropertyManager())
                                                    <button type="button" class="btn btn-primary assign" data-value="self">Self</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="all_sale_manager">All Sale Manager</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="all_sales_person">All Sales Person</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="individual">Individual</button>
                                                @endif
                                                @if(Helpers::isSaleManager())
                                                    <button type="button" class="btn btn-primary assign" data-value="self">Self</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="all_sales_person">All Sales Person</button>
                                                    <button type="button" class="btn btn-primary assign" data-value="individual">Individual</button>
                                                @endif
                                                @if(Helpers::isEmployee())
                                                    <button type="button" class="btn btn-primary assign" data-value="self">Self</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="show_form form-group col-md-4">
                                            <div class="form-group">
                                                <label>Select Role <small style="color: red">*</small></label>
                                                <select class="form-control" name="role" reqiured></select>
                                                @error('building_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 assign_to">
                                            <div class="form-group">
                                                <label>Select User<small style="color: red">*</small></label>
                                                <select class="form-control" name="assign_to" reqiured>
                                                    <option value=""> -- Select User -- </option>
                                                </select>
                                                @error('building_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Target</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Type <small style="color: red">*</small></label>
                                                <select class="form-control" name="type" reqiured>
                                                    <option value=""> -- Select Type --</option>
                                                    <option value="client" {{old('type') == 'client' ? 'selected' : ''}}>Client Register</option>
                                                    <option value="lead" {{old('type') == 'lead' ? 'selected' : ''}}>Leads</option>
                                                    <option value="call" {{old('type') == 'call' ? 'selected' : ''}}>Calls</option>
                                                    <option value="meeting" {{old('type') == 'meeting' ? 'selected' : ''}}>Meetings</option>
                                                    <option value="conversion" {{old('type') == 'conversion' ? 'selected' : ''}}>Conversion</option>
                                                </select>
                                                @error('building_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Target <small style="color: red">*</small></label>
                                                <input type="number" class="form-control" name="target" value="{{old('target')}}" reqiured>
                                                @error('building_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Date Range Picker</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="date" class="form-control daterange-cus">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <input class="btn btn-primary" type="submit" value="Submit">
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
            $('.show_form').hide();
            $('.assign').click(function(){
                let role = "{{Auth::user()->roles[0]->name}}";
                let val = $(this).data('value');
                if(val == 'individual'){
                    $('select[name="role"]').empty();
                    $('select[name="role"]').append('<option value=""> -- Select Role --</option>');
                    if(role == 'property_admin'){
                        $('select[name="role"]').append('<option value="property_manager">Property Manager</option>');
                        $('select[name="role"]').append('<option value="sale_manager">Sale Manager</option>');
                        $('select[name="role"]').append('<option value="sale_person">Sale Person</option>');
                    }
                    if(role == 'property_manager'){
                        $('select[name="role"]').append('<option value="sale_manager">Sale Manager</option>');
                        $('select[name="role"]').append('<option value="sale_person">Sale Person</option>');
                    }
                    if(role == 'sale_manager'){
                        $('select[name="role"]').append('<option value="sale_person">Sale Person</option>');
                    }
                    $('.show_form').show();
                }else{
                    var new_val = '';
                    switch (val) {
                        case 'self': new_val = 'Self';
                            break;
                        case 'all_property_manager': new_val = 'All Propert Manager';
                            break;
                        case 'all_sale_manager': new_val = 'All Sale Manager';
                            break;
                        case 'all_sales_person': new_val = 'All Sales Person';
                            break;
                        default : new_val = '';
                            break;
                    }
                    $('.assign_to').hide();
                    $('select[name="role"]').empty();
                    $('select[name="assign_to"]').empty();
                    $('select[name="role"]').append('<option>'+new_val+'</option>');
                    $('select[name="assign_to"]').append('<option value="'+val+'"></option>');
                    $('.show_form').show();
                }
            });
            $('.assign_to').hide();
            $('select[name="role"]').on('change', function () {
                var role = $(this).val();
                if (role) {
                    $.ajax({
                        url: "{{ url(Helpers::user_login_route()['panel'].'/get-role-list') }}/" + role,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="assign_to"]').empty();
                            if (data.length === 0) {
                                $('select[name="assign_to"]').append('<option value="">N/A</option>');
                            } else {
                                $('select[name="assign_to"]').append('<option value=""> Please Select </option>');
                                $.each(data, function (key, value) {
                                    let oldFloorId = '{{ old('assign_to') }}';
                                    let selected = (value.id == oldFloorId) ? "selected" : "";
                                    $('select[name="assign_to"]').append('<option '+selected+' value="' + value.id + '">' + value.username + '</option>');
                                });
                            }
                            $('.assign_to').show();
                        },
                    });
                } else {
                    $('.assign_to').hide();
                }
            });
            $('.daterange-cus').daterangepicker({
                locale: { format: 'YYYY-MM-DD' },
                drops: 'down',
                opens: 'right'
            });
        });
    </script>
@endsection
