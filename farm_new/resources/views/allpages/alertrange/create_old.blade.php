@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Alert Range</li>
@endsection

@php

@endphp

@section('maincontent')

    <style>
        #team_person_div .col-md-6{ margin-top:10px; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" enctype="multipart/form-data" action="/alertrange">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Alert Range</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('alertrange')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="alert_range_row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                            {{csrf_field()}}
                                            @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="alert_range_div0" style="margin-top:20px;">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <select class="form-control select" name="collect_activity_id[]" id="collect_activity_id0">
                                                <option>Select Collect Activity</option>
                                                @foreach($activities as $activity)<option value="{{$activity->id}}">{{$activity->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <select class="form-control select" name="result_id[]" id="result_id0">
                                                <option>Select Result</option>
                                                @foreach($results as $result)<option value="{{$result->id}}">{{$result->result_name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="min_value[]" id="min_value0" placeholder="Min Value" value="{{old('min_value')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="max_value[]" id="max_value0" placeholder="Max Value" value="{{old('max_value')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="notif_level[]" id="notif_level0" placeholder="Notif. Level" value="{{old('notif_level')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="notif_message[]" id="notif_message0" placeholder="Notif. Message" value="{{old('notif_message')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <select class="form-control select" name="alert_type[]" id="alert_type0">
                                                <!--<option>Select Alert Type</option>-->
                                                <option value="TYPE001">TYPE001</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button1 class="btn btn-default" onclick="add_row()">Add</button1>
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
            name: { required: true },
            description: { required: true },
        }
    });
    
    var count = 1;
    
    function add_row() {
        var html_data = '';
        html_data += '<div class="col-md-12" id="alert_range_div'+count+'" style="margin-top:20px;"><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        html_data += '<select class="form-control select" name="collect_activity_id[]" id="collect_activity_id'+count+'"><option>Select Collect Activity</option>@foreach($activities as $activity)<option value="{{$activity->id}}">{{$activity->name}}</option>@endforeach</select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        html_data += '<select class="form-control select" name="result_id[]" id="result_id'+count+'"><option>Select Result</option>@foreach($results as $result)<option value="{{$result->id}}">{{$result->result_name}}</option>@endforeach</select></div></div></div><div class="col-md-1"><div class="form-group"><div class="col-md-12">';
        html_data += '<input type="text" class="form-control" name="min_value[]" id="min_value'+count+'" placeholder="Min Value" value="{{old('min_value')}}"></div></div></div><div class="col-md-1"><div class="form-group"><div class="col-md-12">';
        html_data += '<input type="text" class="form-control" name="max_value[]" id="max_value'+count+'" placeholder="Max Value" value="{{old('max_value')}}"></div></div></div><div class="col-md-1"><div class="form-group"><div class="col-md-12">';
        html_data += '<input type="text" class="form-control" name="notif_level[]" id="notif_level'+count+'" placeholder="Notif. Level" value="{{old('notif_level')}}"></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        html_data += '<input type="text" class="form-control" name="notif_message[]" id="notif_message'+count+'" placeholder="Notif. Message" value="{{old('notif_message')}}"></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        html_data += '<select class="form-control select" name="alert_type[]" id="alert_type'+count+'"><option value="TYPE001">TYPE001</option></select></div></div></div><div class="col-md-1">';
        html_data += '<button1 class="btn btn-default" onclick="delete_row('+count+')">Remove</button1></div></div>';
        $('#alert_range_row').append(html_data);
        count++;
    }
    
    function delete_row(count) {
        $('#alert_range_div'+count).remove();
    }

    $('#name').val('testname');
    $('#description').val('test description');
    </script>
@endsection
