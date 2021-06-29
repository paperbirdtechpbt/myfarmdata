@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Arch Container</li>
@endsection

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <!-- <form class="form-horizontal" id="add_form" method="post" action="/schoolsetting/school"> -->
            <form class="form-horizontal" id="add_form" method="post"  action="{{route('containerarch.update',$container->id)}}" >
                @method('PUT')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Edit</strong> Arch Container</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('containerarch')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row"   id="object_row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Type</label>
                                        <div class="col-md-9">
                                            <select  class="form-control select" name="c_id" id="c_id">
                                                <option value="">select</option>
                                                @foreach($containers as $key=>$value)
                                                    <option value="{{$value->id}}" {{$container->container_no == $value->id ? "selected" : "" }} >{{$value->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                             @error('name')
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
                                            <input type="text" class="form-control" name="object_name" id="object_name" value="{{$container->object_name}}">
                                            {{csrf_field()}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object No</label>
                                        <div class="col-md-12">
                                            <input type="number" class="form-control" name="object_no" id="object_no"  value="{{$container->object_no}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-md-12">Object Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control select" name="object_type" id="object_type">
                                                <option value="">select</option>
                                                @foreach($object_type as $value)<option value="{{$value->id}}" {{ $container->type == $value->id ? "selected" : "" }} >{{$value->name}}</option>@endforeach
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
                                                @foreach($object_class as $value)<option value="{{$value->id}}" {{ $container->class == $value->id ? "selected" : "" }} >{{$value->name}}</option>@endforeach
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
   
    // $('#name').val('test');
    // $('#email').val('a@gmail.com');
    // $('#contact').val('9865320147');
    // $('#address').val('aaa');
    
    
    
    </script>
@endsection
