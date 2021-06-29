@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Graph and Chart </li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/graphchart/{{$graphchart->id}}">
                {{csrf_field()}}
                @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Graph and Chart</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('graphchart')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="dashboard_row" >
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$graphchart->name}}">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="title" id="title" value="{{$graphchart->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Abcissa Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="abcissa_title" id="abcissa_title" value="{{$graphchart->abcissa_title}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Ordinate Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="ordinate_title" id="ordinate_title" value="{{$graphchart->ordinate_title}}">
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{$graphchart->description}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="community_group" id="community_group">
                                                <option value="">Select</option>
                                                @foreach($communitygrp as $community)
                                                <option value="{{$community->id}}" @if($graphchart->com_group == $community->id) selected @endif>{{$community->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Object Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_class" id="object_class">
                                                <option value="">Select</option>
                                                @foreach($chart_list as $value)
                                                <option value="{{$value->id}}" @if($graphchart->object_class == $value->id) selected @endif>{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                </div>
                                
                            </div>
                            
                            @foreach($graphchartobjects as $graphchartobject)
                            <div class="col-md-12" id="dashboard_div{{$loop->index}}" style="margin-top:30px;">
                                
                                <!--<div class="col-md-5">-->
                                <!--    <div class="form-group">-->
                                <!--        <label class="col-md-3 control-label">Object Class</label>-->
                                <!--        <div class="col-md-9">-->
                                <!--            <select class="form-control" name="object_class0" id="object_class0">-->
                                <!--                <option value="">select</option>-->
                                <!--                <option value="Line Chart">Line Chart</option>-->
                                <!--                <option value="Bar Chart">Bar Chart</option>-->
                                <!--                <option value="Pie Chart Histogram">Pie Chart Histogram</option>-->
                                <!--                <option value="Table Displayed">Table Displayed</option>-->
                                <!--            </select>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="gc_name[]" id="gc_name{{$loop->index}}" value="{{$graphchartobject->name}}">
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Line Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="line_type[]" id="line_type{{$loop->index}}" onChange="setResult({{$loop->index}},this.value);">
                                                <option value="">Select</option>
                                                @foreach($object_class_list as $value)
                                                <option value="{{$value->name}}" @if($graphchartobject->line_type == $value->name) selected @endif>{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--<input type="text" class="form-control" name="line_type[]" id="line_type{{$loop->index}}" value="{{$graphchartobject->line_type}}">-->
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Result Class</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="result_class[]" id="result_class{{$loop->index}}" value="{{$graphchartobject->result_class}}" @if($graphchartobject->line_type == 'Ref_Control_Line') readonly @endif>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Points</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="points[]" id="points{{$loop->index}}" value="{{$graphchartobject->ref_ctrl_points}}" @if($graphchartobject->line_type == 'Result_Line') readonly @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <input type="hidden" name="gc_id[]" id="gc_id{{$loop->index}}" value="{{$graphchartobject->id}}">
                                            @if($loop->index > 0)
                                            <button1 class="btn btn-default" onclick="delete_row({{$loop->index}})" style="float: right;">Remove</button1>
                                            @else
                                            <button1 class="btn btn-default" onclick="add_row(0)"  style="float: right;"><i class="fa fa-pencil" ></i>Add Graph Line</button1>
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

@endsection
@section('javascript')
    <script>
    var count = {{count($graphchartobjects)}};
    function add_row(count1) {
        
        var html_data = '<div class="col-md-12" id="dashboard_div'+count+'" style="margin-top:20px;">';
            // html_data += '<div class="col-md-5"><div class="form-group"><label class="col-md-3 control-label">Object Class</label><div class="col-md-9"><select class="form-control" name="object_class'+count+'" id="object_class'+count+'"><option value="">select</option><option value="Line Chart">Line Chart</option><option value="Bar Chart">Bar Chart</option><option value="Pie Chart Histogram">Pie Chart Histogram</option><option value="Table Displayed">Table Displayed</option></select></div></div></div>';
            html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Name</label><div class="col-md-12"><input type="text" class="form-control" name="gc_name[]" id="gc_name'+count+'"></div></div></div>';
            // html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Line Type</label><div class="col-md-12"><input type="text" class="form-control" name="line_type[]" id="line_type'+count+'"></div></div></div>';
            html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Line Type</label><div class="col-md-12"><select class="form-control" name="line_type[]" id="line_type'+count+'" onChange="setResult('+count+',this.value)"><option value="">Select</option>@foreach($object_class_list as $value)<option value="{{$value->name}}">{{$value->name}}</option>@endforeach</select></div></div></div>';
             html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Result Class</label><div class="col-md-12"><input type="text" class="form-control" name="result_class[]" id="result_class'+count+'"></div></div></div>';
            html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Points</label><div class="col-md-12"><input type="text" class="form-control" name="points[]" id="points'+count+'"></div></div></div>';
            html_data += '<div class="col-md-2"><div class="form-group"><div class="col-md-12" style="margin-top: 15px;"><input type="hidden" name="gc_id[]" id="gc_id'+count+'" value="0"><button1 class="btn btn-default" onclick="delete_row('+count+')" style="float: right;">Remove</button1></div></div></div>';
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
    function setResult(count,val) {
       
        if(val == 'Result_Line'){
            $('#points'+count).val('N/A');
            $('#points'+count).attr('readonly', true);
            
            $('#result_class'+count).val('');
            $('#result_class'+count).attr('readonly', false);
            
        }else if(val == 'Ref_Control_Line'){
            $('#points'+count).val('');
            $('#points'+count).attr('readonly', false);
            
            $('#result_class'+count).val('N/A');
            $('#result_class'+count).attr('readonly', true);
        }
    }
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
            },
            title: {
                required: true,
            },
            abcissa_title: {
                required: true,
            },
            ordinate_title: {
                required: true,
            },
            description: {
                required: true,
            },
            community_group: {
                required: true,
            },
            "gc_name[]": "required",
            "line_type[]": "required",
            "result_class[]": "required",
            "points[]": "required",
        }
    });

    </script>
@endsection


