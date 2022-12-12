@extends('user.layout.app')
@section('title', 'Floor List')
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
                                        @forelse(json_decode($building->floor_list) as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @php( $id = (int) $data)
                                                @php( $floor = \App\Models\BuildingFloor::findOrFail($id))
                                                <td>{{ $floor->name }}</td>
                                                <td>
                                                    <a href="{{ route('building.floor.building_inventory.index', ['RolePrefix' => RolePrefix(), 'building' =>
                                                    $building->id,
                                                    'floor' => (int) $data])
                                                     }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-edit"></i>
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
