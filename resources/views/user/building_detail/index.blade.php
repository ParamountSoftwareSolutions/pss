@extends('user.layout.app')
@section('title', 'All Building List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Building</h4>
                            </div>
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
                                        @forelse($project as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>
                                                    @if(\App\Models\BuildingDetail::where('project_id', $data->id)->first() == null)
                                                        <a href="{{ route('project.extra_detail.create',['RolePrefix' => RolePrefix(),'project' => $data->id]) }}"
                                                           class="btn btn-primary px-1 py-0" title="Create And Update Details">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('project.extra_detail.edit', ['RolePrefix' => RolePrefix(), 'extra_detail' => $data->building_detail->id,'project' => $data->id]) }}"
                                                           class="btn btn-primary px-1 py-0" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
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
