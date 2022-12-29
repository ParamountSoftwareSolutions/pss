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
                                <h4>{{$project->name}} Inventory List</h4>
                                <a href="{{ route('farmhouse.inventory.create', ['RolePrefix' => RolePrefix(),'farmhouse'=>$project->id]) }}" class="btn btn-primary"
                                   style="margin-left: auto; display: block;">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Unit No</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($farmhouses as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->unit_no }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="javascript:void(0)" data-toggle="dropdown" class="badge @if($data->status == 'sold')
                                                            badge-danger @elseif($data->status == 'hold')
                                                            badge-warning @elseif($data->status == 'available')
                                                            badge-success @elseif($data->status == 'canceled')
                                                            badge-light @else
                                                            badge-secondary @endif
                                                            " aria-expanded="false">
                                                            @if($data->status == null)
                                                                Not Selected
                                                            @else
                                                                {{ ucfirst(Illuminate\Support\Str::replace('_', ' ', $data->status)) }}
                                                            @endif
                                                        </a>
                                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 26px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <a class="dropdown-item has-icon change_status @if($data->status == 'available') d-none  @endif" data-value="available" data-id="{{$data->id}}">Available</a>
                                                            <a class="dropdown-item has-icon change_status @if($data->status == 'hold') d-none @endif" data-value="hold" data-id="{{$data->id}}">Hold</a>
                                                            <a class="dropdown-item has-icon change_status @if($data->status == 'sold') d-none @endif" data-value="sold" data-id="{{$data->id}}">Sold</a>
                                                            <a class="dropdown-item has-icon change_status @if($data->status == 'canceled') d-none @endif" data-value="canceled" data-id="{{$data->id}}">Canceled</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('farmhouse.inventory.edit', ['RolePrefix' => RolePrefix(),'farmhouse'=>$project->id ,'inventory' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button type="button" data-url="{{ route('farmhouse.inventory.destroy',['RolePrefix' => RolePrefix(),'inventory'=>$project->id,'farmhouse' => $data->id]) }}" data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <a href="{{ route('farmhouse.inventory.show', ['RolePrefix' => RolePrefix(),'farmhouse'=>$project->id ,'inventory' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-comments"></i>
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
    <form id="statusForm">
        @csrf
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="form_id">
                        <input type="hidden" name="status" id="form_status">
                        <div class="row form_hold">
                            <div class="form-group col-md-6 name">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control">
                                @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 email">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control">
                                @error('email')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 cnic">
                                <label>CNIC</label>
                                <input type="number" name="cnic" class="form-control">
                                @error('cnic')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 phone_number">
                                <label>Phone Number</label>
                                <input type="number" name="phone_number" class="form-control">
                                @error('phone_number')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 amount">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control">
                                @error('amount')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Comment</label>
                                <textarea class="form-control" name="comment" id="comment" cols="30" rows="5" required></textarea>
                                @error('comment')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <input type="submit" class="btn btn-primary" value="submit" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $("body").on("click", ".change_status", function() {
                $('.form_hold').hide();
                var status = $(this).attr('data-value');
                if (status == 'hold' || status == 'sold') {
                    $('input[name="name"]').attr('required');
                    $('input[name="email"]').attr('required');
                    $('input[name="cnic"]').attr('required');
                    $('input[name="phone_number"]').attr('required');
                    $('input[name="amount"]').attr('required');
                    $('.form_hold').show();
                } else {
                    $('input[name="name"]').removeAttr('required');
                    $('input[name="email"]').removeAttr('required');
                    $('input[name="cnic"]').removeAttr('required');
                    $('input[name="phone_number"]').removeAttr('required');
                    $('input[name="amount"]').removeAttr('required');
                    $('.form_hold').hide();
                }
                var id = $(this).attr('data-id');
                $('#form_status').val(status);
                $('#form_id').val(id);
                $('#statusForm').attr('action', "{{route('inventory.change_status', ['RolePrefix' => RolePrefix(),'project_id'=>3])}}");
                $('#statusModal').modal('show');
            });
            $('#statusForm').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                     url: "{{route('inventory.change_status', ['RolePrefix' => RolePrefix(),'project_id'=>3])}}",
                     type: "POST",
                     data: formData,
                     success: function(data) {
                         if (data.status == 'success') {
                             $('#statusModal').modal('hide');
                             successMsg(data.message);
                             setTimeout(function() {
                                 location.reload();
                             }, 1000);
                         }
                         if (data.status == 'error') {
                             errorMsg(data.message);
                         }
                     },
                 });
            })
        })
    </script>
@endsection
