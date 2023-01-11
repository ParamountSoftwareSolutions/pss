@extends('user.layout.app')
@section('title', 'Employee List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Employee Pay Roll History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th>Salary Amount</th>
											<th>Commission/ Allowance</th>
											<th>Working Days</th>
											<th>No.of Day Present</th>
											<th>No.of Day Absent</th>
											<th>Payable Day</th>
											<th>Leave App by Adj</th>
											<th>Leave App by Director</th>
											<th>Advance</th>
											<th>Total Payable</th>
                                            <th>Payment Method</th>
                                            <th>Comments</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($employee as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->amount }} </td>
												
												<td>{{ $data->commission }}</td>
												<td>{{ $data->working_days }}</td>
												<td>{{ $data->present_days }}</td>
												<td>{{ $data->absent_days }}</td>
												<td>{{ $data->payable_days }}</td>
												<td>{{ $data->leaveByAdj }}</td>
												<td>{{ $data->leaveByDirector }}</td>
												<td>{{ $data->advance }}</td>
												<td>{{ round(((($data->amount / ($data->working_days != 0 ? $data->working_days : 1)) * $data->payable_days) - $data->advance) + $data->commission, 1) }}</td>
												
												
                                                <td>{{ $data->payment_mode }}</td>
                                                <td>{{ substr($data->comments, 0, 15) }}</td>
                                                <td>{{ Carbon\Carbon::parse( $data->date)->format('d F Y') }}</td>
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
