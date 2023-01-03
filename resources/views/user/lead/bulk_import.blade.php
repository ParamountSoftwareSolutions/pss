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
                                    <p> 4. After uploading leads you are able to edit them according to your desire.</p>
                                </div>
                                <div class="col-md-12">
                                    <form class="product-form" action="{{ route('lead.bulk_import',RolePrefix()) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card mt-2 rest-part">
                                            <div class="card-header d-flex justify-content-right align-items-center">
                                                <h4>Import Products File</h4>
                                                <a href="{{ asset('assets/lead.xlsx') }}" download class="btn btn-secondary"
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
@endsection
