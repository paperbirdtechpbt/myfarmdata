@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Dashboard Settings</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/dashboardsetting">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Dashboard Settings</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('role')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="dashboard_row" >
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" >
                                            {{csrf_field()}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="title" id="title" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="community_group" id="community_group">
                                                <option value="">Select</option>
                                                @foreach($communitygrp as $community)
                                                <option value="{{$community->id}}">{{$community->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Max Number</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="max_number" id="max_number">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12" id="dashboard_div0" style="margin-top:20px;">
                                
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Object Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_class[]" id="object_class0" onChange="getKey(this.value,0);">
                                                <option value="">Select</option>
                                                @foreach($chart_list as $graphchart)
                                                <option value="{{$graphchart->id}}">{{$graphchart->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Object Key</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_key[]" id="object_key0">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button1 class="btn btn-default" onclick="add_row(0)"  style="float: right;"><i class="fa fa-pencil" ></i>Add Object</button1>
                                        </div>
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
    var count = 1;
    function add_row(count1) {
        
        var html_data = '<div class="col-md-12" id="dashboard_div'+count+'" style="margin-top:20px;">';
            html_data += '<div class="col-md-5"><div class="form-group"><label class="col-md-3 control-label">Object Class</label><div class="col-md-9"><select class="form-control" name="object_class[]" id="object_class'+count+'" onChange="getKey(this.value,'+count+');"><option value="">select</option>@foreach($chart_list as $graphchart)<option value="{{$graphchart->id}}">{{$graphchart->name}}</option>@endforeach</select></div></div></div>';
            html_data += '<div class="col-md-5"><div class="form-group"><label class="col-md-3 control-label">Object Key</label><div class="col-md-9"><select class="form-control" name="object_key[]" id="object_key'+count+'"><option value="">Select</option></select></div></div></div>';
            html_data += '<div class="col-md-2"><div class="form-group"><div class="col-md-12"><button1 class="btn btn-default" onclick="delete_row('+count+')" style="float: right;">Remove</button1></div></div></div>';
            html_data += '</div>';
            
            $('#dashboard_row').append(html_data);
       
        count++;
     return false;
    }
    function delete_row(count) {
         $('#dashboard_div'+count).remove();
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
                success: function(data) {
                    var response = JSON.parse(data);
                    var html_data = '<option>Select</option>';
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


