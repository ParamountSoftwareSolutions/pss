@extends('user.layout.app')
@section('title', 'Add Building Detail')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="post" action="{{ route('building.update', ['RolePrefix' => RolePrefix(), 'building' => $building->id]) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h4>Edit Building</h4>
                                </div>
                                @if($building->floor_list == null)
                                    @include('user.building.new_form')
                                @else
                                    @include('user.building.edit_form')
                                @endif

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
