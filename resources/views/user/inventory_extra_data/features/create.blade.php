@extends('user.layout.app')
@section('title', 'Add Feature')
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
                            <form method="post" action="{{ route('feature.store', ['RolePrefix' => RolePrefix(),'key'=>$key]) }}">
                                @csrf
                                <div class="card-header">
                                    <h4>Add Feature</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        {{--<div class="form-group col-md-4">
                                            <label>Building Type</label>
                                            <select class="form-control" name="type_id">
                                                <option label="" disabled selected>Select Building Type</option>
                                                @foreach($project_type as $data)
                                                    <option value="{{ $data->id }}">{{ ucwords($data->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>--}}
                                        <div class="form-group col-md-4">
                                            <label>Name</label>
                                            <input type="text" class="form-control" required="" name="name">
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
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
