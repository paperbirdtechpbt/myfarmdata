@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Sensor</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="#">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Sensor</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('sensor')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Sensor Type</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="sensor_type_id" id="sensor_type_id">
                                                <option value="">select</option>
                                                <option value="true">type1</option>
                                                <option value="false">tye2</option>
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Id</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sensorId" id="sensorId" value="">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Brand</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="brand" id="brand" value="">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Owner</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="user_id" id="user_id">
                                                <option value="">select</option>
                                                <option value="true">type1</option>
                                                <option value="false">tye2</option>
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Model</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="model" id="model" value="">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Ip</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sensorIp" id="sensorIp" value="">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
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
            sensor_type_id: {
                required: true,
            },
            sensorId: {
                required: true,
            },
            brand: {
                required: true,
            },
            user_id: {
                required: true,
            },
            name: {
                required: true,
            },
            model: {
                required: true,
            },
            sensorIp: {
                required: true,
            },
        }
    });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
