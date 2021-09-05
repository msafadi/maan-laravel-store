<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }} | {{ __('Login') }}</title>

    <!-- vendor css -->
    <link href="{{ asset('assets/dashboard/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/typicons.font/typicons.css') }}" rel="stylesheet">

    <!-- azia CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/azia.css') }}">

</head>

<body class="az-body">

    <div class="az-signin-wrapper">
        <div class="az-card-signin">
            <h1 class="az-logo">az<span>i</span>a</h1>
            <div class="az-signin-header">
                <h2>Welcome back!</h2>
                <h4>Please sign in to continue</h4>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input type="text" name="{{ config('fortify.username') }}" class="form-control" placeholder="Enter your email" value="{{ old(config('fortify.username')) }}">
                        @error(config('fortify.username'))
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div><!-- form-group -->
                    <div class="form-group">
                        <label>{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password">
                        @error('password')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div><!-- form-group -->
                    <button type="submit" class="btn btn-az-primary btn-block">Sign In</button>
                </form>
            </div><!-- az-signin-header -->
            <div class="az-signin-footer">
                <p><a href="">Forgot password?</a></p>
                <p>Don't have an account? <a href="page-signup.html">Create an Account</a></p>
            </div><!-- az-signin-footer -->
        </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->

    <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/dashboard/js/jquery.cookie.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/dashboard/js/azia.js') }}"></script>

</body>

</html>