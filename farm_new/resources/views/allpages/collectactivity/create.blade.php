@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Collect Activity</li>
@endsection


@section('maincontent')
    <style>
        .input-group{
            margin:5px;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" action="{{route('collectactivity.store')}}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create</strong> Collect Activity</h3>
                        <ul class="panel-controls">
                            <li><a href="{{url('collectactivity')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="row_tag">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Collect Name</label>
                                        <div class="col-md-9">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="communitygroup" id="communitygroup">
                                                <option value="">select</option>
                                                @foreach($communitygrp as $value)<option value="{{$value->id}}" >{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <div class="form-group" id="form_group_div0">
                                    <div class="col-md-2">
                                        <!--<div class="input-group">-->
                                        <!--    <span class="input-group-btn">-->
                                        <!--        <button class="btn btn-default marker_click" type="button">Result Name</button>-->
                                        <!--    </span>-->
                                        <!--    <input type="text" class="form-control multifieldvalidation" name="result_name[]" id="result_name" style="">-->
                                        <!--</div>-->
                                        <label>Result Name</label>
                                        <input type="text" class="form-control multifieldvalidation" name="result_name[]" id="result_name0" style="">
                                    </div>
                                    <div class="col-md-2">
                                        <!--<div class="input-group">-->
                                        <!--    <span class="input-group-btn">-->
                                        <!--        <button class="btn btn-default marker_click" type="button">Result Class</button>-->
                                        <!--    </span>-->
                                        <!--    <input type="text" class="form-control multifieldvalidation" name="result_class[]" id="result_class" style="">-->
                                        <!--</div>-->
                                        <label>Result Class</label>
                                        <input type="text" class="form-control " name="result_class[]" id="result_class0" style="">
                                    </div>
                                    <div class="col-md-2">
                                        <!--<div class="input-group">-->
                                        <!--    <span class="input-group-btn">-->
                                        <!--        <button class="btn btn-default marker_click" type="button">Units</button>-->
                                        <!--    </span>-->
                                            <!--<input type="text" class="form-control" name="unit_id0" id="unit_id0" style="">-->
                                        <!--    <select multiple class="form-control multifieldvalidation select" name="unit_id[0][]" id="unit_id[]">-->
                                                
                                        <!--    @foreach($unit as $key=>$value)-->
                                        <!--        <option value="{{$key}}">{{$value}}</option>-->
                                        <!--    @endforeach-->
                                        <!--    </select>-->
                                        <!--</div>-->
                                        <label>Units</label>
                                            <select multiple class="form-control multifieldvalidation select" name="unit_id[0][]" id="unit_id0">
                                                
                                            @foreach($unit as $key=>$value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                            </select>
                                    </div>
                                    <div class="col-md-2">
                                        <!--<div class="input-group">-->
                                        <!--    <span class="input-group-btn">-->
                                        <!--        <button class="btn btn-default marker_click" type="button">Type</button>-->
                                        <!--    </span>-->
                                        <!--    <select class="form-control multifieldvalidation select " name="type_id[]" id="type_id" value="" onchange="showtext(this.value,0);">-->
                                        <!--        <option value="">Select</option>-->
                                        <!--        <option value="text">Text</option>-->
                                        <!--        <option value="numeric">Numeric</option>-->
                                        <!--        <option value="date">Date</option>-->
                                        <!--        <option value="list">List</option>-->
                                        <!--    </select>-->
                                        <!--</div>-->
                                        <label>Type</label>
                                            <select class="form-control multifieldvalidation select " name="type_id[]" id="type_id0" value="" onchange="showtext(this.value,0);">
                                                <option value="">Select</option>
                                                <option value="text">Text</option>
                                                <option value="numeric">Numeric</option>
                                                <option value="date">Date</option>
                                                <option value="list">List</option>
                                            </select>
                                    </div>
                                    
                                    <div class="col-md-2" id="listdiv0">
                                        
                                    </div>
                                    
                                    
                                    <div class="col-md-2">
                                         <input type="hidden" name="is_delete[]" id="is_delete0" value="0">
                                        <button1 class="btn btn-default" id="add_btn" onclick="add_row()" style="float:right;margin:20px;"><i class="fa fa-pencil" ></i> Add New</button1>
                                        <button1 class="btn btn-default" id="remove_btn0" onclick="remove_row(0)" style="display: none;"><i class="fa fa-times"></i> Remove</button1>
                                    </div>
                                    <hr/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="result_count" id="result_count" value="1">
                        <!-- <input type="hidden" name="unit_id[]" id="unit_id[]" value=""> -->
                       
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
    $(document).ready(function() {
       
        $('input.multifieldvalidation').each(function() {
            $(this).rules("add", { required: true }) 
        });
        $('select.multifieldvalidation').each(function() {
            $(this).rules("add", { required: true }) 
        });
        
    });
    var jvalidate = $("#add_form").validate({
         ignore: ":hidden",
        rules: {
            name: {
                required: true,
            },
            communitygroup: {
                required: true,
            },
            // unit_id: {
            //     required: true,
            // },
            // result_name: {
            //     required: true,
            // },
            // type_id: {
            //     required: true,
            // },
        },
        // submitHandler: function(form){
        //     alert('helloo submitHandler123');
        // }
    });

    var count = 1;

    function add_row() {
        var html_data = '';
        // html_data += '<div class="col-md-12" id="colmd'+count+'" style="margin-top: 20px;"><div class="form-group">';
        // html_data += '<div class="col-md-4"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default marker_click" type="button">Result Name</button></span><input type="text" class="form-control multifieldvalidation" name="result_name[]'+count+'" id="result_name'+count+'" style=""></div></div>';
        // html_data += '<div class="col-md-4"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default marker_click" type="button">Result Class</button></span><input type="text" class="form-control multifieldvalidation" name="result_class[]'+count+'" id="result_class'+count+'" style=""></div></div>';
        // html_data += '<div class="col-md-4"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default marker_click" type="button">Units</button></span><select multiple class="form-control multifieldvalidation select" name="unit_id['+count+'][]" id="unit_id'+count+'"> @foreach($unit as $key=>$value)<option value="{{$key}}">{{$value}}</option>@endforeach</select></div></div>';
        // // html_data += '<div class="col-md-3"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default marker_click" type="button">Type</button></span><input type="text" class="form-control multifieldvalidation" name="type_id[]'+count+'" id="type_id[]'+count+'" style=""></div></div>';
        // html_data += '<div class="col-md-4"><div class="input-group"><span class="input-group-btn"><button class="btn btn-default marker_click" type="button">Type</button></span><select class="form-control multifieldvalidation select " name="type_id[]" id="type_id"  onchange="showtext(this.value,'+count+');"><option value="">Select</option><option value="text">Text</option><option value="numeric">Numeric</option><option value="date">Date</option><option value="list">List</option></select></div></div>';
        // html_data += '<div class="col-md-4" id="listdiv'+count+'"></div>';
        // html_data += '<div class="col-md-4"><input type="hidden" name="is_delete'+count+'" id="is_delete'+count+'" value="0"><button1 class="btn btn-default" id="remove_btn0" onclick="remove_row('+count+')" style="float:right;"><i class="fa fa-times"></i> Remove</button1></div>';
        // html_data += '</div></div>';
        
        html_data += '<div class="col-md-12" id="colmd'+count+'" style="margin-top: 20px;"><div class="form-group">';
        html_data += '<div class="col-md-2"><label>Result Name</label><input type="text" class="form-control multifieldvalidation" name="result_name[]'+count+'" id="result_name'+count+'" style=""></div>';
        html_data += '<div class="col-md-2"><label>Result Class</label><input type="text" class="form-control " name="result_class[]'+count+'" id="result_class'+count+'" style=""></div>';
        html_data += '<div class="col-md-2"><label>Units</label><select multiple class="form-control multifieldvalidation select" name="unit_id['+count+'][]" id="unit_id'+count+'"> @foreach($unit as $key=>$value)<option value="{{$key}}">{{$value}}</option>@endforeach</select></div>';
        html_data += '<div class="col-md-2"><label>Type</label><select class="form-control multifieldvalidation select " name="type_id[]" id="type_id'+count+'"  onchange="showtext(this.value,'+count+');"><option value="">Select</option><option value="text">Text</option><option value="numeric">Numeric</option><option value="date">Date</option><option value="list">List</option></select></div>';
        html_data += '<div class="col-md-2" id="listdiv'+count+'"></div>';
        html_data += '<div class="col-md-2"><input type="hidden" name="is_delete[]" id="is_delete'+count+'" value="0"><button1 class="btn btn-default" id="remove_btn0" onclick="remove_row('+count+')" style="float:right;margin:20px;"><i class="fa fa-times"></i> Remove</button1></div>';
        html_data += '</div></div>';
        
        $('#row_tag').append(html_data);
        $('#result_count').val(count);
        count++;
        $('input.multifieldvalidation').each(function() {
            $(this).rules("add", { required: true }) 
        });
        $('select.multifieldvalidation').each(function() {
            $(this).rules("add", { required: true }) 
        });
        // feSelect();
        if($(".select").length > 0){
                $(".select").selectpicker();
                
                $(".select").on("change", function(){
                    if($(this).val() == "" || null === $(this).val()){
                        if(!$(this).attr("multiple"))
                            $(this).val("").find("option").removeAttr("selected").prop("selected",false);
                    }else{
                        $(this).find("option[value="+$(this).val()+"]").attr("selected",true);
                    }
                });
            }
    }
    function remove_row(count) {
        $('#colmd'+count).hide();
        $('#is_delete'+count).val(1);
        $('#result_name'+count).val(0);
        $('#unit_id'+count).html('<option value="0" selected>DUMMY</option>');
        $('#type_id'+count).val();
    }
    
    function showtext(val,row) {
        
        var htmlData = '';
            // htmlData += '<div class="input-group" id="listgroup'+row+'"><span class="input-group-btn"><button class="btn btn-default marker_click" type="button">List</button></span>';
            // htmlData += '<label>List</label>';
            // htmlData += '<select class="form-control select " name="list_id[]" id="list_id'+row+'" ><option value="">Select</option>';
            // @foreach($lists as $key=>$value)
            // htmlData += '<option value="{{$value->id}}">{{$value->name}}</option>';
            // @endforeach
            // htmlData += '</select>';
            // htmlData += '</div>';
        
        $('#listdiv'+row).html(htmlData);
        if(val == 'list'){
            htmlData += '<label>List</label>';
            htmlData += '<select class="form-control select " name="list_id[]" id="list_id'+row+'" ><option value="">Select</option>';
            @foreach($lists as $key=>$value)
            htmlData += '<option value="{{$value->id}}">{{$value->name}}</option>';
            @endforeach
            htmlData += '</select>';
            $('#listdiv'+row).html(htmlData);
            $('#list_id'+row).selectpicker('refresh');
        }else{
            htmlData += '<input type="hidden" name="list_id[]" id="list_id'+row+'" >';
            $('#listdiv'+row).html(htmlData);
        }
        
        
    }
   

    //  $("#unitid[]").change(function(){
    //     $('#unit_id[]').val($("#unitid[]").val());
    // });
     
    // $('#name').val('test');
    // $('#result_name0').val('asdf');
    // $('#unit_id0').val('1');
    // $('#type_id0').val('1');
    </script>
@endsection
