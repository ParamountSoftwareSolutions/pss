@extends('user.layout.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Employee Pay List</h4>
								<a href="{{ route('payroll.importPayroll', ['RolePrefix' => RolePrefix()]) }}" class="btn btn-primary" style="margin-left: auto; display: block;">Import Bulk</a>
                                <a href="{{ route('payroll.exportPayroll', ['RolePrefix' => RolePrefix()]) }}" class="btn btn-primary" style="margin-left:10px; display: block;">Export Bulk</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th>Salary Amount</th>
											<th>Working Days</th>
											<th>No.of Day Present</th>
											<th>No.of Day Absent</th>
											<th>Total Leaves</th>
											<th>Leaves Approved</th>
											<th>Advance</th>
                                            <th>Total</th>
                                            <th>Payment Method</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($payroll as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->amount }} </td>
												<td>{{ $data->working_days }}</td>
												<td>{{ $data->present_days }}</td>
												<td>{{ $data->absent_days }}</td>
												<td>{{ $data->total_leaves }}</td>
												<td>{{ $data->leaves_approved }}</td>
												<td>{{ $data->advance }}</td>
                                                <td></td>
                                                <td>{{ $data->payment_method }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('payroll.editPayroll', ['RolePrefix' => RolePrefix(), $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0 m-1">
                                                       <i class="fa fa-edit"></i>
                                                    </a>
													<a href="{{ route('payroll.viewPayroll', ['RolePrefix' => RolePrefix(), $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0 m-1">
                                                       <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
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
