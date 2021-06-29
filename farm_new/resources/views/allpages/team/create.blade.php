@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Team</li>
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
        #team_person_div .col-md-6{ margin-top:10px; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" enctype="multipart/form-data" action="/team">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Team</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('team')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Team Name <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                            {{csrf_field()}}
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
                                        <label class="col-md-3 control-label">Address</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="address" id="address" value="{{old('address')}}">-->
                                            <textarea class="form-control" name="address" id="address" rows="3">{{old('address')}}</textarea>
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
                                        <label class="col-md-3 control-label">Responsible <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="responsible" id="responsible" value="{{old('responsible')}}">-->
                                            <select class="form-control select" name="responsible" id="responsible">
                                                <option value="">select</option>
                                                @foreach($person as $user) <option value="{{$user->id}}">{{$user->fname.' '.$user->lname}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <img id="pic" src="{{asset('file_upload/no_logo.jpg')}}">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="file" class="fileinput btn-default" name="image" id="image" data-filename-placement="inside" title="Browse Logo" onchange="readURL(this)">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">team Class <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="team_class" id="team_class">
                                                <option value="">select</option>
                                                @foreach($teamclass as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">team Type <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="team_type" id="team_type">
                                                <option value="">select</option>
                                                @foreach($teamtype as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </div>
                        <div class="row">
                            <!--<h4>Add Team Members</h4>-->
                            <button1 class="btn btn-default" style="margin-top:20px; margin-bottom:20px;" onclick="add_row()">Add Team Members</button1>
                            <div class="col-md-12" id="team_person_div">
                                <div class="col-md-6" id="person_div0">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Person <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <select class="form-control select" name="person[]" id="person0">
                                                    <option value="">select</option>
                                                    @foreach($person as $user) <option value="{{$user->id}}">{{$user->fname.' '.$user->lname}}</option> @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" onclick="delete_row(0)"><i class="fa fa-trash-o text-danger"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="person_div1">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Person <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <select class="form-control select" name="person[]" id="person1">
                                                    <option value="">select</option>
                                                    @foreach($person as $user) <option value="{{$user->id}}">{{$user->fname.' '.$user->lname}}</option> @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" onclick="delete_row(1)"><i class="fa fa-trash-o text-danger"></i></button>
                                                </span>
                                            </div>
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

@endsection

@section('javascript')
    <script>
    
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            name: { required: true },
            description: { required: true },
            communitygroup: { required: true },
            responsible: { required: true },
            team_class: { required: true },
            team_type: { required: true },
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
    
    var count = 2;
    
    function add_row() {
        var html_data = '';
        html_data += '<div class="col-md-6" id="person_div'+count+'"><div class="form-group"><label class="col-md-3 control-label">Person <span class="mandatory">*</span></label><div class="col-md-9"><div class="input-group">';
        html_data += '<select class="form-control select" name="person[]" id="person'+count+'"><option value="">select</option>@foreach($person as $user) <option value="{{$user->id}}">{{$user->fname.' '.$user->lname}}</option> @endforeach</select>';
        html_data += '<span class="input-group-btn"><button class="btn btn-default" type="button" onclick="delete_row('+count+')"><i class="fa fa-trash-o text-danger"></i></button></span>';
        html_data += '</div></div></div></div>';
        $('#team_person_div').append(html_data);
        $('#person'+count).selectpicker('refresh');
        count++;
    }
    
    function delete_row(count) {
        $('#person_div'+count).remove();
        // $('#priv_div'+count).hide();
        // $('#privilege_is_delete'+count).val('1');
    }

    $('#fname').val('test fname');
    $('#lname').val('test lname');
    $('#email').val('test@gmail.com');
    $('#contact').val('9865320147');
    $('#dob').val('1991-01-01');
    $('#birth_place').val('test birth_place');
    $('#address').val('test address');
    $('#certification').val('test certification');
    $('#last_certification_date').val('2021-01-01');
    $('#description').val('test description');
    </script>
@endsection
