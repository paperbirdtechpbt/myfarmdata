@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create List</li>
@endsection

@php

@endphp

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/list">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> List</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('list')}}"><span class="fa fa-times"></span></a></li>
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
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="community_group_id" id="community_group_id" value="{{old('community_group_id')}}">-->
                                            <select class="form-control select" name="communitygroupid" id="communitygroupid" value="{{old('name')}}">
                                            <!--<select multiple class="form-control select" name="community_group_id" id="community_group_id" value="{{old('name')}}">-->
                                                <!--<option value="">select</option>-->
                                                @foreach($communitygrp as $community_group)
                                                <option value="{{$community_group->id}}">{{$community_group->name}}</option>
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
                                        <label class="col-md-3 control-label">Choice</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="choice0" id="choice0" value="{{old('choice0')}}">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button" onclick="add_row(0)"><i class="fa fa-pencil"></i> Add</button>
                                                </span>
                                            </div>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">-->
                                    <!--    <div class="col-md-9">-->
                                    <!--        <button1 class="btn btn-default" onclick="add_row(0)"><i class="fa fa-pencil"></i>Add</button1>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                            </div>
                            <div class="col-md-12" id="privilege_div" style="margin-top: 20px;"></div>                            
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="privilege_count" id="privilege_count" value="0">
                        <input type="hidden" name="community_group_id" id="community_group_id" value="">
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
    
    $( "#communitygroupid" ).change(function() {
        // alert($( "#collectactivityid" ).val());
        $('#community_group_id').val($( "#communitygroupid" ).val());
    });
    
    
    var count = 1;
    function add_row(count1) {
        var html_data = '';
        html_data += '<div class="col-md-6" id="priv_div'+count+'"><div class="form-group"><label class="col-md-3 control-label">Choice</label><div class="col-md-9"><div class="input-group"><input type="text" class="form-control" name="privilege0" id="privilege0" value="{{old('name')}}"><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="delete_row('+count+')"><i class="fa fa-trash-o" style="color: red;"></i></button></span></div><span class="help-block">This field is required</span><input type="hidden" name="privilege_is_delete'+count+'" id="privilege_is_delete'+count+'" value="0"></div></div></div>';
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
        }
    });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
