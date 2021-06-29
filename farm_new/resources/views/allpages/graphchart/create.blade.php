@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Graph and Chart </li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post"   action="/graphchart">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Graph and Chart</h3>
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
                                        <label class="col-md-3 control-label">Abcissa Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="abcissa_title" id="abcissa_title" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Ordinate Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="ordinate_title" id="ordinate_title" >
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
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Object Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_class" id="object_class">
                                                <option value="">Select</option>
                                                @foreach($chart_list as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                </div>
                                
                            </div>
                            <div class="col-md-12" id="dashboard_div0" style="margin-top:30px;">
                                
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
                                            <input type="text" class="form-control" name="gc_name[]" id="gc_name0">
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Line Type</label>
                                        <div class="col-md-12">
                                            <!--<input type="text" class="form-control" name="line_type[]" id="line_type0">-->
                                            <select class="form-control" name="line_type[]" id="line_type0" onChange="setResult(0,this.value);">
                                                <option value="">Select</option>
                                                @foreach($object_class_list as $value)
                                                <option value="{{$value->name}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Result Class</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="result_class[]" id="result_class0">
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Points</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="points[]" id="points0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <button1 class="btn btn-default" onclick="add_row(0)"  style="float: right;"><i class="fa fa-pencil" ></i>Add Graph Line</button1>
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

@endsection
@section('javascript')
    <script>
    var count = 1;
    function add_row(count1) {
        
        var html_data = '<div class="col-md-12" id="dashboard_div'+count+'" style="margin-top:20px;">';
            // html_data += '<div class="col-md-5"><div class="form-group"><label class="col-md-3 control-label">Object Class</label><div class="col-md-9"><select class="form-control" name="object_class'+count+'" id="object_class'+count+'"><option value="">select</option><option value="Line Chart">Line Chart</option><option value="Bar Chart">Bar Chart</option><option value="Pie Chart Histogram">Pie Chart Histogram</option><option value="Table Displayed">Table Displayed</option></select></div></div></div>';
            html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Name</label><div class="col-md-12"><input type="text" class="form-control" name="gc_name[]" id="gc_name'+count+'"></div></div></div>';
            // html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Line Type</label><div class="col-md-12"><input type="text" class="form-control" name="line_type[]" id="line_type'+count+'"></div></div></div>';
            html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Line Type</label><div class="col-md-12"><select class="form-control" name="line_type[]" id="line_type'+count+'" onChange="setResult('+count+',this.value)"><option value="">Select</option>@foreach($object_class_list as $value)<option value="{{$value->name}}">{{$value->name}}</option>@endforeach</select></div></div></div>';
            html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Result Class</label><div class="col-md-12"><input type="text" class="form-control" name="result_class[]" id="result_class'+count+'"></div></div></div>';
            html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Points</label><div class="col-md-12"><input type="text" class="form-control" name="points[]" id="points'+count+'"></div></div></div>';
            html_data += '<div class="col-md-2"><div class="form-group"><div class="col-md-12" style="margin-top: 15px;"><button1 class="btn btn-default" onclick="delete_row('+count+')" style="float: right;">Remove</button1></div></div></div>';
            html_data += '</div>';
            
            $('#dashboard_row').append(html_data);
       
        count++;
     return false;
    }
    function delete_row(count) {
         $('#dashboard_div'+count).remove();
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
            object_class: {
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


