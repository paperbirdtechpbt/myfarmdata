@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Dashboard Settings</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/dashboardsetting/{{$dashboardsetting->id}}">
                {{csrf_field()}}
                @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Dashboard Settings</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('dashboardsetting')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="dashboard_row" >
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$dashboardsetting->name}}">
                                            {{csrf_field()}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="title" id="title" value="{{$dashboardsetting->title}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="community_group" id="community_group">
                                                <option value="">Select</option>
                                                @foreach($communitygrp as $community)
                                                <option value="{{$community->id}}" @if($dashboardsetting->com_group == $community->id) selected @endif>{{$community->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{$dashboardsetting->description}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Max Number</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="max_number" id="max_number" value="{{$dashboardsetting->max_number}}">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            @foreach($dashboardsettingobjects as $dashboardsettingobject)
                            <div class="col-md-12" id="dashboard_div{{$loop->index}}" style="margin-top:20px;">
                                <input type="hidden" class="form-control" name="gc_name[]" id="gc_name{{$loop->index}}" value="">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Object Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_class[]" id="object_class{{$loop->index}}" onChange="getKey(this.value,{{$loop->index}});">
                                                <option value="">Select</option>
                                                @foreach($chart_list as $graphchart)
                                                <option value="{{$graphchart->id}}" @if($dashboardsettingobject->object_class == $graphchart->id) selected @endif>{{$graphchart->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Object Key</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_key[]" id="object_key{{$loop->index}}">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <input type="hidden" name="ds_id[]" id="ds_id{{$loop->index}}" value="{{$dashboardsettingobject->id}}">
                                            @if($loop->index > 0)
                                            <button1 class="btn btn-default" onclick="delete_row({{$loop->index}})" style="float: right;">Remove</button1>
                                            @else
                                            <button1 class="btn btn-default" onclick="add_row(0)"  style="float: right;"><i class="fa fa-pencil" ></i>Add Object</button1>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            @endforeach 
                                                       
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
    @foreach($dashboardsettingobjects as $dashboardsettingobject)
        
        getKey({{$dashboardsettingobject->object_class}},{{$loop->index}});
        $('#object_key{{$loop->index}}').val({{$dashboardsettingobject->object_key}});
        
    @endforeach
    
    var count = {{count($dashboardsettingobjects)}};;
    function add_row(count1) {
        
        var html_data = '<div class="col-md-12" id="dashboard_div'+count+'" style="margin-top:20px;"><input type="hidden" class="form-control" name="gc_name[]" id="gc_name'+count+'" value="">';
            html_data += '<div class="col-md-5"><div class="form-group"><label class="col-md-3 control-label">Object Class</label><div class="col-md-9"><select class="form-control" name="object_class[]" id="object_class'+count+'" onChange="getKey(this.value,'+count+');"><option value="">select</option>@foreach($chart_list as $graphchart)<option value="{{$graphchart->id}}">{{$graphchart->name}}</option>@endforeach</select></div></div></div>';
            html_data += '<div class="col-md-5"><div class="form-group"><label class="col-md-3 control-label">Object Key</label><div class="col-md-9"><select class="form-control" name="object_key[]" id="object_key'+count+'"><option value="">Select</option></select></div></div></div>';
            html_data += '<div class="col-md-2"><div class="form-group"><div class="col-md-12"><input type="hidden" name="ds_id[]" id="ds_id'+count+'" value="0"><button1 class="btn btn-default" onclick="delete_row('+count+')" style="float: right;">Remove</button1></div></div></div>';
            html_data += '</div>';
            
            $('#dashboard_row').append(html_data);
       
        count++;
     return false;
    }
    function delete_row(count) {
        // $('#dashboard_div'+count).remove();
        $('#gc_name'+count).val('deleted_data');
        $('#dashboard_div'+count).hide();
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
            title: {
                required: true,
            },
            community_group: {
                required: true,
            },
            max_number: {
                required: true,
                max: 6,
            },
            "object_class[]": {
                required: true
            },
            "object_key[]": {
                required: true
            },
        }
    });
    
    function getKey(id,count){
        var token = $('#_token').val();
            $.ajax({
                url: '/getDashboardObjectKey',
                data: {'id':id, _token:token },
                type: 'POST',
                async: false,
                success: function(data) {
                    
                    var response = JSON.parse(data);
                    var html_data = '<option value="">Select</option>';
                    $.each(response.keys, function(i, item) {
                        html_data += '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#object_key'+count).html(html_data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
        }

    </script>
@endsection


