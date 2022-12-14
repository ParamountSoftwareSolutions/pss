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
                                <h4>Project List</h4>
                                @if(count($projects) < \Illuminate\Support\Facades\Auth::user()->project)
                                    <a href="{{ route('project.create', ['RolePrefix' => RolePrefix()]) }}" class="btn btn-primary" style="margin-left: auto; display: block;">Add New</a>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th>Project Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($projects as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td><span class="badge
                                                @if($data->type->name == 'building')
                                                        badge-blue
                                                        @elseif($data->type->name == 'society')
                                                        badge-success
                                                        @elseif($data->type->name == 'farm_house')
                                                        badge-danger
                                                        @else
                                                        badge-primary
                                                        @endif
                                                        ">{{ ucwords($data->type->name) }} </span></td>
                                                <td>
                                                    <a href="{{ route('project.edit', ['RolePrefix' => RolePrefix(), 'project' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('project.show', ['RolePrefix' => RolePrefix(), 'project' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button type="button" data-url="{{ route('project.destroy',['RolePrefix' => RolePrefix(), 'project' => $data->id]) }}"
                                                            data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
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
@section('script')
@endsection
