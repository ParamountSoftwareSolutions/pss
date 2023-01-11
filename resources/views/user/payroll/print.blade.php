@extends('user.layout.app')
@section('title', 'Edit Employee Pay')
@section('style')
    <link href="{{ asset('public/formprint/Styls/Main.css') }}" rel="stylesheet"/>
@endsection
@section('content')
<style>
	th{
		text-align: center
	}
</style>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
							<div class="card-header">
								<div class="col-12 col-md-12 col-lg-12">
								<div class="print-window btn btn-primary btn-lg pull-right" id="print">
									Print
								</div>
							</div>
							</div>
							<div class="card-body">
								<div class="example" id="example">
									<form>
										<div>
											<h5 class="d-flex text-dark">Employee Name: <p class="ml-3">{{ $employee->username }}</p></h5>
										</div>
										<div>
											<h5 class="d-flex text-dark">Location Side: <p class="ml-3">{{ $employee->building_employee->building->name }}</p></h5>
										</div>
										<div class="mb-4">
											<h5 class="d-flex text-dark">Designation: <p class="ml-3">{{ $employee->building_employee->designation }}</p></h5>
										</div>
										<div class="mb-4">
											<h5 class="d-flex text-dark">Working Days: <p class="ml-3">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->working_days }} @else Null @endif</p></h5>
										</div>
										  <table class="table table-striped" id="table-1">
										  	<thead>
										  		<tr>
													<th style="width:80%">Description</th>
													<th>Amount</th>
												</tr>
											</thead>
											<tbody>
												<tr>
											  		<td>Salary</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->amount }} @else {{ $employee->building_employee->salary }} @endif</td>
											  	</tr>
											</tbody>
											<tbody>
												<tr>
											  		<td>Commission</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->commission }} @else Null @endif</td>
											  	</tr>
											</tbody>
											<tbody>
												<tr>
											  		<td>Present Days </td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->present_days }} @else Null @endif</td>
											  	</tr>
											</tbody>
											  <tbody>
												<tr>
											  		<td>Absent Days</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->absent_days }} @else Null @endif</td>
											  	</tr>
											</tbody>
											  <tbody>
												<tr>
											  		<td>Payable Days</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->payable_days }} @else Null @endif</td>
											  	</tr>
											</tbody>
											  <tbody>
												<tr>
											  		<td>Leaves Approved By Adj</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->leaveByAdj }} @else Null @endif</td>
											  	</tr>
											</tbody>
											  <tbody>
												<tr>
											  		<td>Leaves Approved By Director</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->leaveByDirector }} @else Null @endif</td>
											  	</tr>
											</tbody>
											  <tbody>
												<tr>
											  		<td>Advance</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->advance }} @else Null @endif</td>
											  	</tr>
											</tbody>
											  <tbody>
												<tr>
											  		<td>Total Amount</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ round(((($employee->building_employee_payroll->amount / ($employee->building_employee_payroll->working_days != 0 ? $employee->building_employee_payroll->working_days : 1)) * $employee->building_employee_payroll->payable_days) - $employee->building_employee_payroll->advance) + $employee->building_employee_payroll->commission, 1) }} @else Null @endif</td>
											  	</tr>
											</tbody>
											  <tbody>
												<tr>
											  		<td>Payment Method</td>
													<td class="text-center">@if($employee->building_employee_payroll !== null) {{ $employee->building_employee_payroll->payment_mode }} @else Null @endif</td>
											  	</tr>
											</tbody>
										  </table>
									</form>
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
    {{--<script src="{{ asset('public/formprint/Scripts/jquery-1.9.1.min.js') }}"></script>--}}{{--
    <script src="{{ asset('public/panel/assets/js/app.min.js') }}"></script>
    --}}{{--<script src="{{ asset('public/formprint/Scripts/bootstrap.min.js') }}"></script>--}}
    <script src="{{ asset('public/panel/assets/js/jquery-printme.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("input").prop('disabled', true);
            $("select").prop('disabled', true);
            $("textarea").prop('disabled', true);
            $(".form-control[disabled]").css('background-color', '#fff');
            $(".input[type=checkbox]").css('background-color', '#ffffff');
            $(".example").css({
                "width": "100%",
                "margin-top": '0px'
            });
        })
        $(document).on('click', '#print', function () {

            $('#print').hide();
            $('.navbar').hide();
            $('.main-sidebar').hide();
            $('.main-footer').hide();
            $(".example").css({
                "width": "100%",
                "margin-top": '-100px'
            });
            window.print();
            $('#print').show();
            $('.navbar').show();
            $('.main-sidebar').show();
            $('.main-footer').show();
            $(".example").css({
                "width": "100%",
                "margin-top": '-7px'
            });
        });
    </script>
@endsection