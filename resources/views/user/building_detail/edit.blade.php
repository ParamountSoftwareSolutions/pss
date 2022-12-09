@extends('user.layout.app')
@section('title', 'Edit Building')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <form method="post"
                              action="{{ route('building.extra_detail.update', ['RolePrefix' => RolePrefix(),'building' => $building->id, 'extra_detail' => $building_detail->id]) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address"
                                                       value="{{old('address', $building_detail->address) }}">
                                                @error('address')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Developer Name</label>
                                                <input type="text" class="form-control" name="developer"
                                                       value="{{ old('developer', $building_detail->developer) }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="text" class="form-control" name="price"
                                                       placeholder="PKR 1Lak to 10Lak"
                                                       value="{{ old('price', $building_detail->price) }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" id="editor1" cols="30"
                                                          rows="10">{!! $building_detail->description !!}</textarea>
                                                @error('description')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Plot Features</div>
                                            @forelse($plot_features as $data)
                                                @php($plot_feature = json_decode($building_detail->plot_feature))
                                                @php($checked = $plot_feature ? $plot_feature : ['0'])
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           {{in_array($data->id,$checked) ? 'checked' : ''}}
                                                           class="custom-control-input"
                                                           name="plot_feature[]"
                                                           id="{{$data->id}}"
                                                           value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Business And Communication Features</div>
                                            @forelse($communication_features as $data)
                                                @php($communication_feature = json_decode($building_detail->communication_feature))
                                                @php($checked = $communication_feature ? $communication_feature : ['0'])
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           {{in_array($data->id,$checked) ? 'checked' : ''}}
                                                           class="custom-control-input"
                                                           name="communication_feature[]"
                                                           id="{{$data->id}}"
                                                           value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Community Features</div>
                                            @forelse($community_features as $data)
                                                @php($community_feature = json_decode($building_detail->community_feature))
                                                @php($checked = $community_feature ? $community_feature : ['0'])
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           {{in_array($data->id,$checked) ? 'checked' : ''}}
                                                           class="custom-control-input"
                                                           name="community_feature[]"
                                                           id="{{$data->id}}"
                                                           value="{{$data->id}}">
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
                                                @php($health_feature = json_decode($building_detail->health_feature))
                                                @php($checked = $health_feature ? $health_feature : ['0'])
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           {{in_array($data->id,$checked) ? 'checked' : ''}}
                                                           class="custom-control-input"
                                                           name="health_feature[]"
                                                           id="{{$data->id}}"
                                                           value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">NearBy Location And Other Facilities</div>
                                            @forelse($other_features as $data)
                                                @php($other_feature = json_decode($building_detail->other_feature))
                                                @php($checked = $other_feature ? $other_feature : ['0'])
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           {{in_array($data->id,$checked) ? 'checked' : ''}}
                                                           class="custom-control-input"
                                                           name="other_feature[]"
                                                           id="{{$data->id}}"
                                                           value="{{$data->id}}">
                                                    <label class="custom-control-label" for="{{$data->id}}">{{$data->name}}</label>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Multi Image Upload -->
                            <div class="card card-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Payment Plan Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div class="row mb-3">
                                                @if($building_detail->building_detail_image->where('type', 'payment_plan') !== null)
                                                    @foreach($building_detail->building_detail_image->where('type', 'payment_plan') as $img)
                                                        <div class="col-3">
                                                            <img style="height: 200px;width: 100%" class="banner-image"
                                                                 src="{{asset($img->file)}}">
                                                            <a href=""
                                                               style="margin-top: -35px;border-radius: 0"
                                                               class="btn btn-danger btn-block btn-sm remove-image-payment"
                                                               data-id="{{ $img->id }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary">
                                <div class="card-header ui-sortable-handle">
                                    <h4>Floor Plan Images <small style="color: red">* (ratio 1:1)</small></h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <div class="row mb-3">
                                                @if($building_detail->building_detail_image->where('type', 'floor_plan') !== null)
                                                    @foreach($building_detail->building_detail_image->where('type', 'floor_plan') as $img)
                                                        <div class="col-3">
                                                            <img style="height: 200px;width: 100%" class="banner-image"
                                                                 src="{{asset($img->file)}}">
                                                            <a href=""
                                                               style="margin-top: -35px;border-radius: 0"
                                                               class="btn btn-danger btn-block btn-sm remove-image-floor"
                                                               data-id="{{ $img->id }}">Remove</a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div id="coba-floor" class="row coba-floor"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Second Form --}}
                            <div class="card">
                                <div class="card-header">
                                    <h4>Property Types</h4>
                                </div>
                                <div class="card-body">
                                    @php($shop_detail = json_decode($building_detail->property_type)->shop_detail)
                                    <div class="section-title mt-0">Shop Details:</div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Floor</div>
                                            <input type="text" class="form-control" name="floor"
                                                   placeholder="1st floor to top floor"
                                                   value="{{old('floor', $shop_detail->floor) }}">
                                            @error('floor')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Area</div>
                                            <input type="text" class="form-control" name="area" placeholder=""
                                                   value="{{old('area', $shop_detail->area) }}">
                                            @error('area')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Price</div>
                                            <input type="text" class="form-control" name="price"
                                                   placeholder="PKR 1lak to PKR 20LAK"
                                                   value="{{old('price', $shop_detail->price) }}">
                                            @error('price')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if(array_key_exists('single_bed_flat', (array) json_decode($building_detail->property_type)) == true)
                                        @php($single_detail = json_decode($building_detail->property_type)->single_bed_flat)
                                    @else
                                        @php($double_detail = null)
                                    @endif
                                    <div class="section-title mt-0">1 BED Flat Details:</div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Building</div>
                                            <input type="text" class="form-control" name="building_1bed"
                                                   placeholder="Building 9th to 20th"
                                                   value="{{old('building_1bed', ($single_detail !== null) ? $single_detail->building : '') }}">
                                            @error('building_1bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Area</div>
                                            <input type="text" class="form-control" name="area_1bed" placeholder=""
                                                   value="{{old('area_1bed', ($single_detail !== null) ? $single_detail->area : '') }}">
                                            @error('area_1bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Bed</div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked disabled
                                                       name="1bed"
                                                       id="1bed">
                                                <label class="custom-control-label"
                                                       for="1bed">1 Bed</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Bath</div>
                                            <input type="number" class="form-control" name="bath_1bed"
                                                   placeholder=""
                                                   value="{{old('bath_1bed', ($single_detail !== null) ? $single_detail->bath : '') }}">
                                            @error('bath_1bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Price</div>
                                            <input type="text" class="form-control" name="price_1bed"
                                                   placeholder="PKR 1lak to 20lak"
                                                   value="{{old('price_1bed', ($single_detail !== null) ? $single_detail->price : '') }}">
                                            @error('price_1bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if(array_key_exists('double_bed_flat', (array) json_decode($building_detail->property_type)) == true)
                                        @php($double_detail = json_decode($building_detail->property_type)->double_bed_flat)
                                    @else
                                        @php($double_detail = null)
                                    @endif
                                    <div class="section-title mt-0">2 BED Flat Details:</div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Building</div>
                                            <input type="text" class="form-control" name="building_2bed"
                                                   placeholder="Building 9th to 20th"
                                                   value="{{old('building_2bed', ($double_detail !== null) ? $double_detail->building : '') }}">
                                            @error('building_2bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Area</div>
                                            <input type="text" class="form-control" name="area_2bed" placeholder=""
                                                   value="{{old('area_2bed', ($double_detail !== null) ? $double_detail->area : '') }}">
                                            @error('area_2bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Bed</div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked disabled
                                                       name="bed_2bed"
                                                       id="bed_2bed">
                                                <label class="custom-control-label"
                                                       for="bed_2bed">2 Bed</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Bath</div>
                                            <input type="number" class="form-control" name="bath_2bed"
                                                   placeholder=""
                                                   value="{{old('bath_2bed', ($double_detail !== null) ? $double_detail->bath : '') }}">
                                            @error('bath_2bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Price</div>
                                            <input type="text" class="form-control" name="price_2bed"
                                                   placeholder="PKR 1lak to 20lak"
                                                   value="{{old('price_2bed', ($double_detail !== null) ? $double_detail->price : '') }}">
                                            @error('price_2bed')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if(array_key_exists('studio_bed_flat', (array) json_decode($building_detail->property_type)) == true)
                                        @php($studio_detail = json_decode($building_detail->property_type)->studio_bed_flat)
                                    @else
                                        @php($studio_detail = null)
                                    @endif
                                    <div class="section-title mt-0">Studio Flat Details:</div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Building</div>
                                            <input type="text" class="form-control" name="building_studio"
                                                   placeholder="Building 9th to 20th"
                                                   value="{{old('building_studio', ($studio_detail !== null) ? $studio_detail->building : '') }}">
                                            @error('building_studio')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Area</div>
                                            <input type="text" class="form-control" name="area_studio" placeholder=""
                                                   value="{{old('area_studio', ($studio_detail !== null) ? $studio_detail->area : '') }}">
                                            @error('area_studio')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Bed</div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked disabled
                                                       name="studio"
                                                       id="studio">
                                                <label class="custom-control-label"
                                                       for="studio">1 Bed</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Bath</div>
                                            <input type="number" class="form-control" name="bath_studio"
                                                   placeholder=""
                                                   value="{{old('bath_studio', ($studio_detail !== null) ? $studio_detail->bath : '') }}">
                                            @error('bath_studio')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="section-title mt-0">Price</div>
                                            <input type="text" class="form-control" name="price_studio"
                                                   placeholder="PKR 1lak to 20lak"
                                                   value="{{old('price_studio', ($studio_detail !== null) ? $studio_detail->price : '') }}">
                                            @error('price_studio')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Submit</button>
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
    <script type="text/javascript" src="{{ asset('public/panel/assets/js/spartan-multi-image-picker.js') }}"></script>
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
                    image: '{{asset("public/panel/assets/img/img2.jpg")}}',
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
        $('.remove-image-payment').on('click', function (e) {
            //e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            var building_detail_id = {{ $building_detail->id }};
            if (id) {
                $.ajax({
                    url: "{{ url('property-manager/banner-detail/payment-image/remove') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        building_detail_id: building_detail_id,
                        type: 'payment_plan'
                    },
                    success: function (response) {
                        console.log(response.name);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Image Remove Successfully.',
                        });
                    },
                });
            } else {
                alert('danger');
            }
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
                    image: '{{asset("public/panel/assets/img/img2.jpg")}}',
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
        $('.remove-image-floor').on('click', function (e) {
            //e.preventDefault();
            var id = $(this).data("id");
            console.log(id);
            var building_detail_id = {{ $building_detail->id }};
            if (id) {
                $.ajax({
                    url: "{{ url('property-manager/banner-detail/payment-image/remove') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        building_detail_id: building_detail_id,
                        type: 'floor_plan'
                    },
                    success: function (response) {
                        console.log(response.name);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        Toast.fire({
                            icon: 'success',
                            title: 'Image Remove Successfully.',
                        });
                    },
                });
            } else {
                alert('danger');
            }
        });
    </script>
@endsection
