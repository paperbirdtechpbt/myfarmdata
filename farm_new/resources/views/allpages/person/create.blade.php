@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Person</li>
@endsection

@php

@endphp

@section('maincontent')

    <style>
        .file-input-wrapper{
            float:right;
            margin:5px;
        }
        #pic{
            border: 1px solid #d5d5d5; 
            padding: 2px; 
            float: right; 
            height: 160px; 
            width: auto;
            margin-right: 5px;
        }
        .mandatory{ color:red; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" enctype="multipart/form-data" action="/person">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Person</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('person')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <!--<div class="col-md-12">-->
                            <!--    <div class="col-md-6">-->
                            <!--        <div class="form-group">-->
                            <!--            <label class="col-md-2 control-label"></label>-->
                            <!--            <div class="col-md-10">-->
                            <!--                <input type="file" class="fileinput btn-default" name="image" id="image" data-filename-placement="inside" title="File name goes inside"/>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">First Name <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="fname" id="fname">
                                            {{csrf_field()}}
                                            @error('fname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Last Name <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="lname" id="lname" value="{{old('lname')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control email" name="email" id="email" value="{{old('email')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Contact</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="contact" id="contact" maxlength="10" value="{{old('contact')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Birth Date</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control datepicker" name="dob" id="dob" value="{{old('dob')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Birth Place</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="birth_place" id="birth_place" value="{{old('birth_place')}}">-->
                                            <select class="form-control select" name="birth_place" id="birth_place">
                                                <!--<option value="GABON">GABON</option>-->
                                                <option value="">select</option>
                                                @foreach($country_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Certification</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="certification" id="certification" value="{{old('certification')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Last Certification Date</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control datepicker" name="last_certification_date" id="last_certification_date" value="{{old('last_certification_date')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">User Account</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="user_id" id="user_id" value="{{old('user_id')}}">-->
                                            <!--<select class="form-control select" name="user_id" id="user_id" onChange="getCommunityGroupByUser(this.value);">-->
                                            <select class="form-control select" name="user_id" id="user_id">
                                                <option value="">select</option>
                                                @foreach($users as $user)
                                                @php
                                                    $array1 = explode(",",$community_group_id);
                                                    $array2 = explode(",",$user->community_group_id);
                                                    $diff_result = array_intersect($array1, $array2);
                                                @endphp
                                                @if(count($diff_result)>0)
                                                <option value="{{$user->id}}" >{{$user->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Is in Coop?</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="is_in_coop" id="is_in_coop" value="{{old('is_in_coop')}}">-->
                                            <label class="check"><input type="checkbox" class="icheckbox" name="is_in_coop" id="is_in_coop" value="true"> (Yes)</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <img id="pic" src="{{asset('file_upload/boy.png')}}">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="file" class="fileinput btn-default" name="image" id="image" data-filename-placement="inside" title="Browse Image" onchange="readURL(this)">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="address" id="address" value="{{old('address')}}">-->
                                            <textarea class="form-control" name="address" id="address" rows="3">{{old('address')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Citizenship</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="citizenship" id="citizenship" value="{{old('citizenship')}}">-->
                                            <select class="form-control select" name="citizenship" id="citizenship">
                                                <!--<option value="GABON">GABON</option>-->
                                                <option value="">select</option>
                                                @foreach($country_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">KakaoMundo Center</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="kakaomundo_center" id="kakaomundo_center" value="{{old('kakaomundo_center')}}">-->
                                            <select class="form-control select" name="kakaomundo_center" id="kakaomundo_center">
                                                <option value="">select</option>
                                                @foreach($km_center as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">CommunityGroup <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="communitygroup" id="communitygroup">
                                                <option value="">select</option>
                                               @foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Person Class</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="person_class" id="person_class">
                                                <option value="">select</option>
                                                @foreach($class_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Person Type</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="person_type" id="person_type">
                                                <option value="">select</option>
                                                @foreach($type_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Is KakaoMundo?</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="is_kakaomundo" id="is_kakaomundo" value="{{old('is_kakaomundo')}}">-->
                                            <label class="check"><input type="checkbox" class="icheckbox" name="is_kakaomundo" id="is_kakaomundo" value="true"> (Yes)</label>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>                         
                        </div>
                    </div>
                    <div class="panel-footer">
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
    $( document ).ready(function() {
        //getCommunityGroupByUser($('#user_id').val());
    });
    function getCommunityGroupByUser(id){
        var token = $('#_token').val();
            $.ajax({
                url: '/getCommunityGroupByUser',
                data: {'user_id':id, _token:token },
                type: 'POST',
                success: function(data) {
                    console.log(data);
                    var response = JSON.parse(data);
                    var html_data = '<option>Select</option>';
                    $.each(response.CommunityGroup, function(i, item) {
                        html_data += '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#communitygroup').html(html_data);
                    $('#communitygroup').selectpicker('refresh');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
        }
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            fname: { required: true },
            lname: { required: true },
            description: { required: true },
            communitygroup: { required: true },
            // email: { required: true, email: true },
            // contact: { required: true },
            // dob: { required: true },
            // birth_place: { required: true },
            // address: { required: true },
            // citizenship: { required: true },
            // certification: { required: true },
            // last_certification_date: { required: true },
            // is_in_coop: { required: true },
            // is_kakaomundo: { required: true },
            // kakaomundo_center: { required: true },
            // user_id: { required: true },
        }
    });
    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#pic').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // $('#fname').val('test fname');
    // $('#lname').val('test lname');
    // $('#email').val('test@gmail.com');
    // $('#contact').val('9865320147');
    // $('#dob').val('1991-01-01');
    // $('#birth_place').val('test birth_place');
    // $('#address').val('test address');
    // $('#certification').val('test certification');
    // $('#last_certification_date').val('2021-01-01');
    // $('#description').val('test description');
    </script>
@endsection
