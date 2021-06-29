@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Pack</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="{{route('pack.store')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Pack</h3>
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
                                            <input type="text" class="form-control datepicker" name="creation_date" id="creation_date" value="">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Quantity</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="quantity" id="quantity" value="">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Collect Activity</label>
                                        <div class="col-md-9">
                                            <!--<select multiple class="form-control select" name="collect_activity" id="collect_activity">-->
                                            <select multiple class="form-control select" name="collectactivityid" id="collectactivityid">
                                                @if(count($collectActivity) > 1)
                                                <option value="">select</option>
                                                @endif
                                                @foreach($collectActivity as $key=>$value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                                <!-- <option value="1">FERMENTATION</option>
                                                <option value="2">DRYING</option> -->
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" id="description"></textarea>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Species</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="species" id="species" value="">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Units</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="unit_id" id="unit_id">
                                                @if(count($unit) > 1)
                                                <option value="">select</option>
                                                @endif
                                                @foreach($unit as $key=>$value)
                                                <option value="{{$key}}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="com_group_id" id="com_group_id">
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
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                       
                                        <label class="col-md-3 control-label">Object Type</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="object_type" id="object_type0">
                                                <option value="">select</option>
                                                @foreach($object_type as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                       
                                         <label class="col-md-3 control-label">Object Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="object_class" id="object_class0">
                                                <option value="">select</option>
                                                @foreach($object_class as $value)<option value="{{$value->id}}" >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    
                                </div>
                                </div>
                            </div>
                            
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
