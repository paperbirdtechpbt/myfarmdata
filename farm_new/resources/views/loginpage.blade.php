@php


try {
    DB::connection()->getPdo();
    echo "db connect successfully";
} catch (\Exception $e) {
echo $e->getMessage();
    //die("Could not connect to the database.  Please check your configuration. error:" . $e->getMessage() );
    //die("Could not connect to the database.  Please check your configuration. error:" . $e );
}


@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="body-full-height">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" id="theme" href="css/theme-red&white.css"/>
</head>
<body>
    <div class="login-container">
        <div class="login-box animated fadeInDown">
            <div><h2 style="text-align: center;color: #831515;">Farm Gabon</h2></div>
            <div class="login-body">
                <div class="login-title"><strong>Welcome</strong>, Please login</div>
                <form method="POST" class="form-horizontal" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember" style="color: white">{{ __('Remember Me') }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            @if (Route::has('password.request'))
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <!-- <button type="submit" class="btn btn-info btn-block">Log In</button> -->
                            <!-- <button type="submit" class="btn btn-info btn-block">Log In</button> -->
                            <a href="{{url('dashboard')}}" class="btn btn-default btn-block">Log In</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                <div class="pull-left">
                    &copy; 2020 Laravel School
                </div>
                <div class="pull-right">
                    <a href="#">About</a> |
                    <a href="#">Privacy</a> |
                    <a href="#">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
