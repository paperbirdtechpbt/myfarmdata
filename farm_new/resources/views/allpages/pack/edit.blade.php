@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Pack</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="{{route('pack.update',$pack->id)}}">
            @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Pack</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('pack')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Creation Date</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="creation_date" id="creation_date" value="{{$pack->creation_date}}">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Quantity</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="quantity" id="quantity" value="{{$pack->quantity}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Collect Activity</label>
                                        <div class="col-md-9">
                                            <!--<select class="form-control select" name="collect_activity" id="collect_activity">-->
                                                <select multiple class="form-control select" name="collectactivityid" id="collectactivityid">
                                                <!-- <option value="">select</option> -->
                                                @foreach($collectActivity as $key=> $value)
                                                    <option value="{{$key}}" @if(in_array($key, explode(',', $pack->collect_activity_id))) selected @endif>
                                                        
                                                        {{$value}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" id="description">{{$pack->description}}</textarea>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>v
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Species</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="species" id="species" value="{{$pack->species}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Units</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="unit_id" id="unit_id">
                                                <!-- <option value="">select</option> -->
                                                @foreach($unit as $key=>$value)
                                                    <option value="{{$key}}"
                                                        @if($pack->unit_id==$key)
                                                            selected
                                                        @endif>
                                                        {{$value}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="com_group_id" id="com_group_id">
                                                <!-- <option value="">select</option> -->
                                                @if(count($communityGroup[0]->communitygrp) > 1)
                                                <option value="">select</option>
                                                @endif
                                                @foreach($communityGroup as $value)
                                                    @foreach($value->communitygrp as $value1)
                                                    <option value="{{$value1->id}}" @if($pack->community_group_id==$value1->id)
                                                        selected
                                                    @endif>{{$value1->name}}</option>
                                                    @endforeach
                                                @endforeach
                                                
                                               
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       
                                        <label class="col-md-3 control-label">Object Type</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="object_type" id="object_type0">
                                                <option value="">select</option>
                                                @foreach($object_type as $value)<option value="{{$value->id}}"
                                                @if($pack->type==$value->id)
                                                        selected
                                                    @endif>{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                       
                                         <label class="col-md-3 control-label">Object Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="object_class" id="object_class0">
                                                <option value="">select</option>
                                                @foreach($object_class as $value)<option value="{{$value->id}}" 
                                                @if($pack->class==$value->id)
                                                        selected
                                                    @endif>{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="collect_activity_id" id="collect_activity_id" value="0">
                        <!--<input type="hidden" name="collect_activity_id_old" id="collect_activity_id_old" value="{{$pack->collect_activity_id}}">-->
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
            creation_date: {
                required: true,
            },
            quantity: {
                required: true,
            },
            collect_activity: {
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
        }
    });
    $( "#collectactivityid" ).change(function() {
        // alert($( "#collectactivityid" ).val());
        $('#collect_activity_id').val($( "#collectactivityid" ).val());
        
    });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
