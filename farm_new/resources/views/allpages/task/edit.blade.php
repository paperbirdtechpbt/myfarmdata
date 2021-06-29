@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Task</li>
@endsection

@section('maincontent')
@php
    $user_priv = array();
    if (session()->has('user_priv')) {
        $user_priv = session()->get('user_priv');
    }
    $name = $task->name;
   
    if($name == ''){
        $name = 1;
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
            <form class="form-horizontal" id="add_form" method="post"  action="/task/{{$task->id}}">
                {{csrf_field()}}
                @method('PUT')
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Task</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('task')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    
                    <div class="panel-body">
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Name</label>
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="name" id="name" value="{{$name}}">
                                        <input type="text" class="form-control nospecialcharater" name="name1" id="name1" value="{{$taskconfig->name_prefix.sprintf('%04d', $name)}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Description</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="description" id="description" value="{{$task->description}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Config Type</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="config_type" id="config_type" onchange="getKey(this.value);" readonly>
                                            <option value="">Select</option>
                                            @foreach($taskconfigs as $value)
                                            <option value="{{$value->id}}" @if($task->task_config_id == $value->id) selected @else disabled @endif >{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">CommunityGrp</label>
                                    <div class="col-md-12">
                                        @if(in_array("CanOverideEditTask", array_column(json_decode($user_priv, true), 'privilege')))
                                        <select class="form-control" name="community_group" id="community_group" onchange="communityChangeData();">
                                        @else
                                        <select class="form-control" name="community_group" id="community_group" readonly>
                                        @endif
                                        
                                            <option value="">Select</option>
                                            @foreach($communitygrp as $community)
                                            @if(in_array("CanOverideEditTask", array_column(json_decode($user_priv, true), 'privilege')))
                                            <option value="{{$community->id}}" @if($task->com_group == $community->id) selected @endif >{{$community->name}}</option>
                                            @else
                                            <option value="{{$community->id}}" @if($task->com_group == $community->id) selected @else disabled @endif >{{$community->name}}</option>
                                            @endif
                                            
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                             
                        </div>
                        <div class="row col-md-12" id="dashboard_row"></div>
                        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="field_array" id="field_array" value="">
                        <input type="hidden" name="privilege_count" id="privilege_count" value="0">
                        <button1 class="btn btn-default" onClick="$('#add_form')[0].reset();">Clear Form</button1>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#taskFunModal">Task Functions</button>
                        <button id="editTask" class="btn btn-primary pull-right">Submit</button>
                    </div>

            </form>
            
            
        <div id="taskFunModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Task Function</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" >
                            <div class="alert" id="alert_div" role="alert">
                                <span id="alert_text"></span>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-12">Task Function</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="task_func" id="task_func" onchange="functionChangeData(this.value);">
                                            <option value="">Select</option>
                                            @foreach($function_list as $value)
                                            <option value="{{$value->id}}" @if($task->task_func == $value->id) selected @endif  >{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="container_add">
                                <div class="form-group">
                                    <label class="col-md-12">Container</label>
                                    <div class="col-md-12">
                                        @if(in_array("CanOverideEditTask", array_column(json_decode($user_priv, true), 'privilege')))
                                        <select class="form-control" name="container" id="container">
                                        @else
                                        <select class="form-control" name="container" id="container" readonly>
                                        @endif
                                        
                                            <option value="">Select</option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                             <div class="col-md-12" id="person_add">
                                <div class="form-group">
                                    <label class="col-md-12">Person</label>
                                    <div class="col-md-12">
                                        @if(in_array("CanOverideEditTask", array_column(json_decode($user_priv, true), 'privilege')))
                                        <select class="form-control" name="person" id="person">
                                        @else
                                        <select class="form-control" name="person" id="person" readonly>
                                        @endif
                                        
                                            <option value="">Select</option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" id="pack_add">
                                <div class="form-group">
                                    <label class="col-md-12">Pack</label>
                                    <div class="col-md-12">
                                        @if(in_array("CanOverideEditTask", array_column(json_decode($user_priv, true), 'privilege')))
                                        <select class="form-control" name="pack" id="packs">
                                        @else
                                        <select class="form-control" name="pack" id="packs" readonly>
                                        @endif
                                        
                                            <option value="">Select</option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" id="attach_media">
                                <div class="form-group">
                                    <label class="col-md-12">Attach Media</label>
                                    <div class="col-md-12">
                                       <input type="file" class="form-control" id="media_files" name="media_files[]" multiple accept="image/*,video/*">
                                    </div>
                                    <div class="col-md-12" id="attach_media_div">
                                       
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" id="display_div">
                                
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  onclick="taskExecuteFunction('t');" class="btn btn-primary pull-left" id="btn_execute">Execute</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
        
        
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Pack</h4>
                </div>
                <div class="modal-body">
                    <div class="alert" id="alertpack" role="alert">
                        <span id="alertpack_text"></span>
                    </div>
                    <form class="form-horizontal" id="create_pack">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Creation Date</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control datepicker" name="creation_date" id="creation_date" value="">
                                            {{csrf_field()}}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Quantity</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="quantity" id="quantity" value="">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Collect Activity</label>
                                        <div class="col-md-9">
                                            <!--<select multiple class="form-control select" name="collect_activity" id="collect_activity">-->
                                            <select multiple class="form-control select" name="collectactivityid" id="collectactivityid">
                                                @if(count($collectActivity) > 1)
                                                <!--<option>select</option>-->
                                                @endif
                                                @foreach($collectActivity as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                                <!-- <option value="1">FERMENTATION</option>
                                                <option value="2">DRYING</option> -->
                                            </select>
                                            
                                        </div>
                                        <!--<input type="hidden" name="collect_activity_id" id="collect_activity_id" value="0">-->
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description_task" id="description_task"></textarea>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Species</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="species" id="species" value="">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Units</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="unit_id" id="unit_id">
                                                @if(count($unit) > 1)
                                                <option value="">select</option>
                                                @endif
                                                @foreach($unit as $key=>$value)
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="com_group_id" id="com_group_id">
                                                <!--<option value="">select</option>-->
                                                @if(count($communityGroup[0]->communitygrp) > 1)
                                                <option value="">select</option>
                                                @endif
                                                @foreach($communityGroup as $value)
                                                    @foreach($value->communitygrp as $value1)
                                                    <option value="{{$value1->id}}">{{$value1->name}}</option>
                                                    @endforeach
                                                @endforeach
                                                <!-- <option value="1">grp1</option>
                                                <option value="2">grp2</option> -->
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Type</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_type" id="object_type">
                                                <option value="">select</option>
                                                @foreach($object_type as $value)<option value="{{$value->id}}"
                                               >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="object_class" id="object_class">
                                                <option value="">select</option>
                                                @foreach($object_class as $value)<option value="{{$value->id}}" 
                                               >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <input type="hidden" name="collect_activity_id" id="collect_activity_id" value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="create_pack_btn" class="btn btn-primary pull-left">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
           

</div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> Task Object </h3>
                &nbsp;&nbsp;&nbsp;
                <img src="{{asset('img/media.jpg')}}" title="View Media" style="width:30px;height:30px;cursor:pointer;" onclick="editTaskObject('ATTACH_MEDIA','');">
                <!--<button type="button" class="btn btn-secondary pull-right"  style="float:right;">View Media</button>-->
            </div>
            <div class="panel-body" id="table_taskobject">
            </div>
        </div>
    </div>      
          
</div>
<div id="loader"></div>  
@endsection


@section('javascript')

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
                data: {'name': value, _token:token,'page':'task','id':{{$task->id}}},
                success: function(data) {
                   result = (data == false) ? true : false;
                }
            });
            // return true if username is exist in database
            return result; 
        }, 
        "This name is already taken! Try another."
    );
    
    var jvalidate = $("#add_form").validate({
        ignore: ':not(select:hidden, input:visible, textarea:visible)',
        rules: {
            name: {
                required: true,
                // checkUserName: true
            },
            description: {
                required: true,
            },
            config_type: {
                required: true,
            },
            
            community_group: {
                required: true,
            },
        },
        errorPlacement: function (error, element) {
            if ($(element).is('select')) {
                element.next().after(error); 
            } else {
                error.insertAfter(element);
            }
        
        }
    });
    
    $("#editTask").click(function(){
       
        var ItemArray = [];
        $(".fieldArray").each(function() {
            ItemArray.push({
                f_id : $(this).parent().siblings('input').val(), 
                f_value : $(this).val()
            });
        });
        $("#field_array").val(JSON.stringify(ItemArray));
        
    });
    
    $("#create_pack_btn").click(function(){
        var packvalidate = $("#create_pack").validate({
        ignore: [],
        rules: {
            creation_date: {
                required: true,
            },
            quantity: {
                required: true,
            },
            collectactivityid: {
                required: true,
            },
            species: {
                required: true,
            },
            unit_id: {
                required: true,
            },
            com_group_id: {
                required: true,
            },
            object_type: {
                required: true,
            },
            object_class: {
                required: true,
            }
        }
    });
      
        if($("#create_pack").valid()){
            var dataserialize =  $("#create_pack").serialize()+'&task_id='+{{$task->id}};
            $.ajax({
                url: '/createPack',
                data: dataserialize,
                type: 'POST',
                success: function(data) {
                    
                     if(data.success == false){
                        $('#alertpack_text').text(data.message)
                        $('#alertpack').show();
                        $('#alertpack').removeClass('alert-success')
                        $('#alertpack').addClass('alert-danger')
                        
                        
                    }else{
                        $('#alertpack_text').text(data.message)
                        $('#alertpack').show();
                        $('#alertpack').removeClass('alert-danger');
                        $('#alertpack').addClass('alert-success');
                        getTaskObject();
                        $('#create_pack')[0].reset();
                        $('#collectactivityid').val('');
                        $('#collectactivityid').selectpicker('refresh');
                    }
                    setTimeout(function () {
                        $('#alertpack').hide();
                        $('#myModal').modal('hide');
                        $('#taskFunModal').modal('hide');
                    }, 2000);
                    
                    
                }
            }); 
         }
   });
   
    $( "#collectactivityid" ).change(function() {
        $('#collect_activity_id').val($( "#collectactivityid" ).val());
    });
    
    function setval(doc){
       $(doc).siblings().val($(doc).val());
    }
    
    function communityChangeData() {
        var task_func = $('#task_func').val();
        functionChangeData(task_func);
    }
    
    function getPackDetail(){
        $.ajax({
            url: '/getPack',
            data: { '_token': '{{ csrf_token() }}','task_id':{{$task->id}}},
            type: 'POST',
            success: function(data) {
                $("#creation_date").val(data.data.creation_date);
                $("#species").val(data.data.species);
                $("#quantity").val(data.data.quantity);
                $("#unit_id").val(data.data.unit_id);
                // $("#collectactivityid").val(data.data.collect_activity_id);
                $("#com_group_id").val(data.data.community_group_id);
                $("#description_task").html(data.data.description);
                $("#object_type").val(data.data.type);
                $("#object_class").val(data.data.class);
                
                var collect_activity_id = data.data.collect_activity_id;
                var act_array = collect_activity_id.split(',');
                $.each(act_array, function( index, value ) {
                    $('#collectactivityid option[value='+value+']').attr('selected', true);
                });
                $("#collect_activity_id").val(data.data.collect_activity_id);
                // $('select').selectpicker('refresh');
                $('#collectactivityid').selectpicker('refresh');
            }
        });
    }
    
    function functionChangeData(id) {
        $('#pack_add').hide();
        $('#container_add').hide();
        $('#person_add').hide();
        $('#attach_media').hide();
       
        var community_group = $('#community_group').val();
        
            if(id == 176){
                $('#container_add').show();
                $("#container").empty();
                $.ajax({
                    url: '/taskContainer',
                    data: { '_token': '{{ csrf_token() }}','community_group':community_group,'task_func':id,'task_id':{{$task->id}} },
                    type: 'POST',
                    async: false,
                    success: function(data) {
                        var ddData =  '<option value="">Select</option>';
                        $.each(data.data, function(k1, v1) {
                            ddData += '<option value="'+v1.id+'" >'+v1.name+'</option>'; 
                        });
                        $("#container").append(ddData);
                    }
                }); 
            }
            
            else if(id == 171){
                $('#person_add').show();
                $("#person").empty();
                $.ajax({
                    url: '/taskPersons',
                    data: { '_token': '{{ csrf_token() }}','community_group':community_group,'task_func':id,'task_id':{{$task->id}} },
                    type: 'POST',
                    async: false,
                    success: function(data) {
                        var ddData =  '<option value="">Select</option>';
                        $.each(data.data, function(k1, v1) {
                            ddData += '<option value="'+v1.id+'" >'+v1.fname+' '+v1.lname+'</option>'; 
                        });
                        $("#person").append(ddData);
                    }
                });   
            }
            
            else if(id == 175){
                $('#pack_add').show();
                $("#packs").empty();
                $.ajax({
                    url: '/taskPacks',
                    data: { '_token': '{{ csrf_token() }}','community_group':community_group,'task_func':id,'task_id':{{$task->id}} },
                    type: 'POST',
                    async: false,
                    success: function(data) {
                        console.log(data);
                        var ddData =  '<option value="">Select</option>';
                        $.each(data.data, function(k1, v1) {
                            ddData += '<option value="'+v1.id+'" >'+v1.species+'</option>'; 
                        });
                        $("#packs").append(ddData);
                    }
                });   
            }
            
            else if(id == 173){
                $('#attach_media').show();
                $("#media_files").empty();
                getMediaFiles();
            }
            
            else if(id == 174){
                // getPackDetail();
                $('#myModal').modal('show');
            }
        
    
    }
    
    function getMediaFiles(){
        $.ajax({
            url: '/getMediaFiles',
            data: { '_token': '{{ csrf_token() }}','task_id':{{$task->id}}},
            type: 'POST',
            success: function(data) {
                 
                if(data.data.length > 0){
                    var i = 1;ddData = '';
                    ddData +=  '<table style="margin-top:10px;"><tr>';
                    ddData += '<th>Sr.No.</th><th>FileName</th>'; 
                    $.each(data.data, function(k1, v1) {
                        var url = "{{asset('file_upload/media')}}/"+v1.name;
                            ddData += '<tr><td>'+i+'.</td><td><a href="'+url+'" target="_blank">'+v1.name.split(/_(.+)/)[1]+'</a></td></tr>'; 
                        i++;
                    });
                    ddData += '</tr></table>'; 
                    $("#attach_media_div").html(ddData);
                    $("#media_files").val('');
                }
            }
        });
    }
    
    $('#taskFunModal').on('hidden.bs.modal', function () {
        $("#taskFunModal input,select").each(function() {
            this.value = "";
        });
        $('#pack_add').hide();
        $('#container_add').hide();
        $('#person_add').hide();
        $('#attach_media').hide();
    })
    
    function taskExecuteFunction(id){
        
        var task_func = $('#task_func').val();
        if(task_func == ''){
            alert("Please select function to execute");
            return false;
        }
        else if(task_func == 174){ 
            $('#myModal').modal('show');
        }
        else{
            var form_data = new FormData();
           
            form_data.append('task_id', {{$task->id}});
            form_data.append('task_func', task_func);
            form_data.append('container', $("#container").val());
            form_data.append('pack', $("#packs").val());
            form_data.append('person', $('#person').val());
            
            let TotalFiles = $('#media_files')[0].files.length; //Total files
            let files = $('#media_files')[0];
            for (let i = 0; i < TotalFiles; i++) {
            form_data.append('files' + i, files.files[i]);
            }
            form_data.append('TotalFiles', TotalFiles);
            spinner.show();
        
            $.ajax({
                url: '/taskExecuteFunction',
                data: form_data,
                type: 'POST',
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    // console.log(data);
                    spinner.hide();
                    if(data.success == false){
                        $('#alert_text').text(data.message);
                        $('#alert_div').show();
                        $('#alert_div').removeClass('alert-success');
                        $('#alert_div').addClass('alert-danger');
                        setTimeout(function () {
                            $('#alert_div').hide();
                        }, 2500);
                    }else{
                        $('#alert_text').text(data.message);
                        $('#alert_div').show();
                        $('#alert_div').removeClass('alert-danger');
                        $('#alert_div').addClass('alert-success');
                        
                        if(data.data && data.data.field_id == 134){
                            $('#START_DATE').val(data.data.value);
                        }
                        if(data.data && data.data.field_id == 135){
                            $('#END_DATE').val(data.data.value);
                        }
                        setTimeout(function () {
                            $('#alert_div').hide();
                            $('#taskFunModal').modal('hide');
                        }, 2500);
                         
                        getMediaFiles();
                        getTaskObject();
                        
                       
                    }
                    
                    
                }
            });  
        }
       
    }
   
    function getKey(id){
        var token = $('#_token').val();
            $.ajax({
                url: '/gettaskconfig',
                data: {'id':id, _token:token,'task_id':{{$task->id}} },
                type: 'POST',
                success: function(data) {
                    var response = JSON.parse(data);
                    console.log(response);
                    var htmlData = '';
                    $.each(response.fields, function(k, v) {
                        if(v.field_name != null){
                            var field_name = (v.field_name).replace(" ","_");
                            var field_type = v.field_type;
                            var field_value = '';
                                if(v.field_value != null){
                                   field_value = v.field_value; 
                                }
                                type = 'text';
                                
                            if(field_type == 'Date'){ type = 'date';}
                            else if(field_type == 'DateTime'){ type = 'datetime';}
                            else if(field_type == 'Numeric'){ type = 'number'; }
                            else if(field_type == 'List'){ type = 'list'; }
                            else if(field_type == 'Multilist'){ type = 'multilist'; }
                            else if(field_type == 'Table'){ type = 'table'; }
                            var readonly = ''; 
                            var disabled = ''; 
                            if(v.editable == 0){
                                readonly = 'readonly';
                                disabled = 'disabled';
                            }   
                            @if(in_array("CanOverideEditTask", array_column(json_decode($user_priv, true), 'privilege')))
                                readonly = '';
                                disabled = '';
                            @endif
                                
                            htmlData += '<div class="col-md-6"><div class="form-group">';
                            htmlData += '<label class="col-md-12">'+v.field_description+'</label><input type="hidden" name="f_id[]" value="'+v.field_id+'">';
                            htmlData += '<div class="col-md-12">';
                            
                            if(type == 'multilist' || type == 'list'  || type == 'table'){
                                if(type == 'multilist'){
                                     htmlData += '<select class="form-control select fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" '+readonly+' multiple><option value="">Select</option>';
                                     $.each(v.field_list, function(k1, v1) {
                                         
                                             
                                            var selected = '';
                                            var collectids = field_value.split(',');
                                            for(var i = 0; i < collectids.length; i++){
                                                if(collectids[i] == v1.id){
                                                    selected = 'selected';
                                                }
                                            }
                                        
                                            htmlData += '<option value="'+v1.id+'" '+disabled+' '+selected+'>'+v1.name+'</option>'; 
                                        
                                        
                                    });
                                }else{
                                   
                                   htmlData += '<select class="form-control select fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" '+readonly+'><option value="">Select</option>';  
                                   $.each(v.field_list, function(k1, v1) {
                                        if(v1.id == field_value){
                                            htmlData += '<option value="'+v1.id+'" '+disabled+' selected>'+v1.name+'</option>'; 
                                        }else{
                                            htmlData += '<option value="'+v1.id+'" '+disabled+'>'+v1.name+'</option>'; 
                                        }
                                        
                                    });
                                }
                                // htmlData += '<select class="form-control" name="f_name[]" id="'+field_name+'" '+readonly+'><option value="">Select</option>';
                                    
                                htmlData += '</select>';
                                
                            }
                        
                            else if(type == 'datetime' || type == 'DateTime' || type == 'date'){
                                
                                 htmlData += '<input type="datetime-local" class="form-control fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" value="'+field_value+'" '+readonly+'>';
                            }
                            else{
                                 htmlData += '<input type="'+type+'" class="form-control fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" value="'+field_value+'" '+readonly+'>';
                            }
                            // htmlData += '<input type="text" class="form-control" name="f_name[]" id="'+field_name+'" value="'+field_value+'" '+readonly+'>';
                            htmlData += '</div>';
                            htmlData += '</div></div>';
                        }
                        
                                
                                    
                                    
                                        
                                    
                                
                            
                        // // if(v.name == 'task_status'){
                            
                        //     var htmlData = ''; name = (v.name).toLowerCase(); type = 'text';
                            
                        //     if(v.field_type == 'Date'){ type = 'date';}
                        //     else if(v.field_type == 'Numeric'){ type = 'number'; }
                        //     else if(v.field_type == 'List'){ type = 'list'; }
                        //     else if(v.field_type == 'Multilist'){ type = 'multilist'; }
                            
                        //     if(type == 'multilist' || type == 'list'){
                        //         htmlData += '<select class="form-control" name="'+name+'" id="'+name+'"><option value="">Select</option>';
                        //             $.each(v.field_list, function(k1, v1) {
                        //                 htmlData += '<option value="'+v1.id+'">'+v1.name+'</option>'; 
                        //             });
                        //         htmlData += '</select>';
                        //     }else{
                        //       htmlData += '<input type="'+type+'" class="form-control"name="'+name+'" id="'+name+'">';
                        //     }
                        //     $('#'+name+'_div').html(htmlData);
                        // // }
                       
                        
                    });
                    $('#dashboard_row').html(htmlData);
                    $('.select').selectpicker();
            
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
        }
        
    function getTaskObject(){
        var token = $('#_token').val();
        $.ajax({
            url: '/gettaskobjects',
            data: {_token:token,'task_id':{{$task->id}} },
            type: 'POST',
            success: function(data) {
                // var response = JSON.parse(data);
                console.log(data);
                var htmlData = '<table class="table datatable table-hover">';
                    htmlData += '<thead><tr><th>No</th><th>Name</th><th>Function Name</th><th>Action</th></tr></thead>';
                    htmlData += '<tbody>';
                var i = 1; 
                if(data.taskObject.length > 0){
                    
                    $.each(data.taskObject, function(k, v) {
                        var function_name = "'"+v.function+"'";
                        htmlData += '<tr>';
                        htmlData += '<td>'+i+'</td>';
                        htmlData += '<td>'+v.name+'</td>';
                        htmlData += '<td>'+v.function+'</td>';
                        htmlData += '<td>';
                        
                        @if(in_array("EditTaskObject", array_column(json_decode($user_priv, true), 'privilege')))
                        var disabled = '';
                        if(v.function == 'CREATE_PACK'){ 
                            htmlData += '<button class="btn btn-default"  data-placement="top" title="Edit" onclick="editTaskObject('+function_name+','+v.no+')" disabled style=""><i class="fa fa-edit" style="color: #1caf9a73"></i></button> ';
                        }else{
                            htmlData += '<button class="btn btn-default"  data-placement="top" title="Edit" onclick="editTaskObject('+function_name+','+v.no+')"><i class="fa fa-edit" style="color: #1caf9a"></i></button> ';
                       }
                        htmlData += '<button type="submit" value="delete" class="btn btn-default"  data-placement="top" title="Delete" onclick="ConfirmDelete('+v.id+')"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>';
                        @endif
                        htmlData += '</td>';
                        htmlData += '</tr>';
                        i++;
                    });
                }else{
                    htmlData += '<tr>';
                    htmlData += '<td colspan="4" style="text-align:center;">No Data Found</td>';
                    htmlData += '</tr>';  
                }
                
                htmlData += '<tbody></table>';
                $("#table_taskobject").html(htmlData);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('error : '+xhr.responseText);
                alert('something bad happened');
            }
        });
    }
    
 
    
    function editTaskObject(id,no){
       
        var value = '';
        $('#taskFunModal').modal('show');
        
        if(id == 'PERSON'){ value = 171; $('#person').val(no);}
        else if(id == 'CREATE_PACK'){ value = 174; }
        else if(id == 'PACK'){ value = 175; }
        else if(id == 'CONTAINER'){ value = 176; }
        else if(id == 'ATTACH_MEDIA'){ value = 173; }
      
        $('#task_func').val(value);
        
        functionChangeData(value);
    
        if(id == 'PERSON'){ $('#person').val(no);}
        else if(id == 'CREATE_PACK'){ value = 174; }
        else if(id == 'PACK'){ $('#packs').val(no);}
        else if(id == 'CONTAINER'){ $('#container').val(no); }
         
    }
    
    function ConfirmDelete(id){
            var token = $('#_token').val();
            var x = confirm("Are you sure you want to delete?");
            if (x){
                $.ajax({
                    url: '/taskobject/'+id,
                    data: {_method:'DELETE', _token:token },
                    type: 'POST',
                    success: function(data) {
                        var response = JSON.parse(data);
                        alert(response.message);
                        getTaskObject();
                    },
                    error: function() {
                        alert('something bad happened');
                    }
                });
            }
        }
        
    $( "#collectactivityid" ).change(function() {
        $('#collect_activity_id').val($( "#collectactivityid" ).val());
    });
    
    $(function () {
        $('#alert_div').hide();
        $('#alertpack').hide();
        
        getKey({{$task->task_config_id}});
        functionChangeData({{$task->task_func}});
        getTaskObject();
        
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