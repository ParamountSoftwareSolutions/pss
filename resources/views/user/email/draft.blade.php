@extends((new App\Helpers\Helpers)->user_login_route()['file'].'.layout.app')
@section('title', 'Expense List')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>Drafts</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>To</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($email_histories as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('email.view',['RolePrefix'=>RolePrefix(),'id'=>$data->id]) }}">{{ $data->to }}</a></td>
                                        <td>{{ $data->subject }}</td>
                                        <td>{{ $data->date }}</td>
                                        <td>
                                            <button data-url="{{ route('email.forward',['RolePrefix'=>RolePrefix(),'id'=>$data->id]) }}"
                                               class="btn btn-primary px-1 py-0 forward" title="Send">
                                                <i class="fa-sharp fa-solid fa-share"></i>
                                            </button>
                                            <button type="button" data-url="{{ route('email.destroy',['RolePrefix'=>RolePrefix(),'id'=>$data->id]) }}" data-token="{{ csrf_token() }}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
                                                <i class="fa fa-trash"></i>
                                            </button>
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

<!-- forward email modal -->
<form method="post" id="callConnectForm">
    @csrf
    <div class="modal fade" id="callConnectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Send To</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="call_id">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>To</label>
                            <select type="text" name="to" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="leads">Leads</option>
                                <option value="clients">Clients</option>
                                <option value="both">Both Leads and Clients</option>
                                <option value="individual">Individual</option>
                            </select>
                            @error('to')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 email">
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-control" required>
                            @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
        	$("body").on("click", ".forward", function() {
                var url = $(this).data('url');
                $('.email').hide();
                $('#callConnectForm').attr('action',url);
                $('#callConnectModal').modal('show');
            });
            $('select[name="to"]').on('change', function () {
                var to = $(this).val();
                if(to == 'individual'){
                    $('#email').val('');
                    $('.email').show();
                }else{
                    $('.email').hide();
                    $('#email').val(to);
                }
            });
        });
    </script>
@endsection
