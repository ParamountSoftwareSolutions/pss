@extends((new App\Helpers\Helpers)->user_login_route()['file'].'.layout.app')
@section('title', 'Add Lead')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('property.update_task', ['panel' => Helpers::user_login_route()['panel'],'id'=> $target->id]) }}">
                            <div class="card">
                                @csrf
                                <div class="card-header">
                                    <h4>Target</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Type <small style="color: red">*</small></label>
                                                <select class="form-control" name="type" reqiured>
                                                    <option value=""> -- Select Type --</option>
                                                    <option value="client" {{$target->type == 'client' ? 'selected' : ''}}>Client Register</option>
                                                    <option value="lead" {{$target->type == 'lead' ? 'selected' : ''}}>Leads</option>
                                                    <option value="call" {{$target->type == 'call' ? 'selected' : ''}}>Calls</option>
                                                    <option value="meeting" {{$target->type == 'meeting' ? 'selected' : ''}}>Meetings</option>
                                                    <option value="conversion" {{$target->type == 'conversion' ? 'selected' : ''}}>Conversion</option>
                                                </select>
                                                @error('building_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Target <small style="color: red">*</small></label>
                                                <input type="number" class="form-control" name="target" value="{{$target->target}}" reqiured>
                                                @error('building_id')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Date Range Picker</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="date" class="form-control daterange-cus" value="{{$target->from.' - '.$target->to}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <input class="btn btn-primary" type="submit" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.daterange-cus').daterangepicker({
                locale: { format: 'YYYY-MM-DD' },
                drops: 'down',
                opens: 'right'
            });
        });
    </script>
@endsection
