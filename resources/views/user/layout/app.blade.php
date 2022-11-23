<!DOCTYPE html>
<html lang="en">

<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Psm Property</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{  asset('assets/css/app.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}"> -->
    <!-- Extra Style Link -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"> -->
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{  asset('assets/css/style.css') }}">
    <!-- <link rel="stylesheet" href="{{  asset('assets/css/components.css') }}"> -->

    <!-- <link rel="stylesheet" href="{{  asset('assets/css/all.min.css') }}"> -->
    <!-- Custom style CSS -->
    <!-- <link rel="stylesheet" href="{{  asset('assets/css/custom.css') }}"> -->
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('user.layout.header')
            @include('user.layout.aside')
            @yield('content')
            @include('user.layout.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <!-- <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script> -->
    <!-- Page Specific JS File -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script> -->
    <!-- <script src="{{ asset('assets/js/page/index.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script> -->
    <!-- Page Specific JS File -->
    <!-- <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script> -->
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <!-- <script src="{{ asset('assets/js/custom.js') }}"></script> -->
    <!-- Sweet Alert -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!--<script>
    $('body').on('click','.deleteBtn',function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        let _token = $(this).data('token');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    data: '_token='+_token,
                    type: "DELETE",
                    success: function (data) {
                        if(data.status == 'success'){
                            successMsg(data.message);
                            setTimeout(function () {
                                location.reload();
                            },1000);
                        }else{
                            errorMsg(data.message);
                        }
                    },
                });
            }
        })
    })
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        width: '27rem',
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
        @if (Session()->has('message'))
    var type = "{{ Session::get('alert') }}";
    switch (type) {
        case'info':
            Toast.fire({
                icon: 'info',
                title: '{{ Session::get("message") }}'
            })
            break;
        case 'success':
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get("message") }}'
            })
            break;
        case 'warning':
            Toast.fire({
                icon: 'warning',
                title: '{{ Session::get("message") }}'
            })
            break;
        case'error':
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get("message") }}'
            })
            break;
    }
    @endif
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    function errorMsg(msg){
        Toast.fire({
            icon: 'error',
            title: msg,
        });
    }
    function successMsg(msg){
        Toast.fire({
            icon: 'success',
            title: msg,
        });
    }

    function showLoader(){
        $(".loader").fadeIn("slow");
    }

    function hideLoader(){
        $(".loader").fadeOut("slow");
    }
</script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            /*$("#signInButton").trigger('click');*/
            $.ajax({
                url: "{{ url('property-manager/latest/notification') }}",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data)
                    /*$('select[name="floor_id"]').empty();
                    if (data.length === 0) {
                        $('select[name="floor_id"]').append('<option value="">Null</option>');
                    } else {
                        $('select[name="floor_id"]').append('<option value="">Please Select</option>');
                        $.each(data, function (key, value) {
                            $('select[name="floor_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }*/
                },
            });
        }, 5000);
    });
</script> -->
=======

    <meta charset="utf-8" />
    <title>Dashboard | UBold - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('/')}}/assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('/')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{asset('/')}}/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="{{asset('/')}}/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link href="{{asset('/')}}/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />

    <!-- icons -->
    <link href="{{asset('/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>

<body data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <!-- Begin page -->
    <div id="wrapper">
        @include('user.layout.header')
        @include('user.layout.aside')
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- container -->
            </div> <!-- content -->
            @include('user.layout.footer')
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="{{asset('/')}}/assets/js/vendor.min.js"></script>

    <!-- App js-->
    <script src="{{asset('/')}}/assets/js/app.min.js"></script>

>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
</body>

</html>