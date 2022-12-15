@extends('user.layout.app')
@section('title', 'Add Lead')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('target.update_task', ['RolePrefix' => RolePrefix(),'id'=> $target->id]) }}">
                            <div class="card">
                                @csrf
                                <div class="card-header">
                                    <h4>Target</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
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
                                                @error('type')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Target <small style="color: red">*</small></label>
                                                <input type="number" class="form-control" name="target" value="{{$target->target}}" reqiured>
                                                @error('target')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Date From <small style="color: red">*</small></label>
                                                <input type="date" class="form-control" name="from" value="{{old('from',$target->from)}}" reqiured>
                                                @error('from')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <label>Date To <small style="color: red">*</small></label>
                                                <input type="date" class="form-control" name="to" value="{{old('to',$target->to)}}" reqiured>
                                                @error('to')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
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
            var from = "{{$target->from}}";
            $('input[name="to"]').attr('min',from);
            $('input[name="from"]').on('change', function () {
                var date_from = $(this).val();
                $('input[name="to"]').attr('min',date_from);
            });
        });
    </script>
@endsection
