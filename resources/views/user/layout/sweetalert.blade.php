<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
        timer: 4000,
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
    @if ($errors->any())
    @foreach($errors->all() as $error)
    Toast.fire({
        icon: 'error',
        title: '{{ $error }}'
    });
    @endforeach
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
        return;
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
    function get_date() {
        var month_arr = ["01","02","03","04","05","06","07","08","09","10","11","12"];
        var day_arr = ["00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];
        var date = new Date();
        var month = month_arr[date.getMonth()];
        var day = day_arr[date.getDate()];
        var year = date.getFullYear();
        var a = year+'-'+month+'-'+day;
        return a;
    }

</script>
