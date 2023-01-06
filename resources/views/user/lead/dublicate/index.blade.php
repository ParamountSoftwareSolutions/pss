@extends('user.layout.app')
@section('title', 'Leads')
@section('style')

@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title-box">
            <h4 class="page-title">Leads</h4>
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
                <h4 class="header-title">Dublicate Leads Table ()</h4>
                <table id="basic-datatable1" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Client Name</th>
                            <th>Client Email</th>
                            <th>Client Contact Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($dublicates))
                        @foreach($dublicates as $key => $value)

                        <tr>
                            <td>{{$value->id}}</td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->email}}</td>
                            <td>{{$value->number}}</td>
                            <td>
                                <a href="{{route('webhook.dublicate_store', ['RolePrefix' => RolePrefix(),$value->lead_id])}}" class="btn btn-primary btn-sm px-1 py-0" title="Edit">
                                    <i class="fa fa-edit"></i>Update Recent Lead
                                </a>
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

@endsection
@section('script')


@endsection