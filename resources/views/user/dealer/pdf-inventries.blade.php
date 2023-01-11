<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{  asset('assets/css/app.min.css') }}">
    <title>{{$project->name}}</title>
    <style>
        .building_heading{
            width: 100%;
            text-align: center;
            margin-bottom: 45px;
            margin-top: 30px;
        }
        .logo_img{
            padding-left: 30px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row print_area">
                    <div class="logo_img">
                        <img src="{{ asset('assets/img/logo-pdf1.jpg') }}" alt="" width="35%" class="logo">
                    </div>
                    <div class="building_heading">
                        <h1 class="building">{{$project->name}}</h1>
                    </div>
                    <div class="col-lg-12">
                        @forelse($project_array as $key => $block)
                            <div class="card">
                                <div class="card-header text-center">
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
</body>
</html>
