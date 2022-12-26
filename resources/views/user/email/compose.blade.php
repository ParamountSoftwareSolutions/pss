@extends('user.layout.app')
@section('title', 'All Building List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="boxs mail_listing">
                                <div class="inbox-center table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th colspan="1">
                                                <div class="inbox-header">
                                                    Compose New Message
                                                </div>
                                            </th>
                                            <th colspan="1">
                                                <div class="inbox-header text-right">
                                                    <button class="btn btn-primary all_lead" data-value="single">SinglePerson</button>
                                                    <button class="btn btn-primary all_lead" data-value="leads">All Leads</button>
                                                    <button class="btn btn-primary all_lead" data-value="clients">All Clients</button>
                                                    <button class="btn btn-primary all_lead" data-value="both">Both Leads and Clients</button>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row form_area">
                                    <div class="col-lg-12">
                                        <form class="composeForm" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label>FROM</label>
                                                    <input type="text" disabled style="cursor: not-allowed" class="form-control" placeholder="FROM" value="{{Auth::user()->email}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label>TO</label>
                                                    <input type="text" class="form-control to" placeholder="TO">
                                                    <input type="hidden" name="email" class="email">
                                                </div>
                                                @error('email')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input type="text" name="subject" class="form-control" placeholder="Subject">
                                            </div>
                                            @error('subject')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group">
                                                <label>Body</label>
                                                <textarea class="form-control" name="body" id="body"></textarea>
                                            </div>
                                            @error('body')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                            <div class="card">
                                                <div class="card-header ui-sortable-handle">
                                                    <h4>Select Images</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <div>
                                                            <div class="row" id="coba"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="m-l-25 m-r-25 m-b-20 d-flex justify-content-between">
                                            <button type="button" data-url="{{ route('email.compose.save',RolePrefix()) }}" id="save_email" class="btn btn-success btn-border-radius waves-effect">Save</button>
                                            <button type="button" data-url="{{ route('email.compose.send',RolePrefix()) }}" id="send_email" class="btn btn-info btn-border-radius waves-effect">Send</button>
{{--                                            <button type="button" class="btn btn-danger btn-border-radius waves-effect">Discard</button>--}}
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
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/spartan-multi-image-picker.js') }}"></script>
    <script>
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 4,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '2048',
                placeholderImage: {
                    image: '{{asset("assets/img/img2.jpg")}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#body'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '55px';
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        $(document).ready(function () {
            $('.form_area').hide();
            $('.all_lead').click(function () {
                let option = $(this).attr('data-value');
                let input = $('.to');
                let inputHidden = $('.email');
                if(option == 'single'){
                    input.removeAttr('disabled');
                    input.attr('name','email');
                    input.css({
                        "cursor": "auto",
                    });
                    input.val('');
                    inputHidden.removeAttr('name');
                }else if(option == 'leads'){
                    input.val('Leads');
                    input.attr('disabled',true);
                    input.css({
                        "cursor": "not-allowed",
                    });
                    input.removeAttr('name');
                    inputHidden.attr('name','email');
                    inputHidden.val('leads');
                }else if(option == 'clients'){
                    input.val('Clients');
                    input.attr('disabled',true);
                    input.css({
                        "cursor": "not-allowed",
                    });
                    input.removeAttr('name');
                    inputHidden.attr('name','email');
                    inputHidden.val('clients');
                }else if(option == 'both'){
                    input.val('Both Leads and Clients');
                    input.attr('disabled',true);
                    input.css({
                        "cursor": "not-allowed",
                    });
                    input.removeAttr('name');
                    inputHidden.attr('name','email');
                    inputHidden.val('both');
                }
                $('.form_area').show();
            });
            $('#send_email').click(function (e) {
                let url = $(this).data('url');
                $('.composeForm').attr('action',url);
                $('.composeForm').submit();
            });
            $('#save_email').click(function (e) {
                let url = $(this).data('url');
                $('.composeForm').attr('action',url);
                $('.composeForm').submit();
            });
        })
    </script>
@endsection
