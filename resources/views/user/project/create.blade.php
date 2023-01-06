@extends('user.layout.app')
@section('title', 'Add New Project')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post" action="{{ route('project.store', ['RolePrefix' => RolePrefix()]) }}" enctype="multipart/form-data">
                            <div class="card">
                                @csrf
                                <div class="card-header">
                                    <h4>Add Project</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Project Type</label>
                                            <select class="form-control" name="project_type_id">
                                                <option value="">Select Project Type</option>
                                                @foreach($project_type as $data)
                                                    <option value="{{ $data->id }}">{{ ucwords($data->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 all">
                                            <label>Project Name</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                            @error('name')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 all">
                                            <label>Address</label>
                                            <input type="text" class="form-control" name="address"
                                                   value="{{ old('address') }}">
                                            @error('address')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 all">
                                            <label>Total Area</label>
                                            <input type="text" class="form-control" name="total_area"
                                                   value="{{ old('total_area') }}">
                                            @error('total_area')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 all">
                                            <label>Developer</label>
                                            <input type="text" class="form-control" name="developer">
                                            @error('developer')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 scociety">
                                            <label>NOC Types</label>
                                            <select class="form-control" name="noc_type_id">
                                                <option value="">Select Society Types</option>
                                                @foreach($noc as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('noc_type_id')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 building">
                                            <label>Building Floor</label>
                                            <select class="form-control select2" multiple="" name="floor_list[]">
                                                <option value="">Select All Building Floors</option>
                                                @foreach($floor as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('floor_list')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 building">
                                            <label>Apartment Size</label>
                                            <select class="form-control select2" multiple="" name="apartment_size[]">
                                                <option value="">Select Bed</option>
                                                <option value="1">1 Bed</option>
                                                <option value="2">2 Bed</option>
                                                <option value="3">3 Bed</option>
                                                <option value="4">4 Bed</option>
                                                <option value="5">5 Bed</option>
                                                <option value="6">6 Bed</option>
                                                <option value="7">7 Bed</option>
                                            </select>
                                            @error('apartment_size')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 building">
                                            <label>Building Types</label>
                                            <select class="form-control select2" multiple="" name="type[]">
                                                <option value="">Select Building Types</option>
                                                @foreach($building_category as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 scociety">
                                            <label>Society Types</label>
                                            <select class="form-control select2" multiple="" name="type[]">
                                                <option value="">Select Society Types</option>
                                                @foreach($society_category as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 formhuse">
                                            <label>Formhouse Types</label>
                                            <select class="form-control select2" multiple="" name="type[]">
                                                <option value="">Select Farmhouse Types</option>
                                                @foreach($formhouse_category as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 scociety">
                                            <label>Block</label>
                                            <select class="form-control select2" multiple="" name="block[]">
                                                <option value="">Select Society Block
                                                </option>
                                                @foreach($society_block as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('block')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 formhuse">
                                            <label>Block</label>
                                            <select class="form-control select2" multiple="" name="block[]">
                                                <option value="">Select Block
                                                </option>
                                                @foreach($formhouse_block as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('block')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 scociety">
                                            <label>Sizes</label>
                                            <select class="form-control select2" multiple="" name="block[]">
                                                <option value="">Select Sizes
                                                </option>
                                                @foreach($society_size as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('block')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card all">
                                <div class="card-header">
                                    <h4>Extra Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4 all">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="text" class="form-control" name="price"
                                                       placeholder="PKR 1Lak to 10Lak"
                                                       value="{{ old('price') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 all">
                                            <div class="form-group">
                                                <label>Latitude</label>
                                                <input type="text" class="form-control" name="latitude"
                                                       placeholder=""
                                                       value="{{ old('latitude') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 all">
                                            <div class="form-group">
                                                <label>Longitude</label>
                                                <input type="text" class="form-control" name="longitude"
                                                       placeholder=""
                                                       value="{{ old('longitude') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Plot Features</div>
                                            @forelse($plot_features as $data)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="plot_feature[]"
                                                           id="{{$data->id}}" value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Business And Communication Features</div>
                                            @forelse($communication_features as $data)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="communication_feature[]"
                                                           id="{{$data->id}}" value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Community Features</div>
                                            @forelse($community_features as $data)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="community_feature[]"
                                                           id="{{$data->id}}" value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">HealthCare Features</div>
                                            @forelse($health_features as $data)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="health_feature[]"
                                                           id="{{$data->id}}" value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">NearBy Location And Other Facilities</div>
                                            @forelse($other_features as $data)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="other_feature[]"
                                                           id="{{$data->id}}" value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Second Form --}}
                            <div class="card all">
                                <div class="card-header">
                                    <h4>Property Types</h4>
                                </div>
                                <div class="card-body detail_append">

                                </div>
                            </div>
                            <!-- Multi Image Upload -->
                            <div class="card card-primary all">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Main Logo Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div class="row" id="coba-logo"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary all">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Payment Plan Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary all">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Floor Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div id="coba-floor" class="row coba-floor"></div>
                                        </div>
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
        </section>
    </div>
@endsection
@section('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor1'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '200px';
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 4,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset("assets/img/img2.jpg")}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#coba-logo").spartanMultiImagePicker({
                fieldName: 'logo_images[]',
                maxCount: 4,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset("assets/img/img2.jpg")}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>

    {{--Floor Plan Image--}}
    <script type="text/javascript">
        $(function () {
            $("#coba-floor").spartanMultiImagePicker({
                fieldName: 'floor_images[]',
                maxCount: 4,
                rowHeight: '215px',
                groupClassName: 'col-3',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset("assets/img/img2.jpg")}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            hideAll();
            $('select[name="project_type_id"]').change(function () {
                var project_type_id = $(this).val();
                if(project_type_id){
                    if(project_type_id == 1){
                        showBuilding()
                    }else if(project_type_id == 2){
                        showSociety()
                    }else if(project_type_id == 3){
                        showFarmhouse()
                    }else{hideAll();}
                }else{hideAll();}
            })
            $('select[name="apartment_size[]"]').change(function () {
                $('.detail_append').empty();
                var arr = $(this).val();
                var all_detail = '';
                var shop_detail = '<div class="section-title mt-0">Shop Details:</div>' +
                    '          <div class="row">' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Floor</div>' +
                    '                  <input type="text" class="form-control" name="floor"' +
                    '                         placeholder="1st floor to top floor">' +
                    '              </div>' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Area</div>' +
                    '                  <input type="text" class="form-control" name="floor_area" placeholder="">' +
                    '              </div>' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Price</div>' +
                    '                  <input type="text" class="form-control" name="floor_price"' +
                    '                         placeholder="PKR 1lak to PKR 20LAK">' +
                    '              </div>' +
                    '          </div>';
                arr.forEach(function(val) {
                    var building = 'detail['+val+'][building]';
                    var area = 'detail['+val+'][area]';
                    var bed = 'detail['+val+'][bed]';
                    var bath = 'detail['+val+'][bath]';
                    var price = 'detail['+val+'][price]';
                    var detail='<div class="section-title mt-0">'+val+' BED Flat Details:</div>' +
                    '          <div class="row">' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Building</div>' +
                    '                  <input type="text" class="form-control" name="'+building+'"' +
                    '                         placeholder="Building 9th to 20th">' +
                    '              </div>' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Area</div>' +
                    '                  <input type="text" class="form-control" name="'+area+'" placeholder="">' +
                    '              </div>' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Bed</div>' +
                    '                  <div class="custom-control custom-checkbox">' +
                    '                      <input type="checkbox" class="custom-control-input" checked disabled' +
                    '                           name="'+bed+'" id="'+bed+'">' +
                    '                      <label class="custom-control-label" for="'+bed+'">'+val+' Bed</label>' +
                    '                  </div>' +
                    '              </div>' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Bath</div>' +
                    '                  <input type="number" class="form-control" name="'+bath+'">' +
                    '              </div>' +
                    '              <div class="form-group col-md-4">' +
                    '                  <div class="section-title mt-0">Price</div>' +
                    '                  <input type="text" class="form-control" name="'+price+'"' +
                    '                         placeholder="PKR 1lak to 20lak">' +
                    '              </div>' +
                    '          </div>';
                    all_detail = all_detail+detail;
                });


                $('.detail_append').empty();
                $('.detail_append').append(shop_detail+all_detail);
            })
        })
        function hideAll(){
            $('.all').hide();
            $('.building').hide();
            $('.scociety').hide();
            $('.formhuse').hide();
        }
        function showBuilding(){
            $('.scociety').hide();
            $('.formhuse').hide();
            $('.all').show();
            $('.building').show();
        }
        function showSociety(){
            $('.building').hide();
            $('.formhuse').hide();
            $('.all').show();
            $('.scociety').show();
        }
        function showFarmhouse(){
            $('.building').hide();
            $('.scociety').hide();
            $('.all').show();
            $('.formhuse').show();
        }
    </script>
@endsection
