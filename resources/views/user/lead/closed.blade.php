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
                <h4>Closed Leads</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Client Name</th>
                                <th>Client Email</th>
                                <th>Client Contact Number</th>
                                <th>Sales Person</th>
                                <th>Building</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($sales))
                            @foreach($sales as $key => $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->name ?? '' }}</td>
                                <td>{{ $data->email ?? '' }}</td>
                                <td>{{ $data->number ?? '' }}</td>
                                <td>{{ (!empty($data['sale_person']['name'])) ? $data['sale_person']['name'] : 'N/A'}}</td>
                                <td>{{ (!empty($data['building']['name'])) ? $data['building']['name'] : 'N/A'}}</td>
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
                    <div class="d-flex justify-content-center">
                        {!! $sales->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection