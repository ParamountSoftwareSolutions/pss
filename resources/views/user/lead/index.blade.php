@extends('user.layout.app')
@section('title', 'Leads')
@section('style')
<<<<<<< HEAD
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
                                    <a class="text-white btn mb-2 mr-sm-2 pushed" style="background-color: #34395e" type="button">Pushed Meetings</a>
                                    <a class="text-white btn mb-2 mr-sm-2 arrange" style="background-color: #34395e" type="button">Meetings</a>
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

                                    <a href="" class="text-white btn mb-2" style="background-color: #34395e" type="button">Follow Up</a>
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
=======

@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Datatables</h4>
            <div class="page-title-right">
            
            <a href="{{route('leads.store', ['RolePrefix' => RolePrefix()])}}" class="btn btn-success">Add New</a>
        </div>
        </div>
       
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="cardContent  pl-3 pr-4">
                    <div class="row d-flex mb-3 pt-3">
                        <div class="">
                            <a href="" class="btn " style="background-color:darkcyan;">All Leads</a>
                        </div>
                        <div class="">
                            <button class=" btn arrange" style="background-color: #bb6a06" type="button">Meetings ()</button>
                        </div>
                        <div class="">
                            <button class=" btn pushed" style="background-color: #bb6a06" type="button">Meetings Pushed ()</button>
                        </div>
                        <form id="countryForm" class="form-inline ml-auto" action="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">
                            @csrf
                            <input type="hidden" name="country_filter">
                            <div class="form-group mr-2">
                                <select name="country" class="form-control" style="border-radius: 5px">
                                    <option value="" disabled selected style="color:rgb(75, 106, 108)">Country</option>
                                    @foreach($country as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control mr-sm-2" name="searchRequest" placeholder="Id, Name, Number">
                            </div>
                            <input type="hidden" name="country_name">
                            <button type="submit" class="btn" style="background-color: #06a6bb">Search</button>
                        </form>

                    </div>
                    <div class="row justify-content-end mb-3 pl-2">
                        <div class="mr-auto d-flex align-items-center">
                            <h6 class="mr-5">Deadline Keys:</h6>
                            <a href="{{ route('lead.overdueDay', ['RolePrefix' => RolePrefix()]) }}" class="mr-5 "><i class="fa fa-exclamation-triangle mr-2" style="color:orange!important"></i>Overdue</a>
                            <a href="{{ route('lead.insingleDay', ['RolePrefix' => RolePrefix()]) }}" class="mr-5 "><i class="fa fa-circle mr-2" style="color: red !important"></i>Within 1 Day</a>
                            <a href="{{ route('lead.intwoDay', ['RolePrefix' => RolePrefix()]) }}" class="mr-5 "><i class="fa fa-circle mr-2" style="color: yellow !important"></i>Within 2 Day</a>
                            <a href="{{ route('lead.aftertwoDay', ['RolePrefix' => RolePrefix()]) }}" class="mr-5 "><i class="fa fa-circle mr-2" style="color: green !important"></i>After 2 Day</a>
                        </div>
                        <form id="projectForm" method="post" class="form-inline" action="{{route('leads.store', ['RolePrefix' => RolePrefix()])}}">
                            @csrf
                            <div class="form-group col-md-6 pr-2">
                                <select name="project" class="form-control ml-auto" style="border-radius: 5px">
                                    <option value="" disabled selected style="color:rgb(75, 106, 108)">Search By Projects</option>
                                    @if (!empty($building))
                                    @foreach ($building as $data)
                                    <option value="{{ ($data->id!== null) ? $data->id :"" }}">{{ ($data->name!== null) ? $data->name :"" }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <input type="hidden" name="project_name">
                        </form>
                    </div>
                    <div class="row justify-content-end pb-3 pr-0">

                        <div class="mr-auto d-flex">
                            <div class="dropdown">
                                <button href="#" data-toggle="dropdown" style="background-color: #8d7300" class="btn dropdown-toggle" aria-expanded="false">Assign Lead</button>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item has-icon lead_assign" data-id="{{Auth::user()->id}}">{{Auth::user()->username}}</a>

                                    <a class="dropdown-item has-icon lead_assign" data-id="">sale person</a>

                                </div>
                            </div>

                            <div class="dropdown">
                                <button href="#" data-toggle="dropdown" style="background-color: #82003a" class="btn dropdown-toggle" aria-expanded="false">Agents</button>
                                <div class="dropdown-menu overflow-auto" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">



                                    <a class="dropdown-item has-icon sales_manager" data-id="">sale manager<span class="badge ml-2 " style="background-color:#5F4B8BFF">Sale Manager</span></a>


                                </div>
                            </div>


                            <div class="dropdown">
                                <button href="#" data-toggle="dropdown" style="background-color: #42007c" class="btn dropdown-toggle" aria-expanded="false">All Tasks</button>
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
                                <button href="#" data-toggle="dropdown" style="background-color: #a60202" class="btn dropdown-toggle" aria-expanded="false">Filter By Day</button>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item has-icon filter_date" data-value="today">Today</a>
                                    <a class="dropdown-item has-icon filter_date" data-value="yesterday">Yesterday</a>
                                    <a class="dropdown-item has-icon filter_date" data-value="this_week">This week</a>
                                    <a class="dropdown-item has-icon filter_date" data-value="this_month">This Month</a>
                                    <a class="dropdown-item has-icon filter_date" data-value="last_month">Last Month</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <button href="#" data-toggle="dropdown" style="background-color: #00578d" class="btn fb_lead" data-id="fb_lead" aria-expanded="false">Facebook Leads ()</button>
                            </div>

                            <div class="">
                                <a href="followup" class="btn mb-1 " style="background-color: #0ba254;  box-shadow: 0px 0px 20px 3px rgb(201, 245, 162)" type="button">Follow Up Leads (count)</a>
                            </div>
                        </div>
                        <form id="dateForm" class="form-inline ml-auto" method="POST" action="searchByDAte">
                            @csrf
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
                <form action="filtter" class="filter_form" method="POST">
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
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Basic Data Table</h4>
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
                <table id="basic-datatable111" class="table dt-responsive nowrap w-100">
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
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="badge badge-{{$color}}" aria-expanded="false">{{ ucwords(Illuminate\Support\Str::replace('_', ' ', $data->status)) }}</a>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a href="javascript:void(0)" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="follow_up">Follow Up</a>
                                        <a href="javascript:void(0)" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="arrange_meeting">{{$data->status == 'arrange_meeting' ? 'Reschedule Meeting' : 'Arrange Meeting' }}</a>
                                        <a href="javascript:void(0)" class="dropdown-item has-icon  change_status" data-id="{{$data->id}}" data-value="meet_client">Meet Client</a>
                                        <a href="javascript:void(0)" class="dropdown-item has-icon change_status" data-id="{{$data->id}}" data-value="mature">Mature</a>
                                        <a href="javascript:void(0)" class="dropdown-item has-icon change_status" data-id="{{$data->id}}" data-value="lost">Lost</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="badge @if($data->priority == 'very_hot')
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
                                                                    badge-danger @elseif($data->priority == 'hot')
                                                                    badge-warning @elseif($data->priority == 'moderate')
                                                                    badge-primary @elseif($data->priority == 'cold')
                                                                    badge-info @else
                                                                    badge-secondary @endif
                                                                    " aria-expanded="false">
<<<<<<< HEAD
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
=======
                                        @if($data->priority == null)
                                        Not Selected
                                        @else
                                        {{ ucfirst(Illuminate\Support\Str::replace('_', ' ', $data->priority)) }}
                                        @endif
                                    </a>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a href="{{ route('lead.change_priority', ['RolePrefix' => RolePrefix(), 'very_hot',$data->id]) }}" class="dropdown-item has-icon @if($data->priority == 'very_hot') d-none  @endif">Very Hot
                                        </a>
                                        <a href="{{ route('lead.change_priority', ['RolePrefix' => RolePrefix(), 'hot',$data->id])}}" class="dropdown-item has-icon @if($data->priority == 'hot') d-none @endif">Hot
                                        </a>
                                        <a href="{{ route('lead.change_priority', ['RolePrefix' => RolePrefix(), 'moderate',$data->id])}}" class="dropdown-item has-icon @if($data->priority == 'moderate') d-none @endif">Moderate
                                        </a>
                                        <a href="{{ route('lead.change_priority', ['RolePrefix' => RolePrefix(), 'cold',$data->id])}}" class="dropdown-item has-icon @if($data->priority == 'cold') d-none @endif">Cold
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


>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
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
<<<<<<< HEAD
=======
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
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
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
<<<<<<< HEAD
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
=======
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
            console.log(a);
            // $('input[name="country_filter"]').val(a);
            // $('#countryForm').submit();
        });

        $('select[name="project"]').on('change', function() {
            var b = $(this).val()
            $('input[name="project_name"]').val(b)
            $('#projectForm').submit()
        });


