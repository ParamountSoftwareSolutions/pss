@extends('user.layout.app')
@section('title', 'Leads')
@section('style')

@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-right align-items-center">
                            <h4>Employees</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Client Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($persons)) { ?>
                                            <?php foreach ($persons as $key => $value) { ?>
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->email }}</td>
                                                    <td>{{ $value->phone_number  }}</td>
                                                    <td>
                                                        <div class="dropdown">

                                                            <form method="POST" id="form_id" action="{{route('lead.employee_report', ['RolePrefix' => RolePrefix()])}}">
                                                                @csrf
                                                                <input type="hidden" name="id" id="user_id_val">
																<input type="hidden" name="range" id="range">
                                                                <a href="#" value_id="{{$value->id}}" range="daily" class="badge badge-success report" aria-expanded="false">Daily Report</a>
                                                                <a href="#" value_id="{{$value->id}}" range="weekly" class="badge badge-success report" aria-expanded="false">Weekly Report</a>
                                                                <a href="#" value_id="{{$value->id}}" range="monthly" class="badge badge-success report" aria-expanded="false">Monthly Report</a>
                                                                <!-- <a href="{{ url('Property_manger/sale/lead/employee_report/'.$value->id) }}" class="badge badge-success" aria-expanded="false">Today Leads Report</a> -->
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php } ?>

                                        <?php } else { ?>
                                            <tr>
                                                <td colspan="7"> No More Data In this Table.</td>
                                            </tr>
                                        <?php } ?>
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
<script>
    $('.report').click(function() {
        $('#user_id_val').val($(this).attr('value_id'));
		$('#range').val($(this).attr('range'));
        $('#form_id').submit();

    });
</script>
@endsection