@extends('user.layout.app')
@section('title', 'Category List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Category List</h4>
                                 <a href="{{ route('category.create', ['RolePrefix' => RolePrefix()]) }}" class="btn btn-primary" style="margin-left: auto; display:
                                 block;">Add New</a>
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
                                        @forelse($categories as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td> <span class="badge
                                                @if($data->project_type->name == 'building')
                                                    badge-blue
                                                @elseif($data->project_type->name == 'society')
                                                    badge-success
                                                @elseif($data->project_type->name == 'farm_house')
                                                    badge-danger
                                                @else
                                                    badge-primary
                                                @endif
                                                ">{{ ucwords($data->project_type->name) }} </span></td>
                                                <td>
                                                    <a href="{{ route('category.edit', ['RolePrefix' => RolePrefix(), 'category' => $data->id]) }}"
                                                        class="btn btn-primary px-1 py-0" title="Edit">
                                                         <i class="fa fa-edit"></i>
                                                     </a>
                                                     <button type="button" data-url="{{ route('category.destroy',['RolePrefix' => RolePrefix(), 'category' => $data->id]) }}" data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
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
