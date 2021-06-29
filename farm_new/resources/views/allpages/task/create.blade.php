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

@endphp

    <style>
        .form-group{
           margin:10px; 
        }
        
        .accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active, .accordion:hover {
  background-color: #F5F5F5; 
}
/*.accordion:after {*/
  content: '\02795'; /* Unicode character for "plus" sign (+) */
/*  font-size: 10px;*/
/*  color: #777;*/
/*  float: right;*/
/*  margin-left: 5px;*/
/*}*/

/**.active:after {*/
  content: "\2796"; /* Unicode character for "minus" sign (-) */
/*}*/
.panel-accordion {
  padding: 0 18px;
  display: none;
  background-color: white;
  overflow: hidden;
}
    </style>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/task">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Task</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('task')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    
                    <div class="panel-body">
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Name Prefix</label>
                                    <div class="col-md-12">
                                        <input type="hidden" class="form-control" name="name" id="name">
                                        <input type="text" class="form-control nospecialcharater" name="name1" id="name1" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Description <span class="mandatory">*</span></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="description" id="description" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12">Config Type <span class="mandatory">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control select" name="config_type" id="config_type" onchange="getKey(this.value);">
                                            <option value="">Select</option>
                                            @foreach($taskconfigs as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-12 ">CommunityGrp <span class="mandatory">*</span></label>
                                    <div class="col-md-12">
                                        <select class="form-control select" name="community_group" id="community_group">
                                            <option value="">Select</option>
                                            @foreach($communitygrp as $community)
                                            <option value="{{$community->id}}">{{$community->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row col-md-12" id="dashboard_row" style="margin-bottom:1%">
                            
                        </div>
                        </br>
<!--                        <div class="div-accordion">-->
<!--                        <button type="button" class="accordion">Task Objects</button>-->
<!--                        <div class="panel-accordion">-->
<!--                            <div class="row" >-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Object Type</label>-->
<!--                                        <div class="col-md-12">-->
                                            
<!--                                            <input type="text" class="form-control nospecialcharater" name="object_type" id="object_type" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Object No</label>-->
<!--                                        <div class="col-md-12">-->
<!--                                            <input type="text" class="form-control" name="object_no" id="object_no" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="row" >-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Object Name</label>-->
<!--                                        <div class="col-md-12">-->
                                            
<!--                                            <input type="text" class="form-control nospecialcharater" name="object_name" id="object_name" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Object Action</label>-->
<!--                                        <div class="col-md-12">-->
<!--                                            <input type="text" class="form-control" name="object_action" id="object_action" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                              <div class="row" >-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Object Class</label>-->
<!--                                        <div class="col-md-12">-->
                                            
<!--                                            <input type="text" class="form-control nospecialcharater" name="object_class" id="object_class" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                               
<!--                            </div>-->
<!--                        </div>-->
<!--                        </div>-->
<!--                        </br>-->
<!-- <div class="div-accordion">-->
<!--<button type="button" class="accordion">Task Members</button>-->
<!--<div class="panel-accordion">-->
<!--  <div class="row" >-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Function Name</label>-->
<!--                                        <div class="col-md-12">-->
                                            
<!--                                            <input type="text" class="form-control nospecialcharater" name="function_name" id="function_name" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Function Priv</label>-->
<!--                                        <div class="col-md-12">-->
<!--                                            <input type="text" class="form-control" name="function_priv" id="function_priv" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="row" >-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Description</label>-->
<!--                                        <div class="col-md-12">-->
<!--                                            <textarea class="form-control" name="desc" id="desc" rows="3" spellcheck="false" aria-invalid="false"></textarea>-->
                                            
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                                
<!--                            </div>-->
<!--</div>-->

<!--</div>-->
<!--</br>-->
<!-- <div class="div-accordion">-->
<!--<button type="button" class="accordion">Task Media Files</button>-->
<!--<div class="panel-accordion">-->
<!--  <div class="row" >-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">File Type</label>-->
<!--                                        <div class="col-md-12">-->
                                            
<!--                                           <select class="form-control select" name="filetype" >-->
<!--                                                <option value="">select</option>-->
<!--                                            <option value="IMAGE">IMAGE</option>-->
<!--                                            <option value="PDF">PDF</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">Link</label>-->
<!--                                        <div class="col-md-12">-->
<!--                                            <input type="text" class="form-control" name="function_priv" id="function_priv" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                              <div class="row" >-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">COORDX</label>-->
<!--                                        <div class="col-md-12">-->
                                            
<!--                                            <input type="text" class="form-control nospecialcharater" name="cordx" id="cordx" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-12">COORDY</label>-->
<!--                                        <div class="col-md-12">-->
<!--                                            <input type="text" class="form-control" name="cordy" id="cordy" >-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--</div>-->
<!--</div>-->
<!--</br>-->
<!--                    </div>-->
                    
                    <div class="panel-footer">
                        <input type="hidden" name="field_array" id="field_array" value="">
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



    
    var jvalidate = $("#add_form").validate({
        ignore: ':not(select:hidden, input:visible, textarea:visible)',
        rules: {
            // name: {
            //     required: true,
            //     // checkUserName: true
            // },
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
    
    $('select').on('change', function () {
        jvalidate.element($(this));
    });

    $("form").submit(function(){
        var ItemArray = [];
        $(".fieldArray").each(function() {
            ItemArray.push({
                f_id : $(this).parent().siblings('input').val(), 
                f_value : $(this).val()
            });
        });
        $("#field_array").val(JSON.stringify(ItemArray));
        
    });

    
    $.validator.addMethod("checkUserName", 
        function(value, element) {
            var token = $('#_token').val();
            var result = false;
            $.ajax({
                type:"POST",
                async: false,
                url: '/checkunique', // script to validate in server side
                data: {'name': value, _token:token,'page':'task','id':null},
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
    
    // $('#add_form').validate().settings.ignore = 
    // ':hidden:not(selectpicker)';
    
    
    function pad (str) {
        var max = 4;
      str = str.toString();
      return str.length < max ? pad("0" + str, max) : str;
    }
    
    function getKey(id){
        var token = $('#_token').val();
            $.ajax({
                url: '/gettaskconfig',
                data: {'id':id, _token:token },
                type: 'POST',
                success: function(data) {
                    var response = JSON.parse(data);
                    
                    var taskconfig = response.taskconfig; 
                    // var max = response.max;
                    var name_prefix = taskconfig.name_prefix;
                    if(taskconfig.name_prefix == null){
                        name_prefix = '';
                    }
                        // $('#description').val(taskconfig.description);
                        $('#name1').val(name_prefix);
                        // $('#name').val(max);
                   
                    var htmlData = '';
                    $.each(response.fields, function(k, v) {
                        if(v.field_name != null){
                            var field_name = (v.field_name).replace(" ","_");
                            var field_type = v.field_type;
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
                            htmlData += '<label class="col-md-12 ">'+v.field_description+'</label><input type="hidden" name="f_id[]" value="'+v.field_id+'">';
                            htmlData += '<div class="col-md-12">';
                            
                            if(type == 'multilist' || type == 'list' || type == 'table'){
                                if(type == 'multilist'){
                                     htmlData += '<select class="form-control select fieldArray" name="f_name[]" f_id="'+v.field_id+'" id="'+field_name+'" '+readonly+' multiple><option value="">Select</option>';
                                }else{
                                   htmlData += '<select class="form-control select fieldArray" name="f_name[]" f_id="'+v.field_id+'" id="'+field_name+'" '+readonly+'><option value="">Select</option>';  
                                }
                                // htmlData += '<select class="form-control" name="'+field_name+'" id="'+field_name+'"><option value="">Select</option>';
                               
                                    $.each(v.field_list, function(k1, v1) {
                                        htmlData += '<option value="'+v1.id+'" '+disabled+'>'+v1.name+'</option>'; 
                                    });
                                htmlData += '</select>';
                            }
                          else if(type == 'datetime' || type == 'DateTime' || type == 'Date'){
                                
                                 htmlData += '<input type="datetime-local" class="form-control fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" '+readonly+'>';
                            }
                            else{
                                //  htmlData += '<input type="'+type+'" class="form-control"name="'+field_name+'" id="'+field_name+'">';
                                 htmlData += '<input type="'+type+'" class="form-control fieldArray" f_id="'+v.field_id+'" name="f_name[]" id="'+field_name+'" '+readonly+'>';
                            }
                            
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
    
    $(function () {
        var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
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