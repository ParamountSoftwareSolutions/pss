@extends('user.layout.app')
@section('title', 'Clients')
@section('style')

@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title-box">
            <h4 class="page-title">Clients</h4>
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <span>{{ $message }}</span>
</div>
@elseif ($message = Session::get('error'))
<div class="alert alert-danger">
    <span>{{ $message }}</span>
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Clients Filters</h4>
                <div class="row d-flex mb-3 pt-3">
                    <a href="{{route('clients.index', ['RolePrefix' => RolePrefix()])}}" class="btn btn-success">All Clients</a>
                </div>

                <!-- Search By Project And Date Range -->
                <div class="row">
                    <div class="col-md-12 form-inline">
                        <form id="projectForm" class="form-inline float-right" method="GET" action="{{route('clients.index', ['RolePrefix' => RolePrefix()])}}">
                            <select name="project" class="form-control ml-auto" style="border-radius: 5px">
                                <option value="" disabled selected style="color:rgb(75, 106, 108)">Search By Projects</option>
                                @if (!empty($building))
                                @foreach ($building as $data_building)
                                <option value="{{ ($data_building->id !== null) ? $data_building->id :"" }}">{{ ($data_building['name']!== null) ? $data_building['name'] :"" }}</option>
                                @endforeach
                                @endif
                            </select>
                            <!-- <input type="hidden" name="project_name"> -->
                        </form>
                        <form id="dateForm" class="form-inline float-right" method="GET" action="{{route('clients.index', ['RolePrefix' => RolePrefix()])}}">
                            <div class="form-group d-flex">
                                <label for="" class="mr-2 ">From: </label>
                                <input type="date" id="dateFrom" class="form-control mb-2 mr-sm-2" name="from" placeholder="From" required>
                            </div>
                            <div class="form-group d-flex">
                                <label for="" class="mr-2 ">To: </label>
                                <input type="date" id="dateTo" class="form-control mb-2 mr-sm-2" name="to" placeholder="To">
                            </div>
                            <button type="submit" class="btn" style="display: none">Search</button>
                        </form>
                    </div>
                </div>
                <!-- Search By Project And Date Range -->
                <div class="row justify-content-end pb-3 pr-0">
                    <div class="mr-auto d-flex">
                        <div class="dropdown">
                            <button href="javascript:void(0)" data-toggle="dropdown" class="btn dropdown-toggle" aria-expanded="false">Sale Person</button>
                            <div class="dropdown-menu overflow-auto" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                @if(!empty($sale_persons))
                                @foreach($sale_persons as $sale_value)
                                <a class="dropdown-item has-icon salePersonFilter" data-id="{{$sale_value['id']}}">{{$sale_value['name']}}<span class="badge ml-2 " style="background-color:#5F4B8BFF">Sale Person</span></a>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <form id="salePersonFilterForm" method="GET" action="{{route('clients.index', ['RolePrefix' => RolePrefix()])}}">
                            <input type="hidden" name="salePersonFilter">
                        </form>
                        <div class="dropdown">
                            <button href="#" data-toggle="dropdown" class="btn dropdown-toggle" aria-expanded="false">All Tasks</button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item has-icon statusFilter" data-value="Mature">Mature</a>
                                <a class="dropdown-item has-icon statusFilter" data-value="Active">Active</a>
                                <a class="dropdown-item has-icon statusFilter" data-value="Cancelled">Cancelled</a>
                                <a class="dropdown-item has-icon statusFilter" data-value="Transfered">Transfered</a>
                                <a class="dropdown-item has-icon statusFilter" data-value="Suspended">Suspended</a>
                            </div>
                        </div>
                        <form id="statusFormFilter" method="GET" action="{{route('clients.index', ['RolePrefix' => RolePrefix()])}}">
                            <input type="hidden" name="statusFilter">
                        </form>
                        <div class="dropdown">
                            <button href="#" data-toggle="dropdown" class="btn dropdown-toggle" aria-expanded="false">Filter By Day</button>
                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item has-icon filter_date" data-value="today">Today</a>
                                <a class="dropdown-item has-icon filter_date" data-value="yesterday">Yesterday</a>
                                <a class="dropdown-item has-icon filter_date" data-value="this_week">This week</a>
                                <a class="dropdown-item has-icon filter_date" data-value="this_month">This Month</a>
                                <a class="dropdown-item has-icon filter_date" data-value="last_month">Last Month</a>
                            </div>
                        </div>
                        <form id="filter_form_by_date" method="GET" action="{{route('clients.index', ['RolePrefix' => RolePrefix()])}}">
                            <input type="hidden" name="filter_date">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Clients Table ({{$client_count}})</h4>
                <div class="row">
                    <div class="col-md-6">
                        <!-- <select class="form-control-sm" aria-label="Default select example">
                            <option selected>10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> -->
                    </div>
                    <div class="col-md-6">
                        <!-- <form class="form-inline float-right" method="GET" action="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">
                            <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="search" placeholder="Search">
                            <button type="submit" class="btn btn-danger btn-sm mb-2 mr-sm-2 ">Search</button>
                        </form> -->
                    </div>
                </div>
                <table id="basic-datatable111" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">
                                <div class="custom-checkbox custom-checkbox-table custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all" name="sale[]">
                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                </div>
                            </th> -->
                            <th></th>
                            <th class="text-center">#</th>
                            <th>Client Name</th>
                            <th>Client Email</th>
                            <th>Client Contact Number</th>
                            <th>Sales Person</th>
                            <th>Building</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($clients))
                        @foreach($clients as $key => $data)
                        <tr>
                            <td class="p-0 text-center">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{ $data->id }}" name="sale[]" value="{{ $data->id }}">
                                    <label for="checkbox-{{ $data->id }}" class="custom-control-label">&nbsp;</label>
                                </div>
                            </td>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name ?? '' }}</td>
                            <td>{{ $data->email ?? '' }}</td>
                            <td>{{ $data->number ?? '' }}</td>
                            <td>{{ (!empty($data['user']['name'])) ? $data['user']['name'] : 'N/A'}}</td>
                            <td>{{ (!empty($data['project']['name'])) ? $data['project']['name'] : 'N/A'}}</td>
                            <td>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="badge badge-success" aria-expanded="false">{{$data->status }}</a>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a href="javascript:void(0)" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="Active">Active</a>
                                        <a href="javascript:void(0)" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="Suspended">Suspended</a>
                                        <a href="javascript:void(0)" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="Cancelled">Cancelled</a>
                                        <a href="javascript:void(0)" class="dropdown-item has-icon change_status" data-id="{{$data->id}}" data-value="Transfered">Transfered</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="badge @if($data->priority == 'very_hot')
                                                                    badge-danger @elseif($data->priority == 'hot')
                                                                    badge-warning @elseif($data->priority == 'moderate')
                                                                    badge-primary @elseif($data->priority == 'cold')
                                                                    badge-info @else
                                                                    badge-secondary @endif
                                                                    " aria-expanded="false">
                                        @if($data->priority == null)
                                        Not Selected
                                        @else
                                        {{ ucfirst(Illuminate\Support\Str::replace('_', ' ', $data->priority)) }}
                                        @endif
                                    </a>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a href="{{ route('client.change_priority', ['RolePrefix' => RolePrefix(), 'very_hot',$data->id]) }}" class="dropdown-item has-icon @if($data->priority == 'very_hot') d-none  @endif">Very Hot
                                        </a>
                                        <a href="{{ route('client.change_priority', ['RolePrefix' => RolePrefix(), 'hot',$data->id])}}" class="dropdown-item has-icon @if($data->priority == 'hot') d-none @endif">Hot
                                        </a>
                                        <a href="{{ route('client.change_priority', ['RolePrefix' => RolePrefix(), 'moderate',$data->id])}}" class="dropdown-item has-icon @if($data->priority == 'moderate') d-none @endif">Moderate
                                        </a>
                                        <a href="{{ route('client.change_priority', ['RolePrefix' => RolePrefix(), 'cold',$data->id])}}" class="dropdown-item has-icon @if($data->priority == 'cold') d-none @endif">Cold
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <a href="{{route('clients.edit', ['RolePrefix' => RolePrefix(),$data->id])}}" class="btn btn-primary btn-sm px-1 py-0" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{route('clients.show', ['RolePrefix' => RolePrefix(),$data->id])}}" class="btn btn-primary btn-sm px-1 py-0" title="Edit">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <button type="button" title="Delete" data-url="" data-token="{!! csrf_token() !!}" class="btn btn-danger btn-sm px-1 py-0 deleteBtn">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <a href="{{route('client.comments', ['RolePrefix' => RolePrefix(),$data->id])}}" class="btn btn-info btn-sm px-1 py-0"><i class="fa fa-comments"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7"> No More Data In this Table.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<!-- basic modal -->
<form id="statusForm" method="POST">
    @csrf
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" id="form_status">
                    <input type="hidden" name="id" id="form_id">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Date</label>
                            <input type="datetime-local" name="date" class="form-control" required>
                            @error('date')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 call_status">
                            <label>Call Status</label>
                            <select name="call_status" id="call_status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="connect">Connect</option>
                                <option value="no_response">No Response</option>
                            </select>
                            @error('date')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 start_time">
                            <label>Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control">
                            @error('date')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 end_time">
                            <label>End Time</label>
                            <input type="time" name="end_time" class="form-control">
                            @error('date')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 call_time">
                            <label>Call Time</label>
                            <input type="time" id="call_time" name="call_time" class="form-control">
                            @error('date')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label>Comment</label>
                            <textarea class="form-control" name="comment" id="comment" cols="30" rows="10" required></textarea>
                            @error('comment')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="submit" class="btn btn-primary" value="submit" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')

