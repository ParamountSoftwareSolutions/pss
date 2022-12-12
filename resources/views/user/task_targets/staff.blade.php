@extends((new App\Helpers\Helpers)->user_login_route()['file'].'.layout.app')
@section('title', 'All Users List')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Targets</h4>
                                <a href="{{ route('property.assign_target', ['panel' => Helpers::user_login_route()['panel']]) }}" class="btn btn-info">Assign Target</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Target Type</th>
                                            <th>Target</th>
                                            <th>Achieved</th>
                                            <th>Target Achieved %</th>
                                            <th>Assign To</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($targets as $target)
                                            @php
                                                switch($target->type){
                                                    case 'lead': $type = 'Leads';break;
                                                    case 'client': $type = 'Client Register';break;
                                                    case 'call': $type = 'Calls';break;
                                                    case 'meeting': $type = 'Meetings';break;
                                                    case 'conversion': $type = 'Conversion';break;
                                                    default: $type = '';
                                                }
                                                $percentage = round(($target->achieved / $target->target) * 100,2);
                                            @endphp
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$type}}</td>
                                                <td>{{$target->target}}</td>
                                                <td>{{$target->achieved}}</td>
                                                <td>{{$percentage}} %</td>
                                                <td>{{$target->assign->username ?? ''}}</td>
                                                <td>
                                                    <a href="{{ route('property.edit_task',['panel' => Helpers::user_login_route()['panel'], 'id' => $target->id]) }}" class="btn btn-primary btn-sm px-1 py-0" title="Edit">
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
@section('script')
@endsection
