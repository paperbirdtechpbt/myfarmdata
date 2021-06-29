@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Community Grp</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/communitygrp/{{$communitygroup->id}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Community Grp</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('communitygrp')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="name" value="{{$communitygroup->name}}">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{csrf_field()}}
                                    <span class="help-block">This field is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="description" id="description" value="{{$communitygroup->description}}">
                                    <span class="help-block">This field is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Community Group</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="community_group" id="community_group">
                                        <option value="">select</option>
                                        @foreach($communitygroup1 as $value) @if ($value->id != $communitygroup->id)<option value="{{$value->id}}" {{ $communitygroup->community_group == $value->id ? "selected" : "" }} >{{$value->name}}</option>@endif @endforeach
                                        
                                    </select>
                                    <span class="help-block">This field is required</span>
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
            community_group: {
                required: true,
            },
        }
    });
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
