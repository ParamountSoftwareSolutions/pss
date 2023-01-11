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
                                <div class="row align-lists-center">
                                    <div class="col">
                                        <h3 class="page-title">Employee</h3>
                                    </div>
                                    <div class="col-auto d-flex float-right ml-auto">
                                        <div class="view-icons">
                                            <a href="{{ route('employees.all/employee/card', ['RolePrefix' => RolePrefix()]) }}"
                                                class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                                            <a href="{{ route('employees.all/employee/list', ['RolePrefix' => RolePrefix()]) }}"
                                                class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                                        </div>
                                        <a href="#" class="btn add-btn btn-primary" data-toggle="modal"
                                            data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Page Header -->
                            <div class="card-body">
                                <!-- Search Filter -->
                                <form action="{{ route('employees.all/employee/search', ['RolePrefix' => RolePrefix()]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="row filter-row">
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating" name="employee_id">
                                                <label class="focus-label">Employee ID</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating" name="name">
                                                <label class="focus-label">Employee Name</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating" name="position">
                                                <label class="focus-label">Position</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <button type="sumit" class="btn btn-success btn-block"> Search </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- Search Filter -->
                                {{-- message --}}

                                <div class="row staff-grid-row">
                                    @foreach ($users as $lists)
                                        <div class="card">
                                            <div class="dropdown profile-action">
                                                <a href="#" class="action-icon dropdown-togglet" data-toggle="dropdown"
                                                    aria-expanded="false"><i class="material-icons">{{ $lists->name }}</i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                        href="{{ route('employees.all/employee/view/edit', ['RolePrefix' => RolePrefix(), $lists->id]) }}"><i
                                                            class="fa fa-pencil m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('employees.all/employee/delete', ['RolePrefix' => RolePrefix(), $lists->id]) }}"onclick="return confirm('Are you sure to want to delete it?')"><i
                                                            class="fa fa-trash m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /Page Content -->

                            <!-- Add Employee Modal -->
                            <div id="add_employee" class="modal custom-modal fade" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Employee</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('employees.all/employee/save', ['RolePrefix' => RolePrefix()]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Full Name</label>
                                                            <select class="form-control select select2s-hidden-accessible"
                                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                id="name" name="name">
                                                                <option value="">-- Select --</option>
                                                                @foreach ($userList as $key => $user)
                                                                    <option value="{{ $user->name }}"
                                                                        data-employee_id={{ $user->id }}
                                                                        data-email={{ $user->email }}>{{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Email <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" type="email" id="email"
                                                                name="email" placeholder="Auto email" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Working Days <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" id="text"
                                                                name="working_days">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Birth Date</label>
                                                            <div class="cal-icon">
                                                                <input class="form-control datetimepicker" type="date"
                                                                    id="birthDate" name="birthDate">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Gender</label>
                                                            <select class="select form-control" style="width: 100%;"
                                                                tabindex="-1" aria-hidden="true" id="gender"
                                                                name="gender">
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Employee ID <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="employee_id"
                                                                name="employee_id" placeholder="Auto id employee"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Company</label>
                                                            <select class="form-control select select2s-hidden-accessible"
                                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                id="company" name="company">
                                                                <option value="">-- Select --</option>
                                                                @foreach ($userList as $key => $user)
                                                                    <option value="{{ $user->name }}">
                                                                        {{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="table-responsive m-t-15">
                                                    <table class="table table-striped custom-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Module Permission</th>
                                                                <th class="text-center">Read</th>
                                                                <th class="text-center">Write</th>
                                                                <th class="text-center">Create</th>
                                                                <th class="text-center">Delete</th>
                                                                <th class="text-center">Import</th>
                                                                <th class="text-center">Export</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $key = 0;
                                                            $key1 = 0;
                                                            ?>
                                                            @foreach ($permission_lists as $lists)
                                                                <tr>
                                                                    <td>{{ $lists->permission_name }}</td>
                                                                    <input type="hidden" name="permission[]"
                                                                        value="{{ $lists->permission_name }}">
                                                                    <input type="hidden" name="id_count[]"
                                                                        value="{{ $lists->id }}">
                                                                    <td class="text-center">
                                                                        <input type="checkbox"
                                                                            class="read{{ ++$key }}"
                                                                            id="read" name="read[]"
                                                                            value="Y"{{ $lists->read == 'Y' ? 'checked' : '' }}>
                                                                        <input type="checkbox"
                                                                            class="read{{ ++$key1 }}"
                                                                            id="read" name="read[]" value="N"
                                                                            {{ $lists->read == 'N' ? 'checked' : '' }}>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox"
                                                                            class="write{{ ++$key }}"
                                                                            id="write" name="write[]" value="Y"
                                                                            {{ $lists->write == 'Y' ? 'checked' : '' }}>
                                                                        <input type="checkbox"
                                                                            class="write{{ ++$key1 }}"
                                                                            id="write" name="write[]" value="N"
                                                                            {{ $lists->write == 'N' ? 'checked' : '' }}>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox"
                                                                            class="create{{ ++$key }}"
                                                                            id="create" name="create[]" value="Y"
                                                                            {{ $lists->create == 'Y' ? 'checked' : '' }}>
                                                                        <input type="checkbox"
                                                                            class="create{{ ++$key1 }}"
                                                                            id="create" name="create[]" value="N"
                                                                            {{ $lists->create == 'N' ? 'checked' : '' }}>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox"
                                                                            class="delete{{ ++$key }}"
                                                                            id="delete" name="delete[]" value="Y"
                                                                            {{ $lists->delete == 'Y' ? 'checked' : '' }}>
                                                                        <input type="checkbox"
                                                                            class="delete{{ ++$key1 }}"
                                                                            id="delete" name="delete[]" value="N"
                                                                            {{ $lists->delete == 'N' ? 'checked' : '' }}>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox"
                                                                            class="import{{ ++$key }}"
                                                                            id="import" name="import[]" value="Y"
                                                                            {{ $lists->import == 'Y' ? 'checked' : '' }}>
                                                                        <input type="checkbox"
                                                                            class="import{{ ++$key1 }}"
                                                                            id="import" name="import[]" value="N"
                                                                            {{ $lists->import == 'N' ? 'checked' : '' }}>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox"
                                                                            class="export{{ ++$key }}"
                                                                            id="export" name="export[]" value="Y"
                                                                            {{ $lists->export == 'Y' ? 'checked' : '' }}>
                                                                        <input type="checkbox"
                                                                            class="export{{ ++$key1 }}"
                                                                            id="export" name="export[]" value="N"
                                                                            {{ $lists->export == 'N' ? 'checked' : '' }}>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div> --}}
                                                <div class="submit-section">
                                                    <button class="btn btn-primary submit-btn">Submit</button>
                                                </div>
                                            </form>
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
    <!-- /Add Employee Modal -->

    </div>
    <!-- /Page Wrapper -->
@section('script')
    <script>
        $("input:checkbox").on('click', function() {
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[class='" + $box.attr("class") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2s-hidden-accessible').select2({
                closeOnSelect: false
            });
        });
    </script>
    <script>
        // select auto id and email
        $('#name').on('change', function() {
            $('#employee_id').val($(this).find(':selected').data('employee_id'));
            $('#email').val($(this).find(':selected').data('email'));
        });
    </script>
    {{-- update js --}}
    <script>
        $(document).on('click', '.userUpdate', function() {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            $('#e_name').val(_this.find('.name').text());
            $('#e_email').val(_this.find('.email').text());
            $('#e_phone_number').val(_this.find('.phone_number').text());
            $('#e_image').val(_this.find('.image').text());

            var name_role = (_this.find(".role_name").text());
            var _option = '<option selected value="' + name_role + '">' + _this.find('.role_name').text() +
                '</option>'
            $(_option).appendTo("#e_role_name");

            var position = (_this.find(".position").text());
            var _option = '<option selected value="' + position + '">' + _this.find('.position').text() +
                '</option>'
            $(_option).appendTo("#e_position");

            var department = (_this.find(".department").text());
            var _option = '<option selected value="' + department + '">' + _this.find('.department').text() +
                '</option>'
            $(_option).appendTo("#e_department");

            var statuss = (_this.find(".statuss").text());
            var _option = '<option selected value="' + statuss + '">' + _this.find('.statuss').text() + '</option>'
            $(_option).appendTo("#e_status");

        });
    </script>
@endsection

@endsection