>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
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

<<<<<<< HEAD
        $("body").on("click", ".change_status", function() {
            var status = $(this).attr('data-value');
            var id = $(this).attr('data-id');
            $('#form_status').val(status);
            $('#form_id').val(id);
            $('#statusForm').attr('action', "");
            $('#statusModal').modal('show');
        });

=======
        //Change Status 
        $('.change_status').click(function() {
            alert();
        });
        $("body").on("click", ".change_stsatus", function() {
            alert();
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
            $('#statusForm').attr('action', "{{route('lead.change_status', ['RolePrefix' => RolePrefix()])}}");
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

>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
        $('#statusForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
<<<<<<< HEAD
                url: "",
=======
                url: "{{ route('lead.change_status', ['RolePrefix' => RolePrefix()]) }}",
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
                type: "POST",
                data: formData,
                success: function(data) {
                    if (data.status == 'success') {
                        $('#statusModal').modal('hide');
                        successMsg(data.message);
                        setTimeout(function() {
<<<<<<< HEAD
                            // window.location.href = "";
=======
                            window.location.href = "";
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
                        }, 1000);
                    }
                    if (data.status == 'error') {
                        errorMsg(data.message);
                    }
                },
            });
        });
    });
<<<<<<< HEAD
=======

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
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
</script>
@endsection