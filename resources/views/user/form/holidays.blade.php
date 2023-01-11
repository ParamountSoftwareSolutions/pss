@extends('user.layout.app')
@section('content')
    <!-- Page Wrapper -->
    <div class="main-content">
        <!-- Page Content -->
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Holidays <span id="year"></span></h3>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <a href="#" class="btn add-btn btn-primary btn-primary" data-toggle="modal"
                                            data-target="#add_holiday"><i class="fa fa-plus"></i> Add Holiday</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                @php
                                    use Carbon\Carbon;
                                    $today_date = Carbon::today()->format('d-m-Y');
                                @endphp
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped custom-table datatable mb-5">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Title </th>
                                                        <th>Holiday Date</th>
                                                        <th>Day</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($holiday as $key => $items)
                                                        @if ($today_date > $items->date_holiday)
                                                            <tr class="holiday-completed">
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $items->name_holiday }}</td>
                                                                <td>{{ date('d F, Y', strtotime($items->date_holiday)) }}
                                                                </td>
                                                                <td>{{ date('l', strtotime($items->date_holiday)) }}</td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($holiday as $key => $items)
                                                        @if ($today_date <= $items->date_holiday)
                                                            <tr class="holiday-upcoming">
                                                                <td hidden class="id">{{ $items->id }}</td>
                                                                <td>{{ ++$key }}</td>
                                                                <td class="holidayName">{{ $items->name_holiday }}</td>
                                                                <td hidden class="holidayDate">{{ $items->date_holiday }}
                                                                </td>
                                                                <td>{{ date('d F, Y', strtotime($items->date_holiday)) }}
                                                                </td>
                                                                <td>{{ date('l', strtotime($items->date_holiday)) }}</td>
                                                                <td >
                                                                            <a class=" userUpdate"
                                                                                data-toggle="modal" data-id="'.$items->id.'"
                                                                                data-target="#edit_holiday"><i
                                                                                    class="fa btn btn-primary fa-pencil m-r-5"></i></a>
                                                                            <a class="" href="#"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_holiday"><i
                                                                                    class="fa btn btn-danger fa-trash m-r-5"></i>
                                                                                </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /Page Content -->
    <!-- Add Holiday Modal -->
    <div class="modal custom-modal fade" id="add_holiday" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employees.form/holidays/save', ['RolePrefix' => RolePrefix()]) }}"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Holiday Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="nameHoliday" name="nameHoliday">
                        </div>
                        <div class="form-group">
                            <label>Holiday Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" type="text" id="holidayDate"
                                    name="holidayDate">
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Holiday Modal -->

    <!-- Edit Holiday Modal -->
    <div class="modal custom-modal fade" id="edit_holiday" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employees.form/holidays/update', ['RolePrefix' => RolePrefix()]) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="id" id="e_id" value="">
                        <div class="form-group">
                            <label>Holiday Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="holidayName_edit" name="holidayName"
                                value="">
                        </div>
                        <div class="form-group">
                            <label>Holiday Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="text" class="form-control datetimepicker" id="holidayDate_edit"
                                    name="holidayDate" value="">
                            </div>
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Holiday Modal -->

    <!-- Delete Holiday Modal -->
    <div class="modal custom-modal fade" id="delete_holiday" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Holiday</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal"
                                    class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Holiday Modal -->

    </div>
    <!-- /Page Wrapper -->
@section('script')
    <script>
        document.getElementById("year").innerHTML = new Date().getFullYear();
    </script>
    {{-- update js --}}
    <script>
        $(document).on('click', '.userUpdate', function() {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            $('#holidayName_edit').val(_this.find('.holidayName').text());
            $('#holidayDate_edit').val(_this.find('.holidayDate').text());
        });
    </script>
@endsection

@endsection
