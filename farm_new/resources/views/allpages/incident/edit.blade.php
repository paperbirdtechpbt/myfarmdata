@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Incident</li>
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
            <form class="form-horizontal" id="add_form" method="post" action="/incident/{{$incident->id}}">
                {{csrf_field()}}
                @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Incident</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('incident')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    
                    <div class="panel-body">
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Title <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="title" id="title" value="{{$incident->title}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="description" id="description" value="{{$incident->description}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pack <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="pack_reference" id="pack_reference" readonly>
                                            <option value="">Select</option>
                                            @foreach($packs as $pack)
                                            <option value="{{$pack->id}}" disabled @if($incident->pack_reference  == $pack->id) selected @endif>{{$pack->id.'_'.$pack->species.'_'.$pack->creation_date}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">CommunityGrp <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="com_group" id="com_group" readonly>
                                            <option value="">Select</option>
                                            @foreach($communitygrp as $community)
                                            <option value="{{$community->id}}" disabled @if($incident->com_group  == $community->id) selected @endif>{{$community->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="status" id="status">
                                            @if($incident->status != 'CLOSED')
                                            <option value="">Select</option>
                                            <option value="PENDING" @if($incident->status  == 'PENDING') selected @endif>PENDING</option>
                                            <option value="SLOVED" @if($incident->status  == 'SLOVED') selected @endif>SLOVED</option>
                                            <option value="CANCELED" @if($incident->status  == 'CANCELED') selected @endif>CANCELED</option>
                                            @else
                                            <option value="CLOSED" @if($incident->status  == 'CLOSED') selected @endif>CLOSED</option>
                                            @endif
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Resolution</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="resolution" id="resolution" value="{{$incident->resolution}}">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row col-md-12" >
                            @if($incident->pic_link != null)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Media Image</label>
                                    <div class="col-md-9">
                                        
                                        <img src="{{asset('file_upload/incident/images')}}/{{$incident->pic_link}}" alt="{{$incident->pic_link}}" width="100" height="100">
                                        
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($incident->video_link != null)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Media Video</label>
                                    <div class="col-md-9">
                                        <embed src = "{{asset('file_upload/incident/videos')}}/{{$incident->video_link}}" width = "100%" height = "100" ></embed>
                                    </div>
                                </div>
                            </div
                            @endif
                            
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
                data: {'name': value, _token:token,'page':'event','id':{{$incident->id}}},
                success: function(data) {
                   result = (data == false) ? true : false;
                }
            });
            // return true if username is exist in database
            return result; 
        }, 
        "This name is already taken! Try another."
    );
</script>
@endsection