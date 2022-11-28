@extends('user.layout.app')
@section('title', 'Leads')
@section('style')
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-right align-items-center">
                            <h4>Leads Reports</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client Name</th>
                                            <th>Client Email</th>
                                            <th>Client Contact Number</th>
                                            <th>Sales Person</th>
                                            <th>Project</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>UpdatedAt Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($sales))
                            @foreach($sales as $key => $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->name ?? '' }}</td>
                                <td>{{ $data->email ?? '' }}</td>
                                <td>{{ $data->number ?? '' }}</td>
                                <td>{{ (!empty($data['sale_person']['name'])) ? $data['sale_person']['name'] : 'N/A'}}</td>
                                <td>{{ (!empty($data['building']['name'])) ? $data['building']['name'] : 'N/A'}}</td>
                                <td>{{ $data->status }}</td>
                                <td>{{ $data->priority }}</td>
                                <td>{{ $data->updated_at }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7"> No More Data In this Table.</td>
                            </tr>
                            @endif
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
<!-- basic modal -->
<form id="statusForm">
    @csrf
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="status" id="form_status">
                    <input type="hidden" name="id" id="form_id">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Date</label>
                            <input type="datetime-local" name="date" class="form-control" required>
                            @error('date')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label>Comment</label>
                            <textarea class="form-control" name="comment" id="comment" cols="30" rows="10" required></textarea>
                            @error('comment')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')

@endsection