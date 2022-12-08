@extends('user.layout.app')
@section('title', 'All Society List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Society List</h4>
                                {{--                                <a href="{{ route('farmhouse.create', ['RolePrefix' => RolePrefix()]) }}" class="btn btn-primary"--}}
                                {{--                                   style="margin-left: auto; display: block;">Add New</a>--}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="text-center table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            {{--                                            <th>Type</th>--}}
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($projects as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>
                                                    {{--                                                    <a href="{{ route('farmhouse.edit', ['RolePrefix' => RolePrefix(), 'farmhouse' => $data->id]) }}"--}}
                                                    {{--                                                       class="btn btn-primary px-1 py-0" title="Edit">--}}
                                                    {{--                                                        <i class="fa fa-edit"></i>--}}
                                                    {{--                                                    </a>--}}
                                                    <a href="{{ route('society.inventory.index', ['RolePrefix' => RolePrefix(), 'society' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="View PDF">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    {{--                                                    <button type="button" data-url="{{ route('farmhouse.destroy',['RolePrefix' => RolePrefix(), 'farmhouse' => $data->id]) }}" data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">--}}
                                                    {{--                                                        <i class="fa fa-trash"></i>--}}
                                                    {{--                                                    </button>--}}
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
