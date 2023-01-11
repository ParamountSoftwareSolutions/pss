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
                            <!-- Page Header -->
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Leaves <span id="year"></span></h3>
                                    </div>
                                    <div class="col-auto float-right ml-auto">
                                        <a href="#" class="btn add-btn btn-primary" data-toggle="modal"
                                            data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Leave Statistics -->
                            <div class="card-body">
                            
                            

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>Employee</th>
                                                    <th>Leave Type</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>No of Days</th>
                                                    <th>Reason</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if (!empty($leaves))
                                                    @foreach ($leaves as $items)
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    {{ $items->name }}
                                                                </h2>
                                                            </td>
                                                            <td hidden class="id">{{ $items->id }}</td>
                                                            <td class="leave_type">{{ $items->leave_type }}</td>
                                                            <td hidden class="from_date">{{ $items->from_date }}</td>
                                                            <td>{{ date('d F, Y', strtotime($items->from_date)) }}</td>
                                                            <td hidden class="to_date">{{ $items->to_date }}</td>
                                                            <td>{{ date('d F, Y', strtotime($items->to_date)) }}</td>
                                                            <td class="day">{{ $items->day }} Day</td>
                                                            <td class="leave_reason">{{ $items->leave_reason }}</td>
                                                            <td class="text-center">
                                                                <div class="dropdown action-label">
                                                                    <a class="btn btn-white btn-sm btn-rounded dropdown-toggle"
                                                                        href="#" data-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <i class="fa fa-dot-circle-o text-purple"></i> New
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="fa fa-dot-circle-o text-purple"></i>
                                                                            New</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="fa fa-dot-circle-o text-info"></i>
                                                                            Pending</a>
                                                                        <a class="dropdown-item" href="#"
                                                                            data-toggle="modal"
                                                                            data-target="#approve_leave"><i
                                                                                class="fa fa-dot-circle-o text-success"></i>
                                                                            Approved</a>
                                                                        <a class="dropdown-item" href="#"><i
                                                                                class="fa fa-dot-circle-o text-danger"></i>
                                                                            Declined</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                        <a class=" leaveUpdate"
                                                                            data-toggle="modal" data-id="'.$items->id.'"
                                                                            data-target="#edit_leave"><i
                                                                                class="fa btn btn-primary fa-pencil m-r-5"></i> </a>
                                                                        <a class=" leaveDelete"
                                                                            href="#" data-toggle="modal"
                                                                            data-target="#delete_approve"><i
                                                                                class="fa btn btn-danger fa-trash m-r-5"></i> </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Page Content -->

                        <!-- Add Leave Modal -->
                        <div id="add_leave" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Leave</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="{{ route('employees.form/leaves/save', ['RolePrefix' => RolePrefix()]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Leave Type <span class="text-danger">*</span></label>
                                                <select class="select form-control" id="leaveType" name="leave_type">
                                                    <option selected disabled>Select Leave Type</option>
                                                    <option value="Casual Leave 12 Days">Casual Leave 12 Days</option>
                                                    <option value="Medical Leave">Medical Leave</option>
                                                    <option value="Loss of Pay">Loss of Pay</option>
                                                </select>
                                            </div>
                                            <input type="hidden" class="form-control" id="user_id" name="user_id"
                                                value="{{ Auth::user()->id }}">
                                            <div class="form-group">
                                                <label>From <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                    <input type="date" class="form-control datetimepicker"
                                                        id="from_date" name="from_date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>To <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                    <input type="date" class="form-control datetimepicker"
                                                        id="to_date" name="to_date">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Leave Reason <span class="text-danger">*</span></label>
                                                <textarea rows="4" class="form-control" id="leave_reason" name="leave_reason"></textarea>
                                            </div>
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Add Leave Modal -->

                        <!-- Edit Leave Modal -->
                        <div id="edit_leave" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Leave</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="{{ route('employees.form/leaves/edit', ['RolePrefix' => RolePrefix()]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" id="e_id" name="id" value="">
                                            <div class="form-group">
                                                <label>Leave Type <span class="text-danger">*</span></label>
                                                <select class="select form-control" id="e_leave_type" name="leave_type">
                                                    <option selected disabled>Select Leave Type</option>
                                                    <option value="Casual Leave 12 Days">Casual Leave 12 Days</option>
                                                    <option value="Medical Leave">Medical Leave</option>
                                                    <option value="Loss of Pay">Loss of Pay</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>From <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control datetimepicker"
                                                        id="e_from_date" name="from_date" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>To <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control datetimepicker"
                                                        id="e_to_date" name="to_date" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Number of days <span class="text-danger">*</span></label>
                                                <input class="form-control" readonly type="text" id="e_number_of_days"
                                                    name="number_of_days" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Leave Reason <span class="text-danger">*</span></label>
                                                <textarea rows="4" class="form-control" id="e_leave_reason" name="leave_reason" value=""></textarea>
                                            </div>
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-primary submit-btn">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Edit Leave Modal -->

                        <!-- Approve Leave Modal -->
                        <div class="modal custom-modal fade" id="approve_leave" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-header">
                                            <h3>Leave Approve</h3>
                                            <p>Are you sure want to approve for this leave?</p>
                                        </div>
                                        <div class="modal-btn delete-action">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-primary continue-btn">Approve</a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="javascript:void(0);" data-dismiss="modal"
                                                        class="btn btn-primary cancel-btn">Decline</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Approve Leave Modal -->

                        <!-- Delete Leave Modal -->
                        <div class="modal custom-modal fade" id="delete_approve" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-header">
                                            <h3>Delete Leave</h3>
                                            <p>Are you sure want to delete this leave?</p>
                                        </div>
                                        <div class="modal-btn delete-action">
                                            <form
                                                action="{{ route('employees.form/leaves/edit/delete', ['RolePrefix' => RolePrefix()]) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="id" class="e_id" value="">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="submit"
                                                            class="btn btn-primary continue-btn submit-btn">Delete</button>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="javascript:void(0);" data-dismiss="modal"
                                                            class="btn btn-primary cancel-btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- /Delete Leave Modal -->
                    </div>
                </div>
            </div>
        </section>
    </div>
                    <!-- /Page Wrapper -->
                @section('script')
                    <script>
                        document.getElementById("year").innerHTML = new Date().getFullYear();
                    </script>
                    {{-- update js --}}
                    <script>
                        $(document).on('click', '.leaveUpdate', function() {
                            var _this = $(this).parents('tr');
                            $('#e_id').val(_this.find('.id').text());
                            $('#e_number_of_days').val(_this.find('.day').text());
                            $('#e_from_date').val(_this.find('.from_date').text());
                            $('#e_to_date').val(_this.find('.to_date').text());
                            $('#e_leave_reason').val(_this.find('.leave_reason').text());

                            var leave_type = (_this.find(".leave_type").text());
                            var _option = '<option selected value="' + leave_type + '">' + _this.find('.leave_type').text() +
                                '</option>'
                            $(_option).appendTo("#e_leave_type");
                        });
                    </script>
                    {{-- delete model --}}
                    <script>
                        $(document).on('click', '.leaveDelete', function() {
                            var _this = $(this).parents('tr');
                            $('.e_id').val(_this.find('.id').text());
                        });
                    </script>
                @endsection
            @endsection
