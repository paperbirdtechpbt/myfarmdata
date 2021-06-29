@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Collect Data</li>
@endsection

@php

@endphp

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="{{route('collectdata.store')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Collect Data</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('collectdata')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="row_div">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Select Pack</label>
                                <div class="col-md-6">
                                    <select class="form-control select" name="pack_id" id="pack_id">
                                        <option value="">select</option>
                                        @foreach($pack as $pack_data)
                                            <option value="{{$pack_data->id}}">{{$pack_data->id.'_'.$pack_data->species.'_'.$pack_data->creation_date}}</option>
                                        @endforeach
                                        <!-- <option value="true">pack1</option>
                                        <option value="false">pack2</option> -->
                                    </select>
                                    {{csrf_field()}}
                                    <span class="help-block">This field is required</span>
                                </div>
                            </div>
                            <div class="col-md-12" id="result_div0">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Result</button></span>
                                                <select class="form-control result_id" name="result_id0" id="result_id0" onchange="getvaluetype(0, this.value)">
                                                    <option value="">select</option>
                                                </select>
                                            </div>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group" id="input_group_value0">
                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span>
                                                <input type="text" class="form-control" name="value0" id="value0" value="">
                                            </div>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Units</button></span>
                                                <select class="form-control" name="unit_id0" id="unit_id0">
                                                    <option value="">select</option>
                                                </select>
                                            </div>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Sensor</button></span>
                                                <select class="form-control select" name="sensor_id0" id="sensor_id0">
                                                    <option value="">select</option>
                                                    @foreach($sensor as $key=>$value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                    <!-- <option value="true">sensor1</option>
                                                    <option value="false">sensor2</option> -->
                                                </select>
                                            </div>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                         <div class="col-md-2">
                                            <div class="input-group" >
                                                <span class="input-group-btn"><button class="btn btn-default" type="button">Duration</button></span>
                                                <input type="number" class="form-control" name="duration0" id="duration0" value="">
                                            </div>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <input type="hidden" value="1" id="deleted0" name="deleted0">
                                    <button class="btn btn-default" type="button" onclick="add_row()"><i class="fa fa-pencil"></i> Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="result_count" id="result_count" value="1">
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
    var html_data = '<option value="">select</option>';
    function add_row() {
        var html_data1 = '';
        html_data1 += '<div class="col-md-12" id="result_div'+count+'"><div class="col-md-11"><div class="form-group">';
        html_data1 += '<div class="col-md-3"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Result</button></span><select class="form-control result_id" name="result_id'+count+'" id="result_id'+count+'" onchange="getvaluetype('+count+', this.value)">'+html_data+'</select></div><span class="help-block">This field is required</span></div>';
        html_data1 += '<div class="col-md-3"><div class="input-group" id="input_group_value'+count+'"><span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control" name="value'+count+'" id="value'+count+'" value=""></div><span class="help-block">This field is required</span></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Units</button></span><select class="form-control select" name="unit_id'+count+'" id="unit_id'+count+'"><option value="">select</option>@foreach($unit as $key=>$value)<option value="{{$key}}">{{$value}}</option>@endforeach</select></div><span class="help-block">This field is required</span></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Sensor</button></span><select class="form-control select" name="sensor_id'+count+'" id="sensor_id'+count+'"><option value="">select</option>@foreach($sensor as $key=>$value)<option value="{{$key}}">{{$value}}</option>@endforeach</select></div><span class="help-block">This field is required</span></div>';
        html_data1 += '<div class="col-md-2"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default" type="button">Duration</button></span><input type="number" class="form-control" name="duration'+count+'" id="duration'+count+'" value=""></div><span class="help-block">This field is required</span></div>';
        
        html_data1 += '</div></div><div class="col-md-1"><input type="hidden" value="0" id="deleted'+count+'" name="deleted'+count+'"><button class="btn btn-default" type="button" onclick="delete_row('+count+')"><i class="fa fa-times"></i> Remove</button></div></div>';
        $('#row_div').append(html_data1);
        $('#result_count').val(count);
        count++;
    }
    function delete_row(count) {
        $('#result_div'+count).hide();
        $('#deleted'+count).val(1);
    }
    $( "#pack_id" ).change(function() {
        // alert( this.value );
        var token = $('#_token').val();
        $.ajax({
            url: '/getpackresult',
            data: {pack_id:this.value, _token:token},
            type: 'POST',
            success: function(data) {
                // alert(data);
                // $('body').html(data);
                var response = JSON.parse(data);
                html_data = '<option value="">select</option>';
                for(var i = 0; i < response.length; i++){
                    html_data += '<option value="'+response[i].id+'">'+response[i].result_name+'</option>';
                }
                $('.result_id').html(html_data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('error : '+xhr.responseText);
                alert('something bad happened');
            }
        });
    });
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            pack_id: {
                required: true,
            },
        }
    });
    function getvaluetype(count, result_id){
        // alert(count);
        // alert(result_id);
        var token = $('#_token').val();
        $.ajax({
            url: '/getvaluetype',
            data: {result_id:result_id, _token:token},
            type: 'POST',
            success: function(data) {
                console.log(data);
               
                $('#value'+count).val('');
                var datatype = data.value_datatype[0].type_id;
                var html_data = '<option value="">Select</option>';
                if(datatype == 'text'){
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control" name="value'+count+'" id="value'+count+'" value="">');
                }
                else if(datatype == 'numeric'){
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control number" name="value'+count+'" id="value'+count+'" value="">');
                    $('.number').bind('keypress',function(e){
                        return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
                    });
                }
                else if(datatype == 'date'){
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control datepicker" name="value'+count+'" id="value'+count+'" value="">');
                    if($(".datepicker").length > 0){
                        $(".datepicker").datepicker({format: 'yyyy-mm-dd'});
                    }
                }
                else if(datatype == 'list'){
                    
                    var html_data = '<option value="">select</option>';
                    if(data.list != null){
                        for(var i = 0; i < data.list.choices.length; i++){
                            html_data += '<option value="'+data.list.choices[i].id+'">'+data.list.choices[i].name+'</option>';
                        }  
                    }
                    
                    
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><select class="form-control select" name="value'+count+'" id="value'+count+'" value="">'+html_data+'</select>');
                    
                }
                else{
                    $('#input_group_value'+count).html('<span class="input-group-btn"><button class="btn btn-default" type="button">Value</button></span><input type="text" class="form-control" name="value'+count+'" id="value'+count+'" value="">');
                    alert('no data type is selected for this result value');
                }
                html_data = '';
                for(var i=0; i<data.unit_list.length; i++)
                {
                    html_data+= '<option value="'+data.unit_list[i].id+'">'+data.unit_list[i].name+'</option>';
                }
                $('#unit_id'+count).html(html_data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('error : '+xhr.responseText);
                alert('something bad happened');
            }
        });
    }
    // $('.number').bind('keypress',function(e){
    //     return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
    // });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
