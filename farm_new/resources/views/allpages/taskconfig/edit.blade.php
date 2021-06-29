@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Task Config</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post"  action="/taskconfig/{{$taskconfig->id}}">
                {{csrf_field()}}
                @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Task Config</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('taskconfig')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="dashboard_row" >
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control nospecialcharater" name="name" id="name" value="{{$taskconfig->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Type</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="type" id="type">
                                                <option value="">Select</option>
                                                @foreach($type_list as $value)
                                                <option value="{{$value->id}}" @if($taskconfig->type == $value->id) selected @endif >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Record Event</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="record_event" id="record_event">
                                                <option value="1" @if($taskconfig->record_event == 1) selected @endif >T</option>
                                                <option value="0" @if($taskconfig->record_event == 0) selected @endif >F</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="community_group" id="community_group">
                                                <option value="">Select</option>
                                                @foreach($communitygrp as $community)
                                                <option value="{{$community->id}}" @if($taskconfig->com_group == $community->id) selected @endif >{{$community->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{$taskconfig->description}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="class" id="class">
                                                <option value="">Select</option>
                                                @foreach($class_list as $value)
                                                <option value="{{$value->id}}" @if($taskconfig->class == $value->id) selected @endif  >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name Prefix</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control nospecialcharater" name="name_prefix" id="name_prefix" value="{{$taskconfig->name_prefix}}">
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="col-md-12" style="margin-top:20px;"><hr/><h3>Task Config Fields</h3></div>
                                <div class="col-md-12" id="task_field_div">
                                    @foreach($taskconfigfields as $taskconfigfield)
                                    <div class="col-md-12" id="task_field{{$loop->index}}">
                                    <div class="form-group">
                                        
                                        <div class="col-md-2">
                                            <label>Field Name</label>
                                            <select class="form-control" name="field_name[]" id="field_name{{$loop->index}}">
                                                <option value="">Select</option>
                                                @foreach($field_list as $value)
                                                <option value="{{$value->id}}" @if($value->id == $taskconfigfield->field_name) selected @endif >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--<input type="text" class="form-control" name="field_name[]" id="field_name{{$loop->index}}" value="{{$taskconfigfield->field_name}}">-->
                                        </div>
                                        <div class="col-md-2">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="field_description[]" id="field_description{{$loop->index}}" value="{{$taskconfigfield->field_description}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Editable</label>
                                            <select class="form-control" name="editable[]" id="editable{{$loop->index}}">
                                                <option value="1" @if($taskconfigfield->editable == 1) selected @endif >T</option>
                                                <option value="0" @if($taskconfigfield->editable == 0) selected @endif >F</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label>Field Type</label>
                                            <select class="form-control" name="field_type[]" id="field_type0" onchange="setList(this.value,{{$loop->index}});">
                                                <option value="">Select</option>
                                                <!--<option value="text" @if($taskconfigfield->field_type == "text") selected @endif >Text</option>-->
                                                <!--<option value="numeric" @if($taskconfigfield->field_type == "numeric") selected @endif >Numeric</option>-->
                                                <!--<option value="date" @if($taskconfigfield->field_type == "date") selected @endif >Date</option>-->
                                                <!--<option value="list" @if($taskconfigfield->field_type == "list") selected @endif >List</option>  -->
                                                <!--<option value="multilist" @if($taskconfigfield->field_type == "multilist") selected @endif >Multiple select List</option>-->
                                                
                                                @foreach($fieldtype_list as $value)
                                                <option value="{{$value->name}}"  @if($taskconfigfield->field_type == $value->name) selected @endif  >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2" id="list_div{{$loop->index}}">
                                            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="col-md-12">
                                                <input type="hidden" name="field_delete[]" id="field_delete{{$loop->index}}">
                                                <input type="hidden" name="field_id[]" id="field_id{{$loop->index}}" value="{{$taskconfigfield->id}}">
                                                @if($loop->index > 0)
                                                    <button1 class="btn btn-default" onclick="delete_field({{$loop->index}})" style="float: right;margin-top:22px;">Remove</button1>
                                                @else
                                                   <button1 class="btn btn-default" onclick="add_field({{$loop->index}})"  style="float: right;margin-top:20px;"><i class="fa fa-pencil" ></i>Add Field</button1> 
                                                @endif
                                            </div>
                                        </div>
                                   
                                    </div>
                                                           
                                </div>
                                    @endforeach 
                            </div>
                            
                            
                            <div class="col-md-12" style="margin-top:20px;"><hr/><h3>Task Config Functions</h3></div>
                            <div class="col-md-12" id="task_function_div">
                                
                                @foreach($taskconfigfunctions as $taskconfigfunction)
                                <div class="col-md-12" id="task_function{{$loop->index}}">
                                    <div class="form-group">
                                        
                                        <div class="col-md-4">
                                            <label>Function Name</label>
                                            <select class="form-control" name="function_name[]" id="function_name{{$loop->index}}">
                                                <option value="">Select</option>
                                                @foreach($function_list as $value)
                                                <option value="{{$value->id}}"@if($value->id == $taskconfigfunction->name) selected @endif >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            <!--<input type="text" class="form-control" name="function_name[]" id="function_name{{$loop->index}}"  value="{{$taskconfigfunction->name}}">-->
                                        </div>
                                        <div class="col-md-4">
                                            <label>Description</label>
                                            <input type="text" class="form-control" name="function_description[]" id="function_description{{$loop->index}}"  value="{{$taskconfigfunction->description}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Privileges</label>
                                            <select class="form-control" name="privilege[]" id="privilege{{$loop->index}}">
                                                <option value="">Select</option>
                                                @foreach($privileges as $value)
                                                <option value="{{$value->id}}" @if($taskconfigfunction->privilege == $value->id) selected @endif  >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="col-md-12">
                                                <input type="hidden" name="function_delete[]" id="function_delete{{$loop->index}}">
                                                <input type="hidden" name="function_id[]" id="function_id{{$loop->index}}" value="{{$taskconfigfunction->id}}">
                                                @if($loop->index > 0)
                                                    <button1 class="btn btn-default" onclick="delete_function({{$loop->index}})" style="float: right;margin-top:22px;">Remove</button1>
                                                @else
                                                   <button1 class="btn btn-default" onclick="add_function({{$loop->index}})"  style="float: right;margin-top:20px;"><i class="fa fa-pencil" ></i>Add Function</button1> 
                                                @endif
                                            </div>
                                        </div>
                                   
                                    </div>
                                                           
                                </div>
                                @endforeach
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
    $(function () {
        @foreach($taskconfigfields as $taskconfigfield)
        
            setList('{{$taskconfigfield->field_type}}',{{$loop->index}});
            
            if('{{$taskconfigfield->field_type}}' == 'List' || '{{$taskconfigfield->field_type}}' == 'Multilist'){
                $('#list{{$loop->index}}').val({{$taskconfigfield->list}}); 
            }
            if('{{$taskconfigfield->field_type}}' == 'Table'){
                $('#list{{$loop->index}}').val('{{$taskconfigfield->list}}'); 
            }
           
        @endforeach
    });
    
    var count_field = {{count($taskconfigfields)}};
    var count_function = {{count($taskconfigfunctions)}};
    
    function add_field(count1) {
        
        var html_data = '<div class="col-md-12" id="task_field'+count_field+'"><div class="form-group">';
            // html_data += '<div class="col-md-2"><label>Field Name</label><input type="text" class="form-control" name="field_name[]" id="field_name'+count_field+'"></div>';
            html_data += '<div class="col-md-2"><label>Field Name</label><select class="form-control" name="field_name[]" id="field_name'+count_field+'"><option value="">Select</option>@foreach($field_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div>';
            html_data += '<div class="col-md-2"><label>Description</label><input type="text" class="form-control" name="field_description[]" id="field_description'+count_field+'" ></div>';
            html_data += '<div class="col-md-2"><label>Editable</label><select class="form-control" name="editable[]" id="editable'+count_field+'"><option value="1">T</option><option value="0">F</option></select></div>';
            // html_data += '<div class="col-md-2 "><label>Field Type</label><select class="form-control" name="field_type[]" id="field_type'+count_field+'" onchange="setList(this.value,'+count_field+');"><option value="">Select</option>@foreach($fieldtype_list as $value) <option value="{{$value->name}}">{{$value->name}}</option>@endforeach</select></div>';
            html_data += '<div class="col-md-2 "><label>Field Type</label><select class="form-control" name="field_type[]" id="field_type'+count_field+'" onchange="setList(this.value,'+count_field+');"><option value="">Select</option>@foreach($fieldtype_list as $value) <option value="{{$value->name}}">{{$value->name}}</option>@endforeach</select></div>';
            html_data += '<div class="col-md-2" id="list_div'+count_field+'"></div>';
            html_data += '<div class="col-md-2"><input type="hidden" name="field_delete[]" id="field_delete'+count_field+'"><input type="hidden" name="field_id[]" id="field_id'+count_field+'" value="0"><div class="col-md-12"><button1 class="btn btn-default" onclick="delete_field('+count_field+')" style="float: right;margin-top:22px;">Remove</button1></div></div>';
            html_data += '</div></div>';
            
            $('#task_field_div').append(html_data);
        count_field++;
        return false;
    }
    function delete_field(count) {
        //  $('#task_field'+count).remove();
        
        $('#task_field'+count).hide();
        $('#field_delete'+count).val('deleted_data');
    }
    
    function add_function(count1) {
        
        var html_data = '<div class="col-md-12" id="task_function'+count_function+'"><div class="form-group">';
            // html_data += '<div class="col-md-4">Name</label><input type="text" class="form-control" name="function_name[]" id="function_name'+count_function+'"></div>';
            html_data += '<div class="col-md-4">Name</label><select class="form-control" name="function_name[]" id="function_name'+count_function+'"><option value="">Select</option>@foreach($function_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div>';
            html_data += '<div class="col-md-4"><label>Description</label><input type="text" class="form-control" name="function_description[]" id="function_description'+count_function+'" ></div>';
            html_data += '<div class="col-md-2"><label>Privileges</label><select class="form-control" name="privilege[]" id="privilege'+count_function+'"><option value="">Select</option>@foreach($privileges as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div>';
            html_data += '<div class="col-md-2"><div class="col-md-12"><input type="hidden" name="function_delete[]" id="function_delete'+count_function+'"><input type="hidden" name="function_id[]" id="function_id'+count_function+'" value="0"><button1 class="btn btn-default" onclick="delete_function('+count_function+')" style="float: right;margin-top:22px;">Remove</button1></div></div>';
            html_data += '</div></div>';
            
            $('#task_function_div').append(html_data);
        count_function++;
        return false;
    }
    function delete_function(count) {
        //  $('#task_function'+count).remove();
        
        $('#task_function'+count).hide();
        $('#function_delete'+count).val('deleted_data');
    }
    
    // $.validator.addMethod("verifyTaskConfig",
    //     function(value, element) {
    //         var token = $('#_token').val();
    //         var result = false;
    //         $.ajax({
    //             type:"POST",
    //             async: false,
    //             url: '/checkunquietaskconfig', // script to validate in server side
    //             data: {"name": value, _token:token},
    //             success: function(data) {
    //                 result = (data == true) ? true : false;
    //             }
    //         });
    //         // return true if username is exist in database
    //         return result;
    //         alert("RESULT "+result);
    //     },
    //     "Utente già in uso!"
    // );
    
    $.validator.addMethod("checkUserName", 
        function(value, element) {
            var token = $('#_token').val();
            var result = false;
            $.ajax({
                type:"POST",
                async: false,
                url: '/checkunique', // script to validate in server side
                data: {'name': value, _token:token,'page':'taskconfig','id':{{$taskconfig->id}}},
                success: function(data) {
                    console.log(data);
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
            description: {
                required: true,
            },
            type: {
                required: true,
            },
            class: {
                required: true,
            },
            community_group: {
                required: true,
            },
           
            "field_name[]": {
                required: true
            },
            "field_type[]": {
                required: true
            },
            "list[]": {
                required: true
            },
            "function_name[]": {
                required: true
            },
            "privilege[]": {
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
    
    function setList(value,count){
       
        var htmldata = '';
        if(value == 'List' || value == 'Multilist'){
            htmldata += '<label>List</label>';
            htmldata += '<select class="form-control" name="list[]" id="list'+count+'">';
            htmldata += '<option value="">Select</option>@foreach($lists as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select>';
        }else if(value == 'Table'){
            htmldata += '<label>List</label>';
            htmldata += '<select class="form-control" name="list[]" id="list'+count+'">';
            htmldata += '<option value="">Select</option>';
            htmldata += '<option value="Field">Field</option>';
            htmldata += '<option value="Person">Person</option>';
            htmldata += '<option value="Team">Team</option>';
            htmldata += '</select>';
        }else{
            htmldata += '<input type="hidden" name="list[]" id="list'+count+'" value="N/A">';
        }
        $("#list_div"+count).html(htmldata);
    }
    
    $(function () {
        $(".nospecialcharater").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
            
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z0-9]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            
            return isValid;
        });
    });

    </script>
@endsection


