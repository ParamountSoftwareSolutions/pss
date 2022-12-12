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
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center table-striped" id="table-1">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Assign To</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($targets as $target)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$target->assign->username ?? ''}}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm px-1 py-0 report_modal" data-id="{{$target->assign_to}}" title="View">
                                                        <i class="fa fa-eye"></i>
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
    <div class="modal fade" id="reportModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Day End Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="call_id">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <h6>Name</h6>
                        </div>
                        <div class="col-md-7">
                            <h6 id="user_name" style="color: #6777ef"></h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Report Duration</h6>
                        </div>
                        <div class="col-md-6">
                            <h6 id="duration" style="color: #6777ef">12:00am - 11:59pm ({{ Carbon\Carbon::now()->format('F j, Y')}})</h6>
                        </div>
                    </div>
                    <div class="row px-3 mb-5">
                        <div class="col-md-6 px-1">
                            <div class="col-md-12 text-white py-2 bg-primary border rounded">
                                <h1 id="total_tasks"></h1>
                                <p style="font-size: 25px">Total Tasks of the Day</p>
                            </div>
                        </div>
                        <div class="col-md-6 px-1">
                            <div class="col-md-12 text-dark py-2 border rounded">
                                <h1 id="overdue"></h1>
                                <p style="font-size: 25px">Overdue Tasks</p>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center px-3 mb-5">
                        <div class="col-md-3 px-1">
                            <div class="col-md-12 text-dark pt-4 py-2 bg-light rounded" style="border-left: 10px solid #28a745;">
                                <h3 id="clients"></h3>
                                <p>Clients</p>
                            </div>
                        </div>
                        <div class="col-md-3 px-1">
                            <div class="col-md-12 text-dark pt-4 py-2 bg-light rounded" style="border-left: 10px solid #ffc107;">
                                <h3 id="leads"></h3>
                                <p>Leads</p>
                            </div>
                        </div>
                        <div class="col-md-3 px-1">
                            <div class="col-md-12 text-dark pt-4 py-2 bg-light rounded" style="border-left: 10px solid #007bff;">
                                <h3 id="meetings"></h3>
                                <p>Meetings</p>
                            </div>
                        </div>
                        <div class="col-md-3 px-1">
                            <div class="col-md-12 text-dark pt-4 py-2 bg-light rounded" style="border-left: 10px solid #dc3545;">
                                <h3 id="calls"></h3>
                                <p>Calls</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('body').on('click','.report_modal',function () {
                // showLoader();
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url(Helpers::user_login_route()['panel'].'/task/get-report') }}/" + id,
                    type: "GET",
                    success: function(data) {
                        let task = data.achieved+'/'+data.total_tasks;
                        let overdue = data.overdue;
                        let client = data.client+'/'+data.total_clients;
                        let lead = data.lead+'/'+data.total_leads;
                        let meeting = data.meeting+'/'+data.total_meetings;
                        let call = data.call+'/'+data.total_calls;
                        let name = data.name;
                        $('#total_tasks').text(task);
                        $('#overdue').text(overdue);
                        $('#clients').text(client);
                        $('#leads').text(lead);
                        $('#meetings').text(meeting);
                        $('#calls').text(call);
                        $('#user_name').text(name);
                        hideLoader();
                        $('#reportModal1').modal('show');
                        return;
                    },
                });
                return;
                // $('#reportModal1').modal('show');
            })
        })
    </script>
@endsection
