@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Units</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/unit">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Units</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('unit')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
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
                                <label class="col-md-3 control-label">Description</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                    <span class="help-block">This field is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Community Group <span class="mandatory">*</span></label>
                                <div class="col-md-6">
                                    <select class="form-control" name="communitygroup" id="communitygroup">
                                        <option value="">select</option>
                                        @foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                    </select>
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
            name: {
                required: true,
            },
            description: {
                required: true,
            },
            communitygroup: {
                required: true,
            },
            
        },
        
    });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
