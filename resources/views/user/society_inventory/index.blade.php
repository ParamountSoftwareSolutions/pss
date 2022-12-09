@extends('user.layout.app')
@section('title', 'Society Inventory List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>{{ $block->name }} Inventory</h4>
                                <a href="{{ route('society.block.society_inventory.create', ['RolePrefix' => RolePrefix(), 'society' => $society_id, 'block' =>
                                $block_id])}}" class="btn btn-primary"
                                   style="margin-left: auto; display: block;">Add New Inventory</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Project</th>
                                            <th>Block</th>
                                            <th>Unit</th>
                                            <th>Category</th>
                                            <th>Payment Plan</th>
                                            <th>Nature</th>
                                            <th>Size</th>
                                            <th>premium</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($society_inventory as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->project->name }}</td>
                                                <td>{{ $data->block->name }}</td>
                                                <td>{{ $data->unit_id }}</td>
                                                <td>{{ $data->category->name }}</td>
                                                <td>{{ $data->payment_plan->name }}</td>
                                                <td>{{ $data->nature->name }}</td>
                                                <td>{{ $data->size->name }} {{ $data->size->unit }}</td>
                                                <td>{{ $data->premium->name }}</td>
                                                <td><span class="badge badge-success">{{ $data->status }}</span></td>
                                                <td>
                                                    <a href="{{ route('society.block.society_inventory.edit', ['RolePrefix' => RolePrefix(), 'society' =>
                                                    $data->society_id, 'block' =>
                                                    $data->block_id, $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('society.block.society_inventory.destroy', ['RolePrefix' => RolePrefix(), 'society' => $data->society_id, 'block' =>
                                                    $data->block_id, $data->id]) }}"
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
