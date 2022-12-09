@extends('user.layout.app')
@section('title', 'Block List')
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
                                        @forelse(json_decode($society_block->block) as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ block((int) $data) }}</td>
                                                <td>
                                                    <a href="{{ route('society.block.society_inventory.index', ['RolePrefix' => RolePrefix(), 'society' =>
                                                    $society_block->id, 'block' => (int) $data]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
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
