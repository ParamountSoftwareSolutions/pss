@extends('user.layout.app')
@section('title', 'Edit Category')
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
                            <form method="post" action="{{ route('category.update', ['RolePrefix' => RolePrefix(), 'category' => $category->id]) }}">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h4>Edit Category</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Project Type</label>
                                            <select class="form-control" name="type_id">
                                                <option label="" disabled>Select Project Type</option>
                                                @foreach($project_type as $data)
                                                    <option value="{{ $data->id }}" @if($category->project_type_id == $data->id) selected @endif>{{ ucwords($data->name)
                                                    }}</option>
                                                @endforeach
                                            </select>
                                            @error('type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Category Name</label>
                                            <input type="text" class="form-control" required="" name="name" value="{{ $category->name }}">
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
