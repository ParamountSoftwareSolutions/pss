@extends('user.layout.app')
@section('title', 'Clients')
@section('style')
    <style>
        .dropdown-item {
            cursor: pointer;
        }

        .badge {
            color: white !important;
        }
    </style>
@endsection
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Bulk Import Leads</h4>
                            </div>
                            <div class="card-body">
                                <div class="jumbotron" style="background: white">
                                    <h3>Instructions : </h3>
                                    <p> 1. Download the format file and fill it with proper data.</p>
                                    <p> 2. You can download the example file to understand how the data must be filled.</p>
                                    <p> 3. Once you have downloaded and filled the format file, upload it in the form below and submit.</p>
                                    <p> 4. After uploading products you need to edit them and set product's images and choices.</p>
                                    <p> 5. You can get category and sub-category id from their list, please input the right ids.</p>
                                </div>
                                <div class="col-md-12">
                                    <form class="product-form" action="{{ route('lead.bulk_import',RolePrefix()) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card mt-2 rest-part">
                                            <div class="card-header d-flex justify-content-right align-items-center">
                                                <h4>Import Products File</h4>
                                                <a href="{{ asset('public/panel/assets/lead.xlsx') }}" download class="btn btn-secondary"
                                                   style="margin-left: auto; display: block;">Download Format</a>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input type="file" name="leads_file">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12" style="padding-top: 20px">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- basic modal -->
    <form action="" method="POST" id="statusForm">
        @csrf
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="status" id="form_status">
                        <input type="hidden" name="id" id="form_id">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" required>
                                @error('date')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Comment</label>
                                <textarea class="form-control" name="comment" id="comment" cols="30" rows="10" required></textarea>
                                @error('comment')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-primary">Update</button>
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
            $('.sales_person').click(function () {
                $('input[name="sales_person"]').val($(this).attr('data-id'));
                submit();

            });
            $('.status').click(function () {
                $('input[name="status"]').val($(this).attr('data-value'));
                submit();

            });
            $('.filter_date').click(function () {
                $('input[name="filter_date"]').val($(this).attr('data-value'));
                submit();

            });

            function submit() {
                $('.filter_form').submit();
            }


            $('.change_status').on('click', function () {
                var status = $(this).attr('data-value');
                var id = $(this).attr('data-id');
                $('#form_status').val(status);
                $('#form_id').val(id);
                $('#statusForm').attr('action', "{{route('client.change_status',RolePrefix())}}");
                $('#statusModal').modal('show');

            });
        });
    </script>
@endsection

