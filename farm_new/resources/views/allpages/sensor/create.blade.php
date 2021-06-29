@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Sensor</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="{{route('sensor.store')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Sensor</h3>
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
                                            <select class="form-control select" name="sensor_type_id" id="sensor_type_id" value="{{old('sensor_type_id')}}">
                                                <option value="">select</option>
                                                @foreach($sensorType as $key=> $data)
                                                    <option value="{{$key}}">{{$data}}</option>
                                                @endforeach
                                                <!-- <option value="1">type1</option>
                                                <option value="2">tye2</option> -->
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Id</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sensorId" id="sensorId" value="{{old('sensorId')}}">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Brand</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="brand" id="brand" value="{{old('brand')}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Owner</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="user_id" id="user_id" value="{{old('user_id')}}">
                                                <option value="">select</option>
                                                @foreach($user as $key=> $data)
                                                    <option value="{{$key}}">{{$data}}</option>
                                                @endforeach
                                                <!-- <option value="1">type1</option>
                                                <option value="2">tye2</option> -->
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Units</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="unit_id" id="unit_id">
                                                <option value="">select</option>
                                                @foreach($unit as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="community_group" id="community_group"  value="{{old('community_group')}}">
                                                <option value="">Select</option>
                                                @foreach($communitygrp as $community)
                                                <option value="{{$community->id}}">{{$community->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Container</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="container_id" id="container_id"  value="{{old('container_id')}}">
                                                <option value="">Select</option>
                                                @foreach($containers as $container)
                                                <option value="{{$container->id}}">{{$container->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                            <span class="help-block">This field is required</span>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Model</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="model" id="model" value="{{old('model')}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Ip</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sensorIp" id="sensorIp" value="{{old('sensorIp')}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Minimum</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="minimum" id="minimum" value="{{old('minimum')}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Maximum</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="maximum" id="maximum" value="{{old('maximum')}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Connected Board</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="connected_board" id="connected_board"  value="{{old('connected_board')}}">
                                                <option value="">Select</option>
                                                <option value="RASPBERRY_001">RASPBERRY_001</option>
                                                <option value="RASPBERRY_002">RASPBERRY_002</option>
                                                <option value="RASPBERRY_003">RASPBERRY_003</option>
                                            </select>
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
    $.validator.addMethod('IP4Checker', function(value) {
        var split = value.split('.');
        if (split.length != 4) 
            return false;
                
        for (var i=0; i<split.length; i++) {
            var s = split[i];
            if (s.length==0 || isNaN(s) || s<0 || s>255)
                return false;
        }
        return true;
    
        // var ip = "^(?:(?:25[0-5]2[0-4][0-9][01]?[0-9][0-9]?)\.){3}" +
        //     "(?:25[0-5]2[0-4][0-9][01]?[0-9][0-9]?)$";
        // return value.match(ip);
    }, 'Invalid IP address');

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
                IP4Checker: true
            },
            container_id: {
                required: true,
            },
            community_group: {
                required: true,
            },
           
        }
    });
    // $('#sensorId').val('123');
    // $('#brand').val('aaa');
    // $('#name').val('aaa');
    // $('#model').val('aaa');
    // $('#sensorIp').val('123.123.123.123');
    // $('#minimum').val('1');
    // $('#maximum').val('2');
    </script>
@endsection
