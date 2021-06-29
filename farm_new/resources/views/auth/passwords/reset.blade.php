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
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/theme-green&white.css')}}"/>
    <style>
        .col-form-label,.invalid-feedback{
            color:#fff;
        }
    </style>
</head>
<body>
<div class="login-container">
        <div class="login-box animated fadeInDown">
            <div><h2 style="text-align: center;color: #007a33;">KakaoMundo App</h2>
            @if($message=session('success'))
                <h2 class="col-form-label">{{$message}}</h2>
            @endif
            </div>
            <div class="login-body">
                
                 <div class="login-title"><strong>{{ __('Reset Password') }}</strong>,{{$user->email}}</div>
                    <form method="POST" action="{{ url('/reset_password/'.$user->email.'/'.$code)}}">
                        @csrf
                        

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? old('email') }}" required autocomplete="email" autofocus readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-12 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>

</body>
</html>
