@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit User</li>
@endsection

@php

//dd($user->communitygrp);

@endphp

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/user"> -->
            <form class="form-horizontal" id="add_form" method="POST" action="/user/{{$user->id}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> User</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('user')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
                                            <input type="hidden" name="_method" value="PUT">
                                            {{csrf_field()}}
                                            <span class="help-block">This field is required</span>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Family Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="family_name" id="family_name" value="{{$user->family_name}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}">
                                            <span class="help-block">This field is required</span>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <label class="col-md-3 control-label">Password</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control" name="password" id="password" value="">
                                            <span class="help-block">This field is required</span>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Collect Activities</label>
                                        <div class="col-md-9">
                                            <!-- <input type="text" class="form-control" name="address" id="address" value=""> -->
                                            <select multiple class="form-control select" name="collectactivityid" id="collectactivityid">
                                                <!--<option value="">select</option>-->
                                                @foreach($collectactivity as $collect_activity)
                                                @php
                                                $selected = '';
                                                $collectids = explode(',', $user->collect_activity_id);
                                                for($i = 0; $i < count($collectids); $i++){
                                                    if($collectids[$i] == $collect_activity->id){
                                                        $selected = 'selected';
                                                    }
                                                }
                                                @endphp
                                                <option value="{{$collect_activity->id}}" @php echo $selected; @endphp>{{$collect_activity->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Role</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="role_id" id="role_id" value="">-->
                                            <select multiple class="form-control select" name="roleid" id="roleid">
                                                <!--<option value="">select</option>-->
                                                @foreach($role as $role_data)
                                                @php
                                                $selected = '';
                                                foreach($user->roles as $user_role){
                                                    if($user_role['id'] == $role_data->id){
                                                        $selected = 'selected';
                                                    }
                                                }
                                                @endphp
                                                <option value="{{$role_data->id}}" @php echo $selected; @endphp>{{$role_data->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">External Id</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="external_id" id="external_id" value="{{$user->external_id}}">
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Active</label>
                                        <div class="col-md-9">
                                            <!-- <input type="text" class="form-control" name="address" id="address" value=""> -->
                                            @php
                                            $true_selected = '';
                                            $false_selected = '';
                                            if($user->is_active == 'true'){
                                                $true_selected = 'selected';
                                            }
                                            elseif($user->is_active == 'false'){
                                                $false_selected = 'selected';
                                            }
                                            @endphp
                                            <select class="form-control select" name="is_active" id="is_active">
                                                <option value="">select</option>
                                                <option value="true" @php echo $true_selected; @endphp>True</option>
                                                <option value="false" @php echo $false_selected; @endphp>False</option>
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group Access</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="community_group_id" id="community_group_id" value="">-->
                                            <select multiple class="form-control select" name="communitygroupid" id="communitygroupid">
                                                <option value="">select</option>
                                                @foreach($communitygrp as $community_group)
                                                @php
                                                $selected = '';
                                                foreach($user->communitygrp as $user_communitygrp){
                                                //foreach($communitygrp as $user_communitygrp){
                                                    if($user_communitygrp['id'] == $community_group->id){
                                                        $selected = 'selected';
                                                    }
                                                }
                                                @endphp
                                                <option value="{{$community_group->id}}" @php echo $selected; @endphp>{{$community_group->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="community_group_id" id="community_group_id" value="">-->
                                            <select class="form-control select" name="communitygroup" id="communitygroup" value="{{old('name')}}">
                                                <!--<option value="">select</option>-->
                                                @foreach($communitygrp as $community_group)
                                                <option value="{{$community_group->id}}" @if($user->communitygroup == $community_group->id) selected @endif>{{$community_group->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Language</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="community_group_id" id="community_group_id" value="">-->
                                            <select class="form-control select" name="language" id="language" value="{{old('name')}}">
                                                <!--<option value="">select</option>-->
                                                @foreach($language as $community_group)
                                                <option value="{{$community_group->id}}" @if($user->language == $community_group->id) selected @endif>{{$community_group->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Timezone</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="community_group_id" id="community_group_id" value="">-->
                                            <select class="form-control select" name="timezone" id="timezone" value="{{old('name')}}">
                                                <!--<option value="">select</option>-->
                                                @foreach($timezones as $community_group)
                                                <option value="{{$community_group->id}}" @if($user->timezone == $community_group->id) selected @endif>{{$community_group->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">This field is required</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="role_id" id="role_id" value="0">
                        <input type="hidden" name="collect_activity_id" id="collect_activity_id" value="0">
                        <input type="hidden" name="community_group_id" id="community_group_id" value="0">
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
            family_name: {
                required: true,
                // email: true,
            },
            // password: {
            //     required: true,
            //     // minlength: 10,
            //     // maxlength: 10,
            // },
            collect_activity: {
                required: true,
            },
            role_id: {
                required: true,
            },
            external_id: {
                required: true,
            },
            is_active: {
                required: true,
            },
            com_group: {
                required: true,
            },
        }
    });
    
    $( "#roleid" ).change(function() {
        // alert($( "#roleid" ).val());
        $('#role_id').val($( "#roleid" ).val());
    });
    
    $( "#collectactivityid" ).change(function() {
        // alert($( "#collectactivityid" ).val());
        $('#collect_activity_id').val($( "#collectactivityid" ).val());
    });
    $( "#communitygroupid" ).change(function() {
        // alert($( "#communitygroupid" ).val());
        $('#community_group_id').val($( "#communitygroupid" ).val());
    });
    
    
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
