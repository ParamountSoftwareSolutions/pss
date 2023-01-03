@extends('user.layout.app')
@section('title', 'Banner List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Banner List</h4>
                                <a href="{{ route('banner.create',RolePrefix()) }}" class="btn btn-primary"
                                   style="margin-left: auto; display: block;">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>image</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($banners as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="p-2"><img src="{{ asset($data->file) }}" alt="" width="150px" height="100px"></td>
                                                <td>
                                                    <a href="{{ route('banner.edit',['RolePrefix'=>RolePrefix(),'banner'=>$data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                       <i class="fa fa-edit"></i>

                                                    </a>
                                                    <button type="button" data-url="{{ route('banner.destroy',['RolePrefix' => RolePrefix(),'banner'=>$data->id]) }}" data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
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
@endsection

