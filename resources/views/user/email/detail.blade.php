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
                            <h4>Email Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <label style="color: #262424">To: </label> <span style="color: #0a53be"> {{$email->to}}</span>
                                    <h2 class="mb-5 mt-3" style="color: #262424">{{$email->subject}}</h2>
                                    <p>{{$email->body}}</p>
                                    @php
                                        if(str_contains($email->images,',')){
                                            $images = explode(',',$email->images);
                                        }else{
                                            $images = [$email->images];
                                        }
                                    @endphp
                                    @forelse($images as $img)
                                        <img style="width: 100%" src="{{asset($img)}}" alt="">
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-6 px-0 d-flex justify-content-between">
                                    <button type=button" class="btn btn-success resend" title="Resend">Resend</button>
                                    <button type="button" class="btn btn-primary forward" title="{{$email->status == 'sent'? 'Forward' : 'Send'}}">{{$email->status == 'sent'? 'Forward' : 'Send'}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- forward email modal -->
<form action="{{ route('email.forward',['RolePrefix'=>RolePrefix(),'id'=>$email->id]) }}" method="post" id="callConnectForm">
    @csrf
    <div class="modal fade" id="callConnectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Farword To</h5>
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
<form id="resendForm" action="{{ route('email.resend',['RolePrefix'=>RolePrefix(),'id'=>$email->id]) }}" method="post">
    @csrf
</form>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.forward').click(function () {;
                $('.email').hide();
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
            $('.resend').click(function () {
                $('#resendForm').submit();
            });
        });
    </script>
@endsection
