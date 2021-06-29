@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit List</li>
@endsection

@php
//$choicearray = $lists->choices;
//echo $lists->choices[0]->name;
@endphp

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/list/{{$lists->id}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> List</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('list')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="list_choice_row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$lists->name}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="PUT">
                                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="description" id="description" value="{{$lists->description}}">
                                </div>
                                <div class="col-md-4">
                                    <label>Community Group</label>
                                    <select class="form-control" name="communitygroup" id="communitygroup">
                                        <option value="">select</option>
                                        @foreach($communitygrp as $value)<option value="{{$value->id}}" @if($lists->communitygroup == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                    </select>
                                </div>
                            </div>
                            
                            @foreach($lists->choices as $choice)
                            
                            <div class="col-md-12" id="choice_div{{$loop->index}}" style="margin-top:20px;">
                                <div class="col-md-4">
                                    <label>Choice Name</label>
                                    <input type="text" class="form-control" name="choice[]" id="choice{{$loop->index}}" value="{{$choice->name}}">
                                </div>
                                <div class="col-md-4">
                                    <label>Choice Community Group</label>
                                    <select class="form-control" name="choice_communitygroup[]" id="choice_communitygroup{{$loop->index}}">
                                        <option value="">select</option>
                                        
                                        @foreach($communitygrp1[$loop->index] as $value)<option value="{{$value->id}}" @if($choice->choice_communitygroup == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="choice_id[]" id="choice_id{{$loop->iteration}}" value="{{$choice->id}}">
                                    @if($loop->index > 0)
                                    <button1 class="btn btn-default" onclick="delete_row({{$loop->index}})" style="margin-top: 22px;">Remove</button1>
                                    @else
                                    <button1 class="btn btn-default" onclick="add_row()" style="margin-top: 22px;">Add</button1>
                                    @endif
                                </div>
                            </div>
                            
                            @endforeach
                            
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="privilege_count" id="privilege_count" value="0">
                        <!--<input type="hidden" name="community_group_id" id="community_group_id" value="">-->
                        <!--<input type="text" name="test[]"  value="">-->
                        <!--<input type="text" name="test[]"  value="">-->
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
            "choice[]": "required",
            "choice_communitygroup[]": "required",
        }
    });
    
    $( "#communitygroupid" ).change(function() {
        // alert($( "#collectactivityid" ).val());
        $('#community_group_id').val($( "#communitygroupid" ).val());
    });
    
    
    // var count = 1;
    var count = {{count($lists->choices)}};
    // function add_row(count1) {
    //     var html_data = '';
    //     html_data += '<div class="col-md-6" id="priv_div'+count+'"><div class="form-group"><label class="col-md-3 control-label">Choice</label><div class="col-md-9"><div class="input-group"><input type="text" class="form-control" name="choice[]" id="choice'+count+'"><span class="input-group-btn"><button class="btn btn-default" type="button" onclick="delete_row('+count+')"><i class="fa fa-trash-o" style="color: red;"></i></button></span></div><input type="hidden" name="choice_id[]" id="'+count+'" value="0"><span class="help-block">This field is required</span><input type="hidden" name="privilege_is_delete'+count+'" id="privilege_is_delete'+count+'" value="0"></div></div></div>';
    //     $('#list_choice_row').append(html_data);
    //     $('#privilege_count').val(count);
    //     count++;
    // }
    function add_row(count1) {
        var html_data = '';
        html_data += '<div class="col-md-12" id="choice_div'+count+'" style="margin-top:20px;"><div class="col-md-4">';
        html_data += '<label>Choice Name</label><input type="text" class="form-control" name="choice[]" id="choice'+count+'" value=""></div><div class="col-md-4">';
        html_data += '<label>Choice Community Group</label><select class="form-control " name="choice_communitygroup[]" id="choice_communitygroup'+count+'"><option value="">select</option>@foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div><div class="col-md-4">';
        html_data += '<input type="hidden" name="choice_id[]" id="choice_id'+count+'" value="0"><button1 class="btn btn-default" onclick="delete_row('+count+')" style="margin-top: 22px;">Remove</button1></div></div>';
        // $('#privilege_div').append(html_data);
        $('#list_choice_row').append(html_data);
        $('#privilege_count').val(count);
        // $('#choice_communitygroup'+count).selectpicker('refresh');
        count++;
    }
    function delete_row(count) {
        $('#choice'+count).val('deleted_data');
        // $('#choice'+count).remove();
        // $('#priv_div'+count).hide();
        $('#choice_div'+count).hide();
        $('#privilege_is_delete'+count).val('1');
    }
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            name: {
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
