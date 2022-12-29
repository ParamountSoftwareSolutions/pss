@extends('user.layout.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Privacy Policy</h4>
                                <a href="{{ route('privacy_policy.create',RolePrefix()) }}" class="btn btn-primary"
                                   style="margin-left: auto; display: block;">Add New</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Privacy Policy</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($privacyPolicy as $result)
                                            <tr>
                                                <td>{{$result->id}}</td>
                                                <td>{!! $result->description !!}</td>
                                                <td>
                                                    <a href="{{ route('privacy_policy.edit', ['RolePrefix'=>RolePrefix(),'privacy_policy'=>$result->id]) }}"
                                                       class="btn btn-primary  px-1 py-0"><i class="fa fa-edit"></i></a>
                                                    <button type="button" data-url="{{ route('privacy_policy.destroy',['RolePrefix' => RolePrefix(),'privacy_policy'=>$result->id]) }}" data-token="{{csrf_token()}}" title="Delete" class="btn btn-danger px-1 py-0 deleteBtn">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No more data in this table.</td>
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
