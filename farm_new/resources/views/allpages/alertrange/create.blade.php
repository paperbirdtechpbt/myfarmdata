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
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                    {{csrf_field()}}
                                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>Community Group</label>
                                    <select class="form-control select" name="communitygroup" id="communitygroup">
                                        <option value="">select</option>
                                        @foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="alert_range_div0" style="margin-top:20px;">
                                <div class="col-md-2">
                                    <label>Collect Activity</label>
                                    <select class="form-control select" name="collect_activity_id[]" id="collect_activity_id0" onChange="getResult(this.value,0);">
                                        <option>Select</option>
                                        @foreach($activities as $activity)<option value="{{$activity->id}}">{{$activity->name}}</option>@endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Result</label>
                                    <select class="form-control select" name="result_id[]" id="result_id0">
                                        <option>Select</option>
                                        <!--@foreach($results as $result)<option value="{{$result->id}}">{{$result->result_name}}</option>@endforeach-->
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label>Min Value</label>
                                    <input type="number" class="form-control" name="min_value[]" id="min_value0" placeholder="" value="{{old('min_value')}}">
                                </div>
                                <div class="col-md-1">
                                    <label>Max Value</label>
                                    <input type="number" class="form-control" name="max_value[]" id="max_value0" placeholder="" value="{{old('max_value')}}">
                                </div>
                                <div class="col-md-1">
                                    <label>Duration Min</label>
                                    <input type="number" class="form-control" name="duration_min_value[]" id="duration_min_value0" placeholder="" value="{{old('duration_min_value')}}">
                                </div>
                                <div class="col-md-1">
                                    <label>Duration Max</label>
                                    <input type="number" class="form-control" name="duration_max_value[]" id="duration_max_value0" placeholder="" value="{{old('duration_max_value')}}">
                                </div>
                                <div class="col-md-1">
                                    <label>Notif. Level</label>
                                    <select class="form-control select" name="notif_level[]" id="notif_level0">
                                        <option>Select</option>
                                        @foreach($notiflevel as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label>Notif. Msg</label>
                                    <input type="text" class="form-control" name="notif_message[]" id="notif_message0" placeholder="" value="{{old('notif_message')}}">
                                </div>
                                <div class="col-md-1">
                                    <label>Alert Type</label>
                                    <select class="form-control select" name="alert_type[]" id="alert_type0">
                                        <option>Select</option>
                                        @foreach($alerttype as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button1 class="btn btn-default" onclick="add_row()" style="margin-top: 22px;">Add</button1>
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
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

@endsection

@section('javascript')
    <script>
    function getResult(id,count){
        var token = $('#_token').val();
            $.ajax({
                url: '/getResultByCollectActivity',
                data: {'collect_activity':id, _token:token },
                type: 'POST',
                success: function(data) {
                    var response = JSON.parse(data);
                    var html_data = '<option>Select</option>';
                    $.each(response.results, function(i, item) {
                        html_data += '<option value="'+item.id+'">'+item.result_name+'</option>';
                    });
                    $('#result_id'+count).html(html_data);
                    $('#result_id'+count).selectpicker('refresh');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
        }
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
        // html_data += '<div class="col-md-12" id="alert_range_div'+count+'" style="margin-top:20px;"><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        // html_data += '<select class="form-control select" name="collect_activity_id[]" id="collect_activity_id'+count+'"><option>Select Collect Activity</option>@foreach($activities as $activity)<option value="{{$activity->id}}">{{$activity->name}}</option>@endforeach</select></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        // html_data += '<select class="form-control select" name="result_id[]" id="result_id'+count+'"><option>Select Result</option>@foreach($results as $result)<option value="{{$result->id}}">{{$result->result_name}}</option>@endforeach</select></div></div></div><div class="col-md-1"><div class="form-group"><div class="col-md-12">';
        // html_data += '<input type="text" class="form-control" name="min_value[]" id="min_value'+count+'" placeholder="Min Value" value="{{old('min_value')}}"></div></div></div><div class="col-md-1"><div class="form-group"><div class="col-md-12">';
        // html_data += '<input type="text" class="form-control" name="max_value[]" id="max_value'+count+'" placeholder="Max Value" value="{{old('max_value')}}"></div></div></div><div class="col-md-1"><div class="form-group"><div class="col-md-12">';
        // html_data += '<input type="text" class="form-control" name="notif_level[]" id="notif_level'+count+'" placeholder="Notif. Level" value="{{old('notif_level')}}"></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        // html_data += '<input type="text" class="form-control" name="notif_message[]" id="notif_message'+count+'" placeholder="Notif. Message" value="{{old('notif_message')}}"></div></div></div><div class="col-md-2"><div class="form-group"><div class="col-md-12">';
        // html_data += '<select class="form-control select" name="alert_type[]" id="alert_type'+count+'"><option value="TYPE001">TYPE001</option></select></div></div></div><div class="col-md-1">';
        // html_data += '<button1 class="btn btn-default" onclick="delete_row('+count+')">Remove</button1></div></div>';
        
        html_data += '<div class="col-md-12" id="alert_range_div'+count+'" style="margin-top:20px;"><div class="col-md-2">';
        html_data += '<label>Collect Activity</label><select class="form-control select" name="collect_activity_id[]" id="collect_activity_id'+count+'"  onChange="getResult(this.value,'+count+');"><option>Select</option>@foreach($activities as $activity)<option value="{{$activity->id}}">{{$activity->name}}</option>@endforeach</select></div><div class="col-md-2">';
        // html_data += '<label>Result</label><select class="form-control select" name="result_id[]" id="result_id'+count+'"><option>Select</option>@foreach($results as $result)<option value="{{$result->id}}">{{$result->result_name}}</option>@endforeach</select></div><div class="col-md-1">';
        html_data += '<label>Result</label><select class="form-control select" name="result_id[]" id="result_id'+count+'"><option value="">Select</option></select></div><div class="col-md-1">';
        html_data += '<label>Min Value</label><input type="number" class="form-control" name="min_value[]" id="min_value'+count+'" placeholder="" value="{{old('min_value')}}"></div><div class="col-md-1">';
        html_data += '<label>Max Value</label><input type="number" class="form-control" name="max_value[]" id="max_value'+count+'" placeholder="" value="{{old('max_value')}}"></div><div class="col-md-1">';
        html_data += '<label>Duration Min</label><input type="number" class="form-control" name="duration_min_value[]" id="duration_min_value'+count+'" placeholder="" value="{{old('duration_min_value')}}"></div><div class="col-md-1">';
        html_data += '<label>Duration Max</label><input type="number" class="form-control" name="duration_max_value[]" id="duration_max_value'+count+'" placeholder="" value="{{old('duration_max_value')}}"></div><div class="col-md-1">';
        
        html_data += '<label>Notif. Level</label><select class="form-control select" name="notif_level[]" id="notif_level'+count+'"><option>Select</option>@foreach($notiflevel as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div><div class="col-md-1">';
        html_data += '<label>Notif. Msg</label><input type="text" class="form-control" name="notif_message[]" id="notif_message'+count+'" placeholder="" value="{{old('notif_message')}}"></div><div class="col-md-1">';
        html_data += '<label>Alert Type</label><select class="form-control select" name="alert_type[]" id="alert_type'+count+'"><option>Select</option>@foreach($alerttype as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div><div class="col-md-1">';
        html_data += '<button1 class="btn btn-default" onclick="delete_row('+count+')" style="margin-top: 22px;">Remove</button1></div></div>';
        $('#alert_range_row').append(html_data);
        $('#collect_activity_id'+count).selectpicker();
        $('#result_id'+count).selectpicker();
        $('#notif_level'+count).selectpicker();
        $('#alert_type'+count).selectpicker();
        count++;
    }
    
    function delete_row(count) {
        $('#alert_range_div'+count).remove();
    }

    
    </script>
@endsection
