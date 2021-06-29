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
                            <!--<input id="email" type="email" class="form-control @error('role') is-invalid @enderror" name="role_id" value="{{ old('role_id') }}" required autocomplete="role" placeholder="Role">-->
                            <select class="form-control @error('role') is-invalid @enderror" type="email" id="role_id" name="role_id" value="{{ old('role_id') }}" required autocomplete="role" placeholder="Role">
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                <!--<option value="1">Role1</option>-->
                                <!--<option value="2">Role2</option>-->
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <div class="col-md-12">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember" style="color: white">{{ __('Remember Me') }}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                           <!--  @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-link btn-block">Forgot your password?</a>
                            <a href="{{ route('password.request') }}" class="btn btn-link btn-block">Reset your password</a>
                            @endif -->
                            <a href="{{ url('/forgot_password') }}" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                        <div class="col-md-6">
                            <!-- <button type="submit" class="btn btn-info btn-block">Log In</button> -->
                            <button type="submit" class="btn btn-default btn-block">Log In</button>
                            <!-- <a href="{{url('dashboard')}}" class="btn btn-default btn-block">Log In</a> -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                <div class="pull-left">
                    &copy; 2020 KakaoMundo
                </div>
                <div class="pull-right">
                    <a href="{{ route('about_us') }}">About</a> |
                    <a href="{{ route('privacy_policy') }}">Privacy</a> |
                    <a href="{{ route('contact_us') }}">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
    @include('common.js')
    <script>
        $( "#email" ).keyup(function() {
            var email = $('#email').val();
            var token = $('#_token').val();
            $.ajax({
                url: '/rolefromemailid',
                data: {email:email, _token:token },
                type: 'POST',
                success: function(data) {
                    var html_data = '<option value="">Select Your Role</option>';
                    if(data.status == 'data_found')
                    {
                        for(var i=0; i<data.roles.length; i++)
                        {
                            html_data += '<option value="'+data.roles[i].id+'">'+data.roles[i].name+'</option>';
                        }
                        $('#role_id').html(html_data);
                    }
                    else if(data.status == 'data_not_found')
                    {
                        $('#role_id').html('<option value="">Select Role</option>');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    // $('.login-footer').html(xhr.responseText);
                    alert('something bad happened');
                }
            });
        });
    </script>
</body>
</html>