<script>
    var elements = document.getElementsByClassName("actions")
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.display = "none";
    }
    $(document).on('mouseover', '.show', function() {
        $(this).children('.action').children('.actions').css({
            "display": "flex"
        });
    });
    $(document).on('mouseout', '.show', function() {
        $(this).children('.action').children('.actions').css({
            "display": "none"
        });
    });


    $(document).ready(function() {
        $('select[name="country"]').on('change', function() {
            var a = $(this).val();
            $('#countryForm').submit();
        });

        $('select[name="project"]').on('change', function() {
            var b = $(this).val()
            $('input[name="project_name"]').val(b)
            $('#projectForm').submit()
        });


        $('.sales_manager').click(function() {
            $('input[name="sales_manager"]').val($(this).attr('data-id'));

            submit();
        });
        $('.fb_lead').click(function() {
            $('input[name="fb_lead"]').val($(this).attr('data-id'));

            submit();
        });
        $('.sales_person').click(function() {
            $('input[name="sales_person"]').val($(this).attr('data-id'));
            submit();
        });
        $('.statusFilter').click(function() {
            $('input[name="statusFilter"]').val($(this).attr('data-value'));
            $('#statusFormFilter').submit()
        });
        $('.deadlineFilter').click(function() {
            $('input[name="deadlineFilter"]').val($(this).attr('data-value'));
            $('#deadlineFilterForm').submit()
        });
        $('.salePersonFilter').click(function() {
            $('input[name="salePersonFilter"]').val($(this).attr('data-id'));
            $('#salePersonFilterForm').submit()
        });
        $('.filter_date').click(function() {
            $('input[name="filter_date"]').val($(this).attr('data-value'));
            $('#filter_form_by_date').submit();
        });
        $('.pushed').click(function() {
            meetingSubmit();
        });

        $('.arrange').click(function() {
            $('.arrange_form').submit();
        });

        $('#dateTo').on('keyup keypress change', function() {
            var dateFrom = $('#dateFrom').val();
            if (!dateFrom) {
                errorMsg('Start Date Is Required');
                return;
            }
            $('#dateForm').submit();
        });

        function submit() {
            $('#filter_form').submit();
        }
        $('.lead_assign').click(function() {
            var sale_person_id = $(this).attr('data-id');
            var data = $('input[name="sale[]"]:checked');
            var sale_id = [];
            data.each(function(index, value) {
                sale_id.push($(value).val());
            });
            console.log(sale_id)
            $('input[name="sale_id"]').val(sale_id);
            $('input[name="sale_person_id"]').val(sale_person_id);
            assign_form_submit();
        });

        function assign_form_submit() {
            $('.assign_form').submit();
        }
        $('.lead_refer').click(function() {
            var sale_person_id = $(this).attr('data-id');
            var data = $('input[name="sale[]"]:checked');
            var sale_id = [];
            data.each(function(index, value) {
                sale_id.push($(value).val());
            });
            console.log(sale_id)
            $('input[name="sale_id"]').val(sale_id);
            $('input[name="sale_person_id"]').val(sale_person_id);
            refer_form_submit();
        });

        function refer_form_submit() {
            $('.assign_form1').submit();
        }

        function meetingSubmit() {
            $('.push_form').submit();
        }


        //Change Status
        $("body").on("click", ".change_status", function() {
            $('.start_time').hide();
            $('.end_time').hide();
            $('.call_time').hide();
            var status = $(this).attr('data-value');
            if (status == 'follow_up') {
                $('.call_status').show();
            } else {
                $('.call_status').hide();
            }
            var id = $(this).attr('data-id');
            $('#form_status').val(status);
            $('#form_id').val(id);
            $('#statusForm').attr('action', "{{route('client.change_status', ['RolePrefix' => RolePrefix()])}}");
            $('#statusModal').modal('show');
        });




        $('select[name="call_status"]').on('change', function() {
            var status = $(this).val();
            if (status == 'connect') {
                $('.start_time').show();
                $('input[name="start_time"]').attr('required', true);
                $('.end_time').show();
                $('.call_time').hide();
                $('input[name="call_time"]').removeAttr('required');
            } else {
                $('.start_time').hide();
                $('input[name="start_time"]').removeAttr('required');
                $('.end_time').hide();
                $('.call_time').show();
                $('input[name="call_time"]').attr('required', true);
            }
        });

        $('#start_time').change(function() {
            var startTime = $(this).val();
            $('input[name="end_time"]').attr('min', startTime);
        })

        // $('#statusForm').submit(function(e) {
        //     e.preventDefault();
        //     let formData = $(this).serialize();
        //     $.ajax({
        //         url: "{{ route('lead.change_status', ['RolePrefix' => RolePrefix()]) }}",
        //         type: "POST",
        //         data: formData,
        //         success: function(data) {
        //             if (data.status == 'success') {
        //                 $('#statusModal').modal('hide');
        //                 successMsg(data.message);
        //                 setTimeout(function() {
        //                     window.location.href = "";
        //                 }, 1000);
        //             }
        //             if (data.status == 'error') {
        //                 errorMsg(data.message);
        //             }
        //         },
        //     });
        // });
    });

    //Change Status
</script>
<script>
    function getComboA(selectObject) {
        const queryString = window.location.search;


        var value = selectObject.value;
        var url_string = document.URL;
        var url = new URL(url_string);
        //var page = url.searchParams.get("page");
        //var url = "";
        //alert(page);
        //var string = document.location.pathname;
        //		if (url.match(/\?./)) {
        //  console.log(url.split('?'))
        //}
        //		alert(url.split('?'));
        //var arr = string.split('?');
        //		//var arr = url.split('?');
        //if (arr.length > 1 && arr[1] !== '') {
        //  alert();
        //}
        if (queryString) {
            var url = document.URL + '&limit=' + value;
        } else {
            var url = document.URL + '?limit=' + value;
        }
        window.location.href = url;

    }
</script>
@endsection
