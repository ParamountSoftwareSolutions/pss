@extends('user.layout.app')
@section('title', 'Leads | Comments')
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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-right align-items-center">
                <h4>Refer Leads</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Number</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($refers))
                            @foreach($refers as $key => $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data['to_user']['name']}}</td>
                                <td>{{ $data['to_user']['email']}}</td>
                                <td>{{ $data['to_user']['phone_number']}}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->created_at }}</td>
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
        <div class="card">
            <div class="card-header d-flex justify-content-right align-items-center">
                <h4>Request Refer Leads</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Number</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($requested))
                            @foreach($requested as $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value['from_user']['name']}}</td>
                                <td>{{ $value['from_user']['email']}}</td>
                                <td>{{ $value['from_user']['phone_number']}}</td>
                                <td>{{ $value->status }}</td>
                                <td>{{ $value->created_at }}</td>
                                <td>
                                    @if($value->status == "pending")
                                    <a href="{{route('lead.accept', ['RolePrefix'=>RolePrefix(), $value->id])}}" class="btn btn-success">Accept</a>
                                    <a href="{{route('lead.reject', ['RolePrefix'=>RolePrefix(), $value->id])}}" class="btn btn-danger">Reject</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7"> No More Data In this Table. </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection