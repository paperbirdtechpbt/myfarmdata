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
    #loader {
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          width: 100%;
          background: rgba(0,0,0,0.25) url("{{asset('img/loaders/default.gif')}}") no-repeat center center;
          z-index: 10000;
        }
</style>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/incident" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Incident</h3>
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
                                        <input type="text" class="form-control" name="title" id="title">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="description" id="description">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pack <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="pack_reference" id="pack_reference" >
                                            <option value="">Select</option>
                                            @foreach($packs as $pack)
                                            <option value="{{$pack->id}}">{{$pack->id.'_'.$pack->species.'_'.$pack->creation_date}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">CommunityGrp <span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="com_group" id="com_group">
                                            <option value="">Select</option>
                                            @foreach($communitygrp as $community)
                                            <option value="{{$community->id}}">{{$community->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Upload Media Image<span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="pic_link" id="pic_link" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Upload Media Video<span class="mandatory">*</span></label>
                                    <div class="col-md-9">
                                        <input type="file" class="form-control" name="video_link" id="video_link" accept="video/*">
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
    <div id="loader"></div>  
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
    var spinner = $('#loader');
    $.validator.addMethod("checkUserName", 
        function(value, element) {
            var token = $('#_token').val();
            var result = false;
            $.ajax({
                type:"POST",
                async: false,
                url: '/checkunique', // script to validate in server side
                data: {'name': value, _token:token,'page':'event','id':null},
                success: function(data) {
                   result = (data == false) ? true : false;
                }
            });
            // return true if username is exist in database
            return result; 
        }, 
        "This name is already taken! Try another."
    );
    
    $.validator.addMethod('filesize', function (value, element,param) {
        var size=element.files[0].size;
        size=size/1024;
        size=Math.round(size);
        return this.optional(element) || size <=param ;
    }, 'File size must be less than 2MB');
    
    var jvalidate = $("#add_form").validate({
        ignore: "",
        rules: {
            title: {
                required: true,
            },
            description: {
                required: true,
            },
            pack_reference: {
                required: true,
            },
            com_group: {
                required: true,
            },
            pic_link: {
                required: true,
                accept: "image/*",
                filesize: 2000
            },
            video_link: {
                required: true,
                accept: "video/*",
                filesize: 2000
            },
        },
        submitHandler : function(form) {
            spinner.show();
            form.submit();
        }
    });
    
</script>
@endsection