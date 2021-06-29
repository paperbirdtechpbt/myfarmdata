@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Sensor</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="{{route('sensor.update',$sensor->id)}}">
            @method('PUT')
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
                                                @foreach($sensorType as $key=> $data)
                                                    <option value="{{$key}}" 
                                                        @if($sensor->sensor_type_id==$key)
                                                            selected
                                                        @endif>
                                                        {{$data}}
                                                    </option>
                                                @endforeach

                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Id</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sensorId" id="sensorId" value="{{$sensor->sensorId}}">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Brand</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="brand" id="brand" value="{{$sensor->brand}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Owner</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="user_id" id="user_id">
                                                <option value="">select</option>
                                                @foreach($user as $key=> $data)
                                                    <option value="{{$key}}" 
                                                        @if($sensor->user_id==$key)
                                                            selected
                                                        @endif>
                                                        {{$data}}
                                                    </option>
                                                @endforeach
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
                                                    <option value="{{$key}}" 
                                                        @if($sensor->unit_id==$key)
                                                            selected
                                                        @endif>{{$value}}</option>
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
                                                <option value="{{$community->id}}" @if($sensor->community_group == $community->id){{'selected'}}@endif  >{{$community->name}}</option>
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
                                                <option value="{{$container->id}}" @if($sensor->container_id == $container->id){{'selected'}}@endif  >{{$container->name}}</option>
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
                                            <input type="text" class="form-control" name="name" id="name" value="{{$sensor->name}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Model</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="model" id="model" value="{{$sensor->model}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Ip</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="sensorIp" id="sensorIp" value="{{$sensor->sensorIp}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Minimum</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="minimum" id="minimum" value="{{$sensor->minimum}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Maximum</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="maximum" id="maximum" value="{{$sensor->maximum}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Connected Board</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="connected_board" id="connected_board"  value="{{old('connected_board')}}">
                                                <option value="">Select</option>
                                                <option value="RASPBERRY_001" @if($sensor->connected_board=='RASPBERRY_001') selected @endif>RASPBERRY_001</option>
                                                <option value="RASPBERRY_002" @if($sensor->connected_board=='RASPBERRY_002') selected @endif>RASPBERRY_002</option>
                                                <option value="RASPBERRY_003" @if($sensor->connected_board=='RASPBERRY_003') selected @endif>RASPBERRY_003</option>
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
            container_id: {
                required: true,
            },
            community_group: {
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
