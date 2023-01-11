@extends('user.layout.app')
@section('title', 'Update Floor Detail')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row justify-content-end mr-3 mb-3">
                    <a href="{{route('dealer.generate_pdf',['RolePrefix' => RolePrefix(), 'dealer' => $dealer->id,'project'=>$project->id])}}" class="btn btn-success mr-3">Download PDF</a>
{{--                    <button class="btn btn-primary share" data-toggle="modal" data-target="#statusModal">Share</button>--}}
                </div>
                <div class="row justify-content-center print_area">
                    <h2 class="h2 col-12 col-md-12 col-lg-12">
                        <img src="{{ asset('public/panel/assets/img/logo.png') }}" alt="" width="200px" class="logo">
                    </h2>
                    <div class="col-md-4">
                        <h1 class="building">{{ucwords($project->name)}}</h1>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        @forelse($project_array as $key => $block)
                            @if(!$block->count())
                                @continue
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{$key}}</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table text-center table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Unit No</th>
                                            <th scope="col">Area</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Location</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($block as $data)
                                            @php
                                            if($data->premium_id && $data->premium->name == 'Corner'){
                                                $premium = 'Corner';
                                            }else{
                                                $premium = '';
                                            }
                                            @endphp
                                            <tr>
                                                <td>{{ $data->unit_id }}</td>
                                                <td>{{ $data->area }} square feet</td>
                                                <td>{{ ucfirst($data->type->name) ?? '' }}</td>
                                                <td>{{ $data->category->name }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>{{ $premium }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5"><h5>No Inventries Found</h5></td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="card"><h4>We Dont Have Any Records To This Project</h4></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade bd-example-modal-lg" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg mt-5" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Copy Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mx-1 align-items-center border">
                        <div class="col-lg-10 col-md-10 col-sm-10 py-1">
{{--                            {{route('building-inventries',['panel' => Helpers::user_login_route()['panel'], 'id' => $building->id])}}--}}
{{--                            <input type="hidden" name="copy_text" id="copy_text" value="{{route('building-inventries',['panel' => Helpers::user_login_route()['panel'], 'id' => $building->id])}}">--}}
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 py-1 text-center">
                            <button id="copy_btn" type="button" class="btn" data-clipboard-text="1">Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#copy_btn').click(function(){
                var copyText = document.getElementById("copy_text");
                copyText.select();
                navigator.clipboard.writeText(copyText.value);
            });
            $(".logo").hide();
        });
        // Tooltip
        $('#copy_btn').tooltip({
            trigger: 'click',
            placement: 'top'
        });
        function setTooltip(message) {
            $('#copy_btn').tooltip('hide')
                .attr('data-original-title', message)
                .tooltip('show');
        }
        function hideTooltip() {
            setTimeout(function() {
                $('#copy_btn').tooltip('hide');
            }, 1000);
        }
        var clipboard = new Clipboard('#copy_btn');
        clipboard.on('success', function(e) {
            setTooltip('Copied!');
            hideTooltip();
        });
        clipboard.on('error', function(e) {
            setTooltip('Failed!');
            hideTooltip();
        });
    </script>
@endsection
