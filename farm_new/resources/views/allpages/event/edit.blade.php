@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Event</li>
@endsection

@section('maincontent')

@php
    $user_priv = array();
    if (session()->has('user_priv')) {
        $user_priv = session()->get('user_priv');
    }

@endphp

    <style>
        .form-group{
           margin:10px; 
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/event/{{$event->id}}">
                {{csrf_field()}}
                @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Event</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('event')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    
                    <div class="panel-body">
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" id="name" value="{{$event->name}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="description" id="description" value="{{$event->description}}" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Type <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="type" id="type">
                                            <option value="">Select</option>
                                            @foreach($event_type as $value)
                                            <option value="{{$value->id}}" @if($event->type == $value->id) selected @endif >{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">CommunityGrp <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="community_group" id="community_group">
                                            <option value="">Select</option>
                                            @foreach($communitygrp as $community)
                                            <option value="{{$community->id}}" @if($event->com_group == $community->id) selected @endif >{{$community->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Expected Start Date <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="exp_start_date" id="exp_start_date" value="{{$event->exp_start_date}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Start Date</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="actual_start_date" id="actual_start_date" value="{{$event->actual_start_date}}" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Expected End Date</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="exp_end_date" id="exp_end_date" value="{{$event->exp_end_date}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">End Date</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="actual_end_date" id="actual_end_date" value="{{$event->actual_end_date}}" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Expected Duration</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="exp_duration" id="exp_duration" value="{{$event->exp_duration}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Duration</label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="actual_duration" id="actual_duration" value="{{$event->actual_duration}}" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Responsible <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="responsible" id="responsible">
                                            <option value="">Select</option>
                                            @foreach($person as $value)
                                            <option value="{{$value->id}}"  @if($event->responsible == $value->id) selected @endif >{{$value->fname.' '.$value->lname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Assigned team <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="assigned_team" id="assigned_team">
                                            <option value="">Select</option>
                                            @foreach($team as $value)
                                            <option value="{{$value->id}}" @if($event->assigned_team == $value->id) selected @endif >{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select</option>
                                            @foreach($event_status as $value)
                                            <option value="{{$value->id}}" @if($event->status == $value->id) selected @endif >{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Closed</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="closed" id="closed">
                                            <option value="0" @if($event->closed == 0) selected @endif >No</option>
                                            <option value="1" @if($event->closed == 1) selected @endif >Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
@endsection

@section('javascript')
<script>
    $.validator.addMethod("checkUserName", 
        function(value, element) {
            var token = $('#_token').val();
            var result = false;
            $.ajax({
                type:"POST",
                async: false,
                url: '/checkunique', // script to validate in server side
                data: {'name': value, _token:token,'page':'event','id':{{$event->id}}},
                success: function(data) {
                   result = (data == false) ? true : false;
                }
            });
            // return true if username is exist in database
            return result; 
        }, 
        "This name is already taken! Try another."
    );
    
    var jvalidate = $("#add_form").validate({
         ignore: "",
        rules: {
            name: {
                required: true,
                checkUserName: true
            },
            // description: {
            //     required: true,
            // },
            type: {
                required: true,
            },
            community_group: {
                required: true,
            },
            exp_start_date: {
                required: true,
            },
            // actual_start_date: {
            //     required: true,
            // },
            // exp_end_date: {
            //     required: true,
            // },
            // actual_end_date: {
            //     required: true,
            // },
            // exp_duration: {
            //     required: true,
            // },
            // actual_duration: {
            //     required: true,
            // },
            responsible: {
                required: true,
            },
            assigned_team: {
                required: true,
            },
            status: {
                required: true,
            },
        }
    });
    
    

    </script>
@endsection