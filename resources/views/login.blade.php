<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{  asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/login.css')}}" />
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />
</head>

<body class="body d-flex flex-column min-vh-100">
    <div class="container-fluid ">
        <div class="row d-block mr-0">
            <div class="mx-auto box col-xl-4 col-lg-4 col-sm-6 col-8">
                <h1 class="text-center mb-4">Login</h1>
                @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <span>{{ $message }}</span>
                </div>
                @endif
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" id="" class="form-control" @error('email') is-invalid @enderror tabindex="1" required autofocus required placeholder="Email" value="{{ old('email') }}" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" id="" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                            Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block col-xl-4 col-lg-5 col-md-5 col-sm-5 col-7 mx-auto">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer mt-auto">
        <div>
            <div class="container-fluid text-center">
                <div class="row mr-0">
                    <div class="mx-auto d-flex pt-2">
                        <p class="">Powered By: Paramount Software Solutions</p>
                        <img src="{{asset('assets/img/logo-login.png')}}" width="50px" height="40px" class="logo" />
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>