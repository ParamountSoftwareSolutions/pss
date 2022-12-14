<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Psm Property | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}">

    <!-- App css -->
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{asset('/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">

    <link href="{{asset('assets/css/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link href="{{asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />

    <!-- icons -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    @yield('style')
</head>

<body data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>
    <!-- Begin page -->
    <div id="wrapper">
        @include('admin.layout.header')
        @include('admin.layout.aside')
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
            @include('admin.layout.footer')
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script> -->
    <!-- Vendor js -->
    <script src="{{asset('assets/js/vendor.min.js')}}"></script>

    <!-- App js-->
    <script src="{{asset('assets/js/app.min.js')}}"></script>
    <!-- third party js -->

    <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
{{--    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>--}}
{{--    <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>--}}
    <!-- third party js ends -->
    <!-- Datatables init -->
{{--    <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>--}}
{{--    <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>--}}
    <!-- Ckeditor -->
    <script src="{{asset('assets/js/ckeditor.js')}}"></script>
    <script src="{{asset('assets/js/spartan-multi-image-picker.js')}}"></script>
{{--    <script src="{{asset('assets/js/resumble.min.js')}}"></script>--}}

    <!-- Sweetalert -->
    @include('admin.layout.sweetalert')

    @yield('script')

</body>
</html>
