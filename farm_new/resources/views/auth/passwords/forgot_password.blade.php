@php
use App\Role;
$roles = Role::all();
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="body-full-height">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--<title>{{ config('app.name', 'Laravel') }}</title>-->
    <title>KakaoMundo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--<link rel="icon" href="favicon.ico" type="image/x-icon" />-->
    <link rel="icon" href="favicon.ico" type="image/x-icon" href="{{asset('img/kakaomundo.png')}}">
    <!--<link rel="shortcut icon" type="image/x-icon" href="http://www.kakaomundo.com/PF.Site/flavors/material/assets/favicons/69e43e5130e9ffaeb9b0e772fc20f510.png?v=80211a950186e7f14db09e0474332650">-->
    <link rel="stylesheet" type="text/css" id="theme" href="css/theme-green&white.css"/>
</head>
<body>
    <div class="login-container">
        <div class="login-box animated fadeInDown">
            <div><h2 style="text-align: center;color: #007a33;">KakaoMundo App</h2>
            @if($message=session('success'))
                <h2>{{$message}}</h2>
            @endif
            </div>
            <div class="login-body">
                <div class="login-title"><strong>{{ __('Reset Password') }}</strong></div>
                <form method="POST" action="{{url('/forgot_password')}}">
                    @csrf
                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <!-- <button type="submit" class="btn btn-info btn-block">Log In</button> -->
                            <button type="submit" class="btn btn-success">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            <!-- <a href="{{url('dashboard')}}" class="btn btn-default btn-block">Log In</a> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
</body>
</html>


