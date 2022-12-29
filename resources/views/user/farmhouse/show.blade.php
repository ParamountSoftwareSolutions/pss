@extends('user.layout.app')
@section('title', 'All Project List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Inventory History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>CNIC</th>
                                            <th>Phone Number</th>
                                            <th>Comment</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($inventory_histories as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($data->status) }}</td>
                                                <td>{{ $data->amount }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->cnic }}</td>
                                                <td>{{ $data->phone_number }}</td>
                                                <td>{{ $data->comment }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('M d, Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7"> No More Data In this Table.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
@endsection
