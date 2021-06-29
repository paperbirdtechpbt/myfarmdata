@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Container</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post"  action="{{route('container.update',$container->id)}}" >
                @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Container</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('container')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row"   id="object_row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$container->name}}" readonly>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            {{csrf_field()}}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Type</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="type" id="type">
                                                <option value="">select</option>
                                                @foreach($type as $key=>$value)
                                                    <option value="{{$value->id}}" {{ $container->type == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                             @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Max Capacity</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="max_capacity" id="max_capacity" value="{{$container->max_capacity}}">
                                            @error('max_capacity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            {{csrf_field()}}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Zone</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="zone" id="zone">
                                                <option value="">select</option>
                                                @foreach($zone as $key=>$value)
                                                    <option value="{{$value->no}}" {{ $container->zone == $value->no ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                             @error('zone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="community_group" id="community_group">
                                                <option value="">select</option>
                                                @foreach($communitygrp as $value)<option value="{{$value->id}}" {{ $container->com_group == $value->id ? "selected" : "" }} >{{$value->name}}</option>@endforeach
                                            </select>
                                            @error('community_group')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    

                             <div class="form-group">
                                        
                                        <label class="col-md-3 control-label">Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="container_class" id="container_class">
                                                <option value="">select</option>
                                                @foreach($object_class as $value)<option value="{{$value->id}}"  @if($container->class == $value->id) selected @endif >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                            
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" id="description" >{{$container->description}}</textarea>
                                             @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Status</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="status" id="status">
                                                <option value="">select</option>
                                                @foreach($status as $key=>$value)
                                                    <option value="{{$value->id}}" {{ $container->status == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                             @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Capacity Unit</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="capacity_units" id="capacity_units">
                                                <option value="">select</option>
                                                @foreach($capacity_units as $key=>$value)
                                                    <option value="{{$value->id}}" {{ $container->capacity_units == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                             @error('capacity_units')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Parent Container</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="parent_container" id="parent_container">
                                                <option value="">select</option>
                                                @foreach($parent_container as $key=>$value)
                                                    <option value="{{$value->id}}" {{ $container->parent_container == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                             @error('parent_container')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Alert Level</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="notification_level" id="notification_level">
                                                <option value="">select</option>
                                                @foreach($notification_level as $key=>$value)
                                                    <option value="{{$value->id}}" {{ $container->notification_level == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('notification_level')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                            @php
                            $count = count($containerobject)
                            @endphp
                            @if($count == 0)         
                                 <div class="col-md-12" id="choice_div0" style="margin-top:20px;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="object_name[]" id="object_name0">
                                            {{csrf_field()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object No</label>
                                        <div class="col-md-12">
                                            <input type="number" class="form-control" name="object_no[]" id="object_no0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control select" name="object_type[]" id="object_type0">
                                                <option value="">select</option>
                                                @foreach($object_type as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Class</label>
                                        <div class="col-md-12">
                                            <select class="form-control select" name="object_class[]" id="object_class0">
                                                <option value="">select</option>
                                                @foreach($object_class as $value)<option value="{{$value->id}}" >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button1 class="btn btn-default" onclick="add_row()" style="margin-top: 22px;">Add</button1>
                                </div>
                            </div>    
                            @endif
                            @foreach($containerobject as $cb)
                             <div class="col-md-12" id="choice_div{{$loop->index}}" style="margin-top:20px;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="object_name[]" id="object_name{{$loop->index}}" value="{{$cb->object_name}}">
                                            {{csrf_field()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object No</label>
                                        <div class="col-md-12">
                                            <input type="number" class="form-control" name="object_no[]" id="object_no{{$loop->index}}" value="{{$cb->object_no}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control select" name="object_type[]" id="object_type{{$loop->index}}">
                                                <option value="">select</option>
                                                @foreach($object_type as $value)<option value="{{$value->id}}" {{ $cb->type == $value->id ? "selected" : "" }} >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Class</label>
                                        <div class="col-md-12">
                                            <select class="form-control select" name="object_class[]" id="object_class{{$loop->index}}">
                                                <option value="">select</option>
                                                @foreach($object_class as $value)<option value="{{$value->id}}" {{ $cb->class == $value->id ? "selected" : "" }}  >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    @if($loop->index == 0)
                                    <button1 class="btn btn-default" onclick="add_row()" style="margin-top: 22px;">Add</button1>
                                    @else
                                    <button1 class="btn btn-default" onclick="delete_row({{$loop->index}})" style="margin-top: 22px;">Remove</button1>       
                                    @endif
                                </div>
                            </div>
                             @endforeach
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="collect_activity_id" id="collect_activity_id" value="">
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
            name: {
                required: true,
            },
            description: {
                required: true,
            },
            max_capacity: {
                required: true,
            },
            community_group: {
                required: true,
            },
            // "object_name[]": "required",
            // "object_no[]": "required",
            // "object_type[]": "required",
            // "object_class[]": "required",
            
        },
        // errorPlacement: function (error, element) {
        //     //check if element has class "kt_selectpicker"
        //     if (element.attr("class").indexOf("bootstrap-select") != -1) {
        //               //get main div
        //                 var mpar = $(element).closest("div.bootstrap-select");
        //                 //insert after .dropdown-toggle div
        //                 error.insertAfter($('.dropdown-toggle', mpar));                       
                        
        //             } else {
        //              //for rest of the elements, show error in same way.
        //                 error.insertAfter(element);
        //             }
        //         }
        
        
    });
   
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    
     var count = {{count($containerobject)}};
    function add_row() {
        var html_data = '';
        html_data += '<div class="col-md-12" id="choice_div'+count+'" style="margin-top:20px;">';
        html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Object Name</label><div class="col-md-12"><input type="text" class="form-control" name="object_name[]" id="object_name'+count+'"></div></div></div>';
        html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Object No</label><div class="col-md-12"><input type="number" class="form-control" name="object_no[]" id="object_no'+count+'"></div></div></div>';
        html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Object Type</label><div class="col-md-12"><select class="form-control select" name="object_type[]" id="object_type'+count+'"><option value="">select</option>@foreach($object_type as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach </select></div></div></div>';
        html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Object Class</label><div class="col-md-12"><select class="form-control select" name="object_class" id="object_class'+count+'"><option value="">select</option>@foreach($object_class as $value)<option value="{{$value->id}}" >{{$value->name}}</option>@endforeach</select></div></div></div>';
        html_data += '<div class="col-md-2"><button1 class="btn btn-default" onclick="delete_row('+count+')" style="margin-top: 22px;">Remove</button1></div></div>';
        // $('#privilege_div').append(html_data);
        $('#object_row').append(html_data);
        $('#object_type'+count).selectpicker('refresh');
        $('#object_class'+count).selectpicker('refresh');
        count++;
    }
    function delete_row(count) {
        $('#choice_div'+count).remove();
        // $('#priv_div'+count).hide();
        // $('#privilege_is_delete'+count).val('1');
    }
    
    </script>
@endsection
