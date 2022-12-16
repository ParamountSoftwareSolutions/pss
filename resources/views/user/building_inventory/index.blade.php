@extends('user.layout.app')
@section('title', 'All Users List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>{{ $building_floor->name }} Shop/Apartment List</h4>
                                <a href="{{ route('building.floor.building_inventory.create', ['RolePrefix' => RolePrefix(), 'building' => $building_id, 'floor' =>
                                $building_floor->id])}}" class="btn btn-primary"
                                   style="margin-left: auto; display: block;">Add New Shop/Apartment</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Project Name</th>
                                            <th>Unit No</th>
                                            <th>Area</th>
                                            <th>Nature</th>
                                            <th>category</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($building_inventory as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->project->name }}</td>
                                                <td>{{ $data->unit_id }}</td>
                                                <td>{{ $data->area }} square feet</td>
                                                <td>{{ $data->type->name }}</td>
                                                <td>{{ $data->category->name }}</td>
                                                <td>@if($data->status == 'sold')
                                                        <div class="badge badge-success badge-shadow">Sold</div>
                                                    @elseif($data->status == 'available')
                                                        <div class="badge badge-primary badge-shadow">Available</div>
                                                    @elseif($data->status == 'reserved')
                                                        <div class="badge badge-warning badge-shadow">Reserved</div>
                                                    @elseif($data->status == 'hold')
                                                        <div class="badge badge-info badge-shadow">hold</div>
                                                    @else
                                                        <div class="badge badge-danger badge-shadow">Cancel</div>
                                                    @endif
                                                </td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('building.floor.building_inventory.edit', ['RolePrefix' => RolePrefix(), 'building' => $building_id,
                                                    'floor' => $floor_id, 'building_inventory' => $data->id]) }}"
                                                       class="btn btn-primary px-1 py-0" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    {{--<a href="{{ route('floor_detail.edit', ['building_id' => $building_id, 'floor_id' => $floor_id, 'id' => $data->id]) }}"
                                                       class="btn btn-primary" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round" class="feather feather-eye">
                                                            <path
                                                                d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                            <circle cx="12" cy="12" r="3"></circle>
                                                        </svg>
                                                    </a>--}}
                                                    <button type="button" data-url="{{ route('building.floor.building_inventory.destroy', ['RolePrefix' => RolePrefix(), 'building' =>
                                                        $building_id, 'floor' => $floor_id, 'building_inventory' => $data->id]) }}" data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
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
