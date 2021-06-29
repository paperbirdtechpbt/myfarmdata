@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Role</li>
@endsection

@php
//dd($privileges);
@endphp

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/role">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Role</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('role')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Dashboard View</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="dashboard_view" id="dashboard_view" value="{{old('dashboard_view')}}">-->
                                            <input type="hidden" class="form-control" name="dashboard_view1" id="dashboard_view1">
                                            <select multiple class="form-control select" name="dashboard_view" id="dashboard_view" value="{{old('dashboard_view')}}">
                                                <!--<option value="">select</option>-->
                                                @foreach($dashboardsettings as $dashboardsetting)
                                                <option value="{{$dashboardsetting->id}}">{{$dashboardsetting->name}}</option>
                                                @endforeach
                                            </select>
                                            
                                            <span class="help-block">This field is required</span>
                                            @error('dashboard_view')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Privilege</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="privilege0" id="privilege0" value="{{old('name')}}">-->
                                            <select class="form-control select" name="privilege0" id="privilege0">
                                                <option value="">select</option>
                                                @foreach($privileges as $privilege)
                                                <option value="{{$privilege->name}}">{{$privilege->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{old('name')}}">
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
                                                <!--<option value="GAB_01">GAB_01</option>-->
                                                <!--<option value="GAB_02">GAB_02</option>-->
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button1 class="btn btn-default" onclick="add_row(0)"  style="float: right;"><i class="fa fa-pencil" ></i>Add Privilege</button1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="privilege_div" style="margin-top: 20px;"></div>                            
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="privilege_count" id="privilege_count" value="0">
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
    var count = 1;
    function add_row(count1) {
        var html_data = '';
        html_data += '<div class="col-md-6" id="priv_div'+count+'"><div class="form-group"><label class="col-md-3 control-label">Privilege</label><div class="col-md-9"><div class="input-group"><select class="form-control select" name="privilege'+count+'" id="privilege'+count+'"><option value="">select</option>@foreach($privileges as $privilege)<option value="{{$privilege->name}}">{{$privilege->name}}</option>@endforeach</select><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="delete_row('+count+')"><i class="fa fa-trash-o" style="color: red;"></i></button></span></div><span class="help-block">This field is required</span><input type="hidden" name="privilege_is_delete'+count+'" id="privilege_is_delete'+count+'" value="0"></div></div></div>';
        $('#privilege_div').append(html_data);
        $('#privilege_count').val(count);
        count++;
    }
    function delete_row(count) {
        $('#priv_div'+count).hide();
        $('#privilege_is_delete'+count).val('1');
    }
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
            },
            description: {
                required: true,
            },
            community_group: {
                required: true,
            },
            dashboard_view: {
                required: true,
            },
        }
    });
    $( "#dashboard_view" ).change(function() {
        $('#dashboard_view1').val($( "#dashboard_view" ).val());
    });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
