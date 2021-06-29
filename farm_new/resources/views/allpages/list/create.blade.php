@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create List</li>
@endsection

@php

@endphp

@section('maincontent')
<style>
    .btn-group.bootstrap-select select {
width: 1px !important;
}
</style>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="/list">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> List</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('list')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="list_choice_row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                    {{csrf_field()}}
                                    @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>Community Group</label>
                                    <select class="form-control" name="communitygroup" id="communitygroup">
                                        <option value="">select</option>
                                        @foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                        <!--<option value="GAB_01">GAB_01</option>-->
                                        <!--<option value="GAB_02">GAB_02</option>-->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="choice_div0" style="margin-top:20px;">
                                <div class="col-md-4">
                                    <label>Choice Name</label>
                                    <input type="text" class="form-control" name="choice[]" id="choice0" value="{{old('choice0')}}">
                                </div>
                                <div class="col-md-4">
                                    <label>Choice Community Group</label>
                                    <select class="form-control" name="choice_communitygroup[]" id="choice_communitygroup">
                                        <option value="">select</option>
                                        @foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                        <!--<option value="GAB_01">GAB_01</option>-->
                                        <!--<option value="GAB_02">GAB_02</option>-->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button1 class="btn btn-default" onclick="add_row()" style="margin-top: 22px;">Add</button1>
                                </div>
                            </div>
                            <!--<div class="col-md-12" id="privilege_div" style="margin-top: 20px;"></div>                            -->
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="privilege_count" id="privilege_count" value="0">
                        <!--<input type="hidden" name="community_group_id" id="community_group_id" value="">-->
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
            
        },
        // errorPlacement: function(error, element) {
        // if (element.attr("name") == "communitygroup") {
        //   error.insertAfter(".bootstrap-select");
        // } else {
        //   error.insertAfter(element);
        // }
    // },
        // messages: {
        //     "choice[]" : {
        //         required : function ( r, i ) {
        //              return " the [index]st input required"; 
                     
        //         }}}
             
            
            
        
        
    });
//      $('form select').each(function(){
//     var event = $._data(this, 'events');
//     if(!event.change) {
//         $(this).bind("change", function() {
//             $(this).blur().focus();
//         });
//     }       
// });
   
    $( "#communitygroupid" ).change(function() {
        // alert($( "#collectactivityid" ).val());
        $('#community_group_id').val($( "#communitygroupid" ).val());
        
    });
    
    
    var count = 1;
    function add_row(count1) {
        var html_data = '';
        html_data += '<div class="col-md-12" id="choice_div'+count+'" style="margin-top:20px;"><div class="col-md-4">';
        html_data += '<label>Choice Name</label><input type="text" class="form-control" name="choice[]" id="choice'+count+'" value=""></div><div class="col-md-4">';
        html_data += '<label>Choice Community Group</label><select class="form-control" name="choice_communitygroup[]" id="choice_communitygroup'+count+'"><option value="">select</option>@foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div><div class="col-md-4">';
        html_data += '<button1 class="btn btn-default" onclick="delete_row('+count+')" style="margin-top: 22px;">Remove</button1></div></div>';
        // $('#privilege_div').append(html_data);
        $('#list_choice_row').append(html_data);
        $('#privilege_count').val(count);
        // $('#choice_communitygroup'+count).selectpicker('refresh');
        // $("#choice_communitygroup"+count).rules("add", "required");
       
        count++;
    }
    function delete_row(count) {
        $('#choice_div'+count).remove();
        // $('#choice'+count).remove();
        // $('#priv_div'+count).hide();
        // $('#privilege_is_delete'+count).val('1');
    }
    var jvalidate = $("#add_form").validate({
        ignore: [],
        rules: {
            name: {
                required: true,
            },
        }
    });
    // $('#name').val('name');
    // $('#description').val('test desc');
    // $('#choice0').val('choice123');
    </script>
@endsection
