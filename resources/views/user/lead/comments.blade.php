@extends('user.layout.app')
@section('title', 'Leads')
@section('style')

@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="page-title-box">
            <h4 class="page-title">Lead Comments</h4>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Comments</h4>
                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Comment</th>
                            <!-- <th>CreatedAt</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($comments))
                        @foreach($comments as $key => $value)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value->status ?? '' }}</td>
                            <td>{{ $value->date ?? $value->created_at }}</td>
                            <td>{{ $value->comment ?? '' }}</td>
                            <!-- <td>{{ $value->created_at }}</td> -->
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