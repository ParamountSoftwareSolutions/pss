@extends('user.layout.app')
@section('title', 'All Building List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($buildings as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->project->name }}</td>
                                                <td>
                                                    <a href="{{ route('building.edit', ['RolePrefix' => RolePrefix(), 'building' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('building.show', ['RolePrefix' => RolePrefix(), 'building' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('building.destroy', ['RolePrefix' => RolePrefix(), 'building' => $data->id]) }}"
                                                        method="post" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-danger px-1 py-0">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
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
