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
                                                <option value=""disabled >Select Project Type</option>
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
                                                <option value=""disabled >Select Society Types</option>
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
                                                <option value=""disabled >Select All Building Floors</option>
                                                @foreach($floor as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('floor_list')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 building">
                                            <label>Building Types</label>
                                            <select class="form-control select2" multiple="" name="building_type[]">
                                                <option value=""disabled >Select Building Types</option>
                                                @foreach($building_category as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 bed_select_box">
                                            <label class="apertment">Apartment Size</label>
                                            <label class="flats">Flat Size</label>
                                            <select class="form-control select2" multiple="" name="apartment_size[]">
                                                <option value=""disabled >Select Bed</option>
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
                                        <div class="form-group col-md-4 scociety">
                                            <label>Block</label>
                                            <select class="form-control select2" multiple="" name="society_block[]">
                                                <option value=""disabled>Select Block
                                                </option>
                                                @foreach($society_block as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('block')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 scociety">
                                            <label>Society Types</label>
                                            <select class="form-control select2" multiple="" name="society_type[]">
                                                <option value=""disabled>Select Society Types</option>
                                                @foreach($society_category as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4 formhuse">
                                            <label>Farmhouse Block</label>
                                            <select class="form-control select2" multiple="" name="farmhouse_block[]">
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
                                        <div class="form-group col-md-4 formhuse">
                                            <label>Formhouse Types</label>
                                            <select class="form-control select2" multiple="" name="farmhouse_type[]">
                                                <option value=""disabled >Select Farmhouse Types</option>
                                                @foreach($formhouse_category as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('type')
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
                                        <div class="form-group col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" id="editor1" cols="30"
                                                          rows="10">{!! old('description') !!}</textarea>
                                                @error('description')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body shop_detail_append"></div>
                                <div class="card-body detail_append"></div>
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
                            <div class="card card-primary building">
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
                    $('.shop_detail_append').empty();
                    $('.detail_append').empty();
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
                arr.forEach(function(val) {
                    var building = 'detail['+val+'][building]';
                    var area = 'detail['+val+'][area]';
                    var bed = 'detail['+val+'][bed]';
                    var bath = 'detail['+val+'][bath]';
                    var price = 'detail['+val+'][price]';
                    var detail='<div class="section-title mt-0"><h6>'+val+' BED Flat Details:</h6></div>' +
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
                $('.detail_append').append(all_detail);
            })
            $('select[name="building_type[]"]').change(function () {
                $('.shop_detail_append').empty();
                var selectBox = $('select[name="building_type[]"]');
                var values = $(this).val();
                var labels = getSelectText(selectBox,values);
                if(labels.includes('Apartment') && labels.includes('Flats')){
                    errorMsg('You just can choose either Apartment or Flats');
                    $('select[name="building_type[]"] option:selected').prop("selected", false);
                    $('.bed_select_box').hide();
                    return;
                }else if(labels.includes('Apartment') || labels.includes('Flats')){
                    $('.bed_select_box').show();
                    if(labels.includes('Apartment')){
                        $('.apertment').show();
                        $('.flats').hide();
                    }else if(labels.includes('Flats')){
                        $('.apertment').hide();
                        $('.flats').show();
                    }
                }else{
                    $('.bed_select_box').hide();
                }
                var newArr = ['Apartment','Flats'];
                newArr.forEach(function (val) {
                    labels = labels.filter(function(item) {
                        return item !== val;
                    })
                })
                var shop_details = '';
                labels.forEach(function (shop) {
                    var name = shop.toLowerCase().replace(' ','_');
                    var floor_name = 'shop_detail['+name+'][floor]';
                    var floor_area = 'shop_detail['+name+'][floor_area]';
                    var floor_price = 'shop_detail['+name+'][floor_price]';
                    var single = '<div class="section-title mt-0"><h6>'+shop+' Details:</h6></div>' +
                        '          <div class="row">' +
                        '              <div class="form-group col-md-4">' +
                        '                  <div class="section-title mt-0">'+shop+'</div>' +
                        '                  <input type="text" class="form-control" name="'+floor_name+'"' +
                        '                         placeholder="1st floor to top floor">' +
                        '              </div>' +
                        '              <div class="form-group col-md-4">' +
                        '                  <div class="section-title mt-0">Area</div>' +
                        '                  <input type="text" class="form-control" name="'+floor_area+'">' +
                        '              </div>' +
                        '              <div class="form-group col-md-4">' +
                        '                  <div class="section-title mt-0">Price</div>' +
                        '                  <input type="text" class="form-control" name="'+floor_price+'"' +
                        '                         placeholder="PKR 1lak to PKR 20LAK">' +
                        '              </div>' +
                        '          </div>';
                    shop_details = shop_details+single;
                });
                $('.shop_detail_append').append(shop_details);
            })
            $('select[name="farmhouse_type[]"]').change(function () {
                $('.shop_detail_append').empty();
                $('.detail_append').empty();
                var selectBox = $('select[name="farmhouse_type[]"]');
                var values = $(this).val();
                var labels = getSelectText(selectBox,values);
                var shop_details = '';
                labels.forEach(function (shop) {
                    var name = shop.toLowerCase().replace(' ','_');
                    var area = 'farmhouse['+name+'][area]';
                    var price = 'farmhouse['+name+'][price]';
                    var single = '<div class="section-title mt-0"><h5>'+shop+' Details:</h5></div>' +
                        '          <div class="row">' +
                        '              <div class="form-group col-md-4">' +
                        '                  <div class="section-title mt-0">Area</div>' +
                        '                  <input type="text" class="form-control" name="'+area+'"' +
                        '                         placeholder="">' +
                        '              </div>'+
                        '              <div class="form-group col-md-4">' +
                        '                  <div class="section-title mt-0">Price</div>' +
                        '                  <input type="text" class="form-control" name="'+price+'"' +
                        '                         placeholder="PKR 1lak to PKR 20LAK">' +
                        '              </div>' +
                        '          </div>';
                    shop_details = shop_details+single;
                });
                $('.shop_detail_append').append(shop_details);
            })
            $('select[name="society_type[]"]').change(function () {
                $('.shop_detail_append').empty();
                var selectBox = $('select[name="society_type[]"]');
                var values = $(this).val();
                var labels = getSelectText(selectBox,values);
                var shop_details = '';
                labels.forEach(function (shop) {
                    var name = shop.toLowerCase().replace(' ','_');
                    var price = 'society['+name+'][price]';
                    var size = 'society['+name+'][sizes][0][size]';
                    var size_price = 'society['+name+'][sizes][0][price]';
                    var single = '<div class="section-title mt-0"><h5>'+shop+' Details:</h5></div>' +
                        '          <div class="row">' +
                        '              <div class="form-group col-md-4">' +
                        '                  <div class="section-title mt-0">Price</div>' +
                        '                  <input type="text" class="form-control" name="'+price+'"' +
                        '                         placeholder="PKR 1lak to PKR 20LAK">' +
                        '              </div>' +
                        '          </div>' +
                        '          <div class="ml-2 add_size">' +
                        '              <div class="row">' +
                        '                  <div class="form-group col-md-4">' +
                        '                      <div class="section-title mt-0">Size</div>' +
                        '                      <input type="text" class="form-control" name="'+size+'"' +
                        '                         placeholder="3 Marla / 5 Marla">' +
                        '                      </div>' +
                        '                  <div class="form-group col-md-4">' +
                        '                      <div class="section-title mt-0">Price</div>' +
                        '                      <input type="text" class="form-control" name="'+size_price+'">' +
                        '                  </div>' +
                        '              </div>' +
                        '              <input type="hidden" value="0" name="'+name+'_add_new">' +
                        '              <button type="button" data-val="'+name+'" class="mb-2 btn btn-light add_new '+name+'_add_new">+</button>' +
                        '              <button type="button" data-val="'+name+'" class="mb-2 btn btn-light remove">-</button>' +
                        '          </div>';
                    shop_details = shop_details+single;
                });
                $('.shop_detail_append').append(shop_details);
            })
            $('body').on('click','.add_new',function () {
                var name = $(this).data('val');
                var i = Number($('input[name="'+name+'_add_new"]').val());
                i = i+1;
                var size = 'society['+name+'][sizes]['+i+'][size]';
                var size_price = 'society['+name+'][sizes]['+i+'][price]';
                var add_new = '' +
                    '<div class="row">' +
                    '   <div class="form-group col-md-4">' +
                    '       <div class="section-title mt-0">Size</div>' +
                    '       <input type="text" class="form-control" name="'+size+'"' +
                    '           placeholder="3 Marla / 5 Marla">' +
                    '   </div>' +
                    '   <div class="form-group col-md-4">' +
                    '       <div class="section-title mt-0">Price</div>' +
                    '       <input type="text" class="form-control" name="'+size_price+'">' +
                    '       </div>' +
                    '   </div>';

                $('input[name="'+name+'_add_new"]').val(i);
                $('.'+name+'_add_new').before(add_new);
            })
            $('body').on('click','.remove',function () {
                var name = $(this).data('val');
                var i = Number($('input[name="'+name+'_add_new"]').val());
                i = i-1;
                $('input[name="'+name+'_add_new"]').val(i);
                $('.'+name+'_add_new').prev().remove();
            })
        })
        function hideAll(){
            $('.all').hide();
            $('.building').hide();
            $('.scociety').hide();
            $('.formhuse').hide();
            $('.bed_select_box').hide();
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
            $('.bed_select_box').hide();
            $('.all').show();
            $('.scociety').show();
        }
        function showFarmhouse(){
            $('.building').hide();
            $('.scociety').hide();
            $('.bed_select_box').hide();
            $('.all').show();
            $('.formhuse').show();
        }
        function getSelectText(selectBox,values) {
            var labels = [];
            for (var i = 0; i < values.length; i++) {
                var label = selectBox.find('option[value="'+values[i]+'"]').text();
                labels.push(label);
            }
            return labels;
        }
        function isCommon(arr1, arr2) {
            return arr1.some(item => arr2.includes(item))
        }
    </script>
@endsection
