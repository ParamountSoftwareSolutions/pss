@extends('user.layout.app')
@section('title', 'Add Size')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" action="{{ route('size.store', ['RolePrefix' => RolePrefix()]) }}">
                                @csrf
                                <div class="card-header">
                                    <h4>Add Size</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Project Type</label>
                                            <select class="form-control" name="type_id">
                                                <option label="" disabled selected>Select Project Type</option>
                                                @foreach($project_type as $data)
                                                    <option value="{{ $data->id }}">{{ ucwords($data->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Size Name</label>
                                            <input type="text" class="form-control" required="" name="name">
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{--<div class="form-group col-md-4">
                                            <label>Unit</label>
                                            <select class="form-control" name="unit" required>
                                                <option label="" disabled selected>Select Unit</option>
                                                <option value="bed">Bed</option>
                                                <option value="bath">Bath</option>
                                                <option value="marla">Marla</option>
                                                <option value="kenal">Kenal</option>
                                            </select>
                                            @error('unit')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>--}}
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
