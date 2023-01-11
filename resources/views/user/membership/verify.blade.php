<!DOCTYPE html>
<html lang="en">
<head>
    <title>Psm Property</title>
    <link rel="shortcut icon" href="{{asset('/assets/images/favicon.ico')}}">
</head>
<body>
<script src="{{asset('assets/js/vendor.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        var st = "{{$status}}";
        var msg = "{{$msg}}";
        Swal.fire({
            icon: st,
            title: msg,
            text: '',
        })
    });
</script>
</body>
</html>
