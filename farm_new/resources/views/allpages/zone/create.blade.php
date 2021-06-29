@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Zone</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="{{route('zone.store')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Zone</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('zone')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            {{csrf_field()}}
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Parent Zone</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="parent_zone" id="parent_zone">
                                                <option value="">select</option>
                                                @foreach($zones as $key=>$value)
                                                    <option value="{{$value->no}}" {{ old('parent_zone') == $value->no ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                           
                                           
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Class</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="class" id="class">
                                                <option value="">select</option>
                                                @foreach($classes as $key=>$value)
                                                    <option value="{{$value->id}}" {{ old('class') == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                             @error('class')
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
                                                @foreach($communitygrp as $value)<option value="{{$value->id}}" {{ old('community_group') == $value->id ? "selected" : "" }} >{{$value->name}}</option>@endforeach
                                            </select>
                                            @error('community_group')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    
                                    
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="description" id="description" >{{old('description')}}</textarea>
                                             @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Type</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="type" id="type">
                                                <option value="">select</option>
                                                @foreach($types as $key=>$value)
                                                    <option value="{{$value->id}}" {{ old('type') == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                             @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
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
        ignore: ":hidden:not(.selectpicker)",
        rules: {
            // name: {
            //     required: true,
            // },
            // com_group: {
            //     required: true,
            // },
            // description: {
            //     required: true,
            // },
            // class_id: {
            //     required: true,
            // },
            // type: {
            //     required: true,
            // },
            
        },
        
    });
   
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
