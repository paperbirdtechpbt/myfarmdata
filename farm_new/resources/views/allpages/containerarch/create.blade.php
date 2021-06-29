@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Arch Container</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post" action="{{route('containerarch.store')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Arch Container</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('containerarch')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row"  id="object_row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Container Name</label>
                                        <div class="col-md-12">
                                            <select  class="form-control select" name="c_id" id="c_id">
                                                <option value="">select</option>
                                                @foreach($containers as $key=>$value)
                                                    <option value="{{$value->id}}" {{ old('name') == $value->id ? "selected" : "" }} >{{$value->name}}</option>
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
                            
                            
                            <div class="col-md-12" id="choice_div0" style="margin-top:20px;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Name</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="object_name" id="object_name">
                                            {{csrf_field()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object No</label>
                                        <div class="col-md-12">
                                            <input type="number" class="form-control" name="object_no" id="object_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control select" name="object_type" id="object_type">
                                                <option value="">select</option>
                                                @foreach($object_type as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Class</label>
                                        <div class="col-md-12">
                                            <select class="form-control select" name="object_class" id="object_class">
                                                <option value="">select</option>
                                                @foreach($object_class as $value)<option value="{{$value->id}}" >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-md-2">-->
                                <!--    <button1 class="btn btn-default" onclick="add_row()" style="margin-top: 22px;">Add</button1>-->
                                <!--</div>-->
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
            c_id: {
                required: true,
            },
            // description: {
            //     required: true,
            // },
            // max_capacity: {
            //     required: true,
            // },
            // community_group: {
            //     required: true,
            // },
            object_name: {
                required: true,
            },
            object_no: {
                required: true,
            },
            object_type: {
                required: true,
            },
            object_class: {
                required: true,
            },
            
        },
        // errorPlacement: function (error, element) {
        //     //check if element has class "kt_selectpicker"
        //     if (element.attr("class").indexOf("bootstrap-select") != -1) {
        //               //get main div
        //                 var mpar = $(element).closest("div.bootstrap-select");
        //                 //insert after .dropdown-toggle div
        //                 error.insertAfter($('.dropdown-toggle', mpar));                       
                        
        //             } else {
        //              //for rest of the elements, show error in same way.
        //                 error.insertAfter(element);
        //             }
        //         }
        
        
    });
    
    
    var count = 1;
    function add_row() {
        var html_data = '';
        html_data += '<div class="col-md-12" id="choice_div'+count+'" style="margin-top:20px;">';
        html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Object Name</label><div class="col-md-12"><input type="text" class="form-control" name="object_name[]" id="object_name'+count+'"></div></div></div>';
        html_data += '<div class="col-md-3"><div class="form-group"><label class="col-md-12">Object No</label><div class="col-md-12"><input type="number" class="form-control" name="object_no[]" id="object_no'+count+'"></div></div></div>';
        html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Object Type</label><div class="col-md-12"><select class="form-control select" name="object_type[]" id="object_type'+count+'"><option value="">select</option>@foreach($object_type as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach </select></div></div></div>';
        html_data += '<div class="col-md-2"><div class="form-group"><label class="col-md-12">Object Class</label><div class="col-md-12"><select class="form-control select" name="object_class" id="object_class'+count+'"><option value="">select</option>@foreach($object_class as $value)<option value="{{$value->id}}" >{{$value->name}}</option>@endforeach</select></div></div></div>';
        html_data += '<div class="col-md-2"><button1 class="btn btn-default" onclick="delete_row('+count+')" style="margin-top: 22px;">Remove</button1></div></div>';
        // $('#privilege_div').append(html_data);
        $('#object_row').append(html_data);
        $('#object_type'+count).selectpicker('refresh');
        $('#object_class'+count).selectpicker('refresh');
        count++;
    }
    
    // function add_row(count1) {
    //     var html_data = '';
    //     html_data += '<div class="col-md-12" id="choice_div'+count+'" style="margin-top:20px;"><div class="col-md-4">';
    //     html_data += '<label>Choice Name</label><input type="text" class="form-control" name="choice[]" id="choice'+count+'" value=""></div><div class="col-md-4">';
    //     html_data += '<label>Choice Community Group</label><select class="form-control select" name="choice_communitygroup[]" id="choice_communitygroup'+count+'"><option value="">select</option>@foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select></div><div class="col-md-4">';
    //     html_data += '<button1 class="btn btn-default" onclick="delete_row('+count+')" style="margin-top: 22px;">Remove</button1></div></div>';
    //     // $('#privilege_div').append(html_data);
    //     $('#list_choice_row').append(html_data);
    //     $('#privilege_count').val(count);
    //     $('#choice_communitygroup'+count).selectpicker('refresh');
    //     count++;
    // }
    function delete_row(count) {
        $('#choice_div'+count).remove();
        // $('#choice'+count).remove();
        // $('#priv_div'+count).hide();
        // $('#privilege_is_delete'+count).val('1');
    }
   
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    </script>
@endsection
