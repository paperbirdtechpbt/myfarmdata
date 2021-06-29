@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li><a href="#">Setting</a></li>
    <li class="active">Reset Password</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/updatepassword">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Reset</strong> Password</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('dashboard')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Old Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="old_password" id="old_password" maxlength="8" value="{{old('old_password')}}">
                                    {{csrf_field()}}
                                    <span class="help-block">This field is required</span>
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password" id="password" maxlength="8" value="{{old('password')}}">
                                    <span class="help-block">This field is required</span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password Confirmation</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" maxlength="8" value="{{old('password_confirmation')}}">
                                    <span class="help-block">This field is required</span>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button1 class="btn btn-default" onClick="$('#add_form')[0].reset();">Clear Form</button1>
                        <button class="btn btn-primary pull-right">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            old_password: {
                required: true,
                minlength: 8,
                maxlength: 8,
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 8,
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                maxlength: 8,
                equalTo : "#password"
            },
        }
    });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
