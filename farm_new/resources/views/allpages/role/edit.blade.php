@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Role</li>
@endsection

@section('maincontent')

@php
$test = $role_privilege[0];
$privilege_id0 = $test->id;
$privilege0 = $test->privilege;
@endphp

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/role/{{$role->id}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Role</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('role')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$role->name}}">
                                            <input type="hidden" name="_method" value="PUT">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Dashboard View</label>
                                        <div class="col-md-9">
                                            <input type="hidden" class="form-control" name="dashboard_view1" id="dashboard_view1" value="{{$role->dashboard_view}}">
                                            <select multiple class="form-control select" name="dashboard_view" id="dashboard_view" >
                                                <!--<option value="">select</option>-->
                                                @foreach($dashboardsettings as $dashboardsetting)
                                                @php
                                                $selected = '';
                                                $collectids = explode(',', $role->dashboard_view);
                                                for($i = 0; $i < count($collectids); $i++){
                                                    if($collectids[$i] == $dashboardsetting->id){
                                                        $selected = 'selected';
                                                    }
                                                }
                                                @endphp
                                                <option value="{{$dashboardsetting->id}}" @php echo $selected; @endphp>{{$dashboardsetting->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Privilege</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="privilege0" id="privilege0" value="{{$privilege0}}">-->
                                            <select class="form-control" name="privilege0" id="privilege0">
                                                <option value="">select</option>
                                                @foreach($privileges as $privilege)
                                                <option value="{{$privilege->name}}" @if($privilege0 == $privilege->name){{'selected'}}@endif>{{$privilege->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                            <input type="hidden" name="privilege_id0" id="privilege_id0" value="{{$privilege_id0}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{$role->description}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="community_group" id="community_group"  value="{{old('community_group')}}">
                                                <option value="">Select</option>
                                                @foreach($communitygrp as $community)
                                                <option value="{{$community->id}}" @if($role->community_group == $community->id){{'selected'}}@endif  >{{$community->name}}</option>
                                                @endforeach
                                                <!--<option value="GAB_01" @if($role->community_group == 'GAB_01'){{'selected'}}@endif >GAB_01</option>-->
                                                <!--<option value="GAB_02" @if($role->community_group == 'GAB_02'){{'selected'}}@endif>GAB_02</option>-->
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button1 class="btn btn-default" onclick="add_row(0)"  style="float: right;"><i class="fa fa-pencil"></i>Add Privilege</button1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="privilege_div" style="margin-top: 20px;">
                                @foreach($role_privilege as $privilege)
                                @if($loop->iteration > 1)
                                @php
                                $count = $loop->iteration;
                                $count--;
                                @endphp
                                <div class="col-md-6" id="priv_div{{$count}}">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Privilege</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <!--<input type="text" class="form-control" name="privilege{{$count}}" id="privilege{{$count}}" value="{{$privilege->privilege}}">-->
                                                <select class="form-control" name="privilege{{$count}}" id="privilege{{$count}}">
                                                    <option value="">select</option>
                                                    @foreach($privileges as $privilege1)
                                                    <option value="{{$privilege1->name}}" @if($privilege->privilege == $privilege1->name){{'selected'}}@endif>{{$privilege1->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" onclick="delete_row({{$count}})"><i class="fa fa-trash-o" style="color: red;"></i></button>
                                                </span>
                                            </div>
                                            <span class="help-block">This field is required</span>
                                            <input type="hidden" name="privilege_id{{$count}}" id="privilege_id{{$count}}" value="{{$privilege->id}}">
                                            <input type="hidden" name="privilege_is_delete{{$count}}" id="privilege_is_delete{{$count}}" value="0">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="privilege_count" id="privilege_count" value="{{count($role_privilege)}}">
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
    var count = {{count($role_privilege)}};
    function add_row(count1) {
        var html_data = '';
        // html_data += '<div class="col-md-6" id="priv_div'+count+'"><div class="form-group"><label class="col-md-3 control-label">Privilege</label><div class="col-md-9"><div class="input-group"><input type="text" class="form-control" name="privilege'+count+'" id="privilege'+count+'" value=""><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="delete_row('+count+')"><i class="fa fa-trash-o" style="color: red;"></i></button></span></div><span class="help-block">This field is required</span><input type="hidden" name="privilege_id'+count+'" id="privilege_id'+count+'" value="0"><input type="hidden" name="privilege_is_delete'+count+'" id="privilege_is_delete'+count+'" value="0"></div></div></div>';
        html_data += '<div class="col-md-6" id="priv_div'+count+'"><div class="form-group"><label class="col-md-3 control-label">Privilege</label><div class="col-md-9"><div class="input-group"><select class="form-control select" name="privilege'+count+'" id="privilege'+count+'"><option value="">select</option>@foreach($privileges as $privilege)<option value="{{$privilege->name}}">{{$privilege->name}}</option>@endforeach</select><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="delete_row('+count+')"><i class="fa fa-trash-o" style="color: red;"></i></button></span></div><span class="help-block">This field is required</span><input type="hidden" name="privilege_is_delete'+count+'" id="privilege_is_delete'+count+'" value="0"></div></div></div>';
        $('#privilege_div').append(html_data);
        $('#privilege_count').val(count);
        count++;
    }
    function delete_row(count) {
        $('#priv_div'+count).hide();
        $('#privilege_is_delete'+count).val('1');
    }
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
            },
            description: {
                required: true,
            },
            community_group: {
                required: true,
            },
            dashboard_view: {
                required: true,
            },
        }
    });
    $( "#dashboard_view" ).change(function() {
        $('#dashboard_view1').val($( "#dashboard_view" ).val());
    });
    
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
