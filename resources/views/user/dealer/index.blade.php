@extends('user.layout.app')
@section('title', 'Payment Plan')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Dealers List</h4>
                                <a href="{{ route('dealer.create',['RolePrefix' => RolePrefix()]) }}" class="btn btn-primary"
                                   style="margin-left: auto; display: block;">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>CNIC</th>
                                            <th>Phone Number</th>
                                            <th>Project</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($dealers as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->cnic }}</td>
                                                <td>{{ $data->number }}</td>
                                                <td>{{ ucfirst($data->project->name) }}</td>
                                                <td>
                                                    <a href="{{ route('dealer.edit',['RolePrefix' => RolePrefix(),'dealer'=>$data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                       <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button type="button" data-url="{{ route('dealer.destroy',['RolePrefix' => RolePrefix(), 'dealer' => $data->id]) }}" data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <a href="{{ route('dealer.show',['RolePrefix' => RolePrefix(),'dealer'=>$data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="View">
                                                        <i class="fa fa-eye"></i>
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
@endsection
