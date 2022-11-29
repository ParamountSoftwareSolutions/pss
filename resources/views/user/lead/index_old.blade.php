@extends('user.layout.app')
@section('title', 'Leads')
@section('style')
<style>
    .dropdown-item {
        cursor: pointer;
    }

    .badge {
        color: white !important;

    }

    .btn-info:hover {
        color: white !important;
    }
</style>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <span>{{ $message }}</span>
                    </div>
                    @endif
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <span>{{ $message }}</span>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header d-flex justify-content-right align-items-center">
                            <h4>Leads</h4>
                            <div class="card-header-action">
                                <div class="row justify-content-end">
                                    <a class=" btn mb-2 mr-sm-2 pushed" style="background-color: #34395e" type="button">Pushed Meetings</a>
                                    <a class=" btn mb-2 mr-sm-2 arrange" style="background-color: #34395e" type="button">Meetings</a>
                                    <form class="form-inline" method="POST" action="">
                                        @csrf
                                        <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="id" placeholder="Property Id">
                                        <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="name" placeholder="Name">
                                        <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="country" placeholder="Country">
                                        <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="number" placeholder="Number">
                                        <button type="submit" class="btn btn-danger mb-2 mr-sm-2 ">Search</button>
                                    </form>
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Assign Lead</a>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <a class="dropdown-item has-icon lead_assign" data-id="{{Auth::user()->id}}">{{Auth::user()->username}}</a>

                                            <a class="dropdown-item has-icon lead_assign" data-id=""></a>

                                        </div>
                                    </div>

                                    <form id="dateForm" class="form-inline" method="POST" action="">
                                        @csrf
                                        <input type="date" id="dateFrom" class="form-control form-control-sm mb-2 mr-sm-2" name="from" placeholder="From" required>
                                        <input type="date" id="dateTo" class="form-control form-control-sm mb-2 mr-sm-2" name="to" placeholder="To">
                                        <button type="submit" class="btn btn-danger mb-2 mr-sm-2 " style="display: none">Search</button>
                                    </form>

                                    <a href="" class=" btn mb-2" style="background-color: #34395e" type="button">Follow Up</a>
                                    <div class="col-md-5">

                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Sales Person</a>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">

                                                <a class="dropdown-item has-icon sales_person" data-id=""></a>

                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle" aria-expanded="false">Sales Manger</a>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">

                                                <a class="dropdown-item has-icon sales_manager" data-id=""></a>

                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" aria-expanded="false">Status</a>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item has-icon status" data-value="new">New</a>
                                                <a class="dropdown-item has-icon status" data-value="follow_up">Follow Up</a>
                                                <a class="dropdown-item has-icon status" data-value="arrange_meeting">Arrange Meeting</a>
                                                <a class="dropdown-item has-icon status" data-value="meet_client">Meet Client</a>
                                                <a class="dropdown-item has-icon status" data-value="mature">Mature</a>
                                                <a class="dropdown-item has-icon status" data-value="lost">Lost</a>
                                                <a class="dropdown-item has-icon status" data-value="unassigned">UnAssigned</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="btn btn-secondary dropdown-toggle" aria-expanded="false">Filter By Day</a>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item has-icon filter_date" data-value="today">Today</a>
                                                <a class="dropdown-item has-icon filter_date" data-value="yesterday">Yesterday</a>
                                                <a class="dropdown-item has-icon filter_date" data-value="this_week">This week</a>
                                                <a class="dropdown-item has-icon filter_date" data-value="this_month">This Month</a>
                                                <a class="dropdown-item has-icon filter_date" data-value="last_month">Last Month</a>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="btn btn-secondary fb_lead" data-id="fb_lead" aria-expanded="false">Facebook Leads</a>
                                        </div>

                                        <div class="dropdown">
                                            <a href="{{route('leads.create', ['RolePrefix' => RolePrefix()])}}" class="btn btn-info">Add
                                                New</a>
                                        </div>
                                    </div>
                                </div>
                                <form action="" class="filter_form" method="POST">
                                    @csrf
                                    <input type="hidden" name="sales_person">
                                    <input type="hidden" name="sales_manager">

                                    <input type="hidden" name="fb_lead">
                                    <input type="hidden" name="status">
                                    <input type="hidden" name="filter_date">
                                </form>
                                <form action="" class="push_form" method="POST">
                                    @csrf
                                </form>
                                <form action="" class="arrange_form" method="POST">
                                    @csrf
                                </form>
                                <form action="" class="assign_form" method="POST">
                                    @csrf
                                    <input type="hidden" name="sale_id">
                                    <input type="hidden" name="sale_person_id">
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control-sm" aria-label="Default select example">
                                            <option selected>10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <form class="form-inline float-right" method="GET" action="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">
                                            <input type="text" class="form-control form-control-sm mb-2 mr-sm-2" name="search" placeholder="Search">
                                            <button type="submit" class="btn btn-danger btn-sm mb-2 mr-sm-2 ">Search</button>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <div class="custom-checkbox custom-checkbox-table custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all" name="sale[]">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
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
                                        @if(!empty($sales))
                                        @foreach($sales as $key => $data)
                                        @php
                                        if($data->order_status == 'new'){
                                        $color = 'primary';
                                        }
                                        elseif($data->order_status == 'active'){
                                        $color = 'success';
                                        }
                                        elseif($data->order_status == 'mature' || $data->order_status == 'arrange_meeting'){
                                        $color = 'danger';
                                        }
                                        elseif($data->order_status == 'follow_up'){
                                        $color = 'warning';
                                        }
                                        elseif($data->order_status == 'lost'){
                                        $color = 'light';
                                        }
                                        elseif($data->order_status == 'meet_client'){
                                        $color = 'secondary';
                                        }
                                        else{
                                        $color = 'secondary';
                                        }
                                        @endphp
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
                                            <td>{{ $data->sale_person->username ?? ''}}</td>
                                            <td>{{ ($data->building !== null) ? $data->building->name : 'N/A'}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" data-toggle="dropdown" class="badge badge-{{$color}}" aria-expanded="false">{{ ucwords(Illuminate\Support\Str::replace('_', ' ', $data->order_status)) }}</a>
                                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a href="#" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="follow_up">Follow Up</a>
                                                        <a href="#" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="arrange_meeting">{{$data->order_status == 'arrange_meeting' ? 'Reschedule Meeting' : 'Arrange Meeting' }}</a>
                                                        <a href="#" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="meet_client">Meet Client</a>
                                                        <a href="#" class="dropdown-item has-icon change_status" data-id="{{$data->id}}" data-value="mature">Mature</a>
                                                        <a href="#" class="dropdown-item has-icon change_status" data-id="{{$data->id}}" data-value="lost">Lost</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" data-toggle="dropdown" class="badge @if($data->priority == 'very_hot')
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
                                                        <a href="" class="dropdown-item has-icon @if($data->priority == 'very_hot') d-none  @endif">Very Hot
                                                        </a>
                                                        <a href="" class="dropdown-item has-icon @if($data->priority == 'hot') d-none @endif">Hot
                                                        </a>
                                                        <a href="" class="dropdown-item has-icon @if($data->priority == 'moderate') d-none @endif">Moderate
                                                        </a>
                                                        <a href="" class="dropdown-item has-icon @if($data->priority == 'cold') d-none @endif">Cold
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>

                                                <a href="{{route('leads.edit', ['RolePrefix' => RolePrefix(),$data->id])}}" class="btn btn-primary btn-sm px-1 py-0" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <button type="button" title="Delete" data-url="" data-token="{!! csrf_token() !!}" class="btn btn-danger btn-sm px-1 py-0 deleteBtn">
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                                <a href="" class="btn btn-info btn-sm px-1 py-0"><i class="fa fa-comments"></i></a>
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
                                <div class="d-flex justify-content-center">
                                    {!! $sales->appends(request()->query())->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- basic modal -->
<form id="statusForm">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    $(function() {
        $(document).on("click", "#pagination a,#search_btn", function() {

            //get url and make final url for ajax 
            var url = $(this).attr("href");
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append + $("#searchform").serialize();

            //set to current url
            window.history.pushState({}, null, finalURL);

            $.get(finalURL, function(data) {
                $("#pagination_data").html(data);
            });
            return false;
        })

    });
</script>
<script>
    $(document).ready(function() {
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
        $('.status').click(function() {
            $('input[name="status"]').val($(this).attr('data-value'));
            submit();
        });
        $('.filter_date').click(function() {
            $('input[name="filter_date"]').val($(this).attr('data-value'));
            submit();
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
            $('.filter_form').submit();
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
            /*console.log($('input[name="sale_id"]').val())*/
            $('input[name="sale_person_id"]').val(sale_person_id);
            assign_form_submit();
        });

        function assign_form_submit() {
            $('.assign_form').submit();
        }

        function meetingSubmit() {
            $('.push_form').submit();
        }

        $("body").on("click", ".change_status", function() {
            var status = $(this).attr('data-value');
            var id = $(this).attr('data-id');
            $('#form_status').val(status);
            $('#form_id').val(id);
            $('#statusForm').attr('action', "");
            $('#statusModal').modal('show');
        });

        $('#statusForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "",
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.status == 'success') {
                        $('#statusModal').modal('hide');
                        successMsg(data.message);
                        setTimeout(function() {
                            // window.location.href = "";
                        }, 1000);
                    }
                    if (data.status == 'error') {
                        errorMsg(data.message);
                    }
                },
            });
        });
    });
</script>
@endsection