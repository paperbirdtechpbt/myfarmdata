@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Zone</li>
@endsection

@section('maincontent')

@php
$user_priv = array();
if (session()->has('user_priv')) {
    $user_priv = session()->get('user_priv');
}
@endphp

<div class="row">
    <div class="col-md-12">
        @include('common/flash_message')
        <div class="alert alert-danger alert-block" id="del_success" style="display:none;">
            <strong>Success! </strong>Deleted Successfully
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> Zone</h3>
                @if(in_array("InsertZone", array_column(json_decode($user_priv, true), 'privilege')))
                <a href="{{url('zone/create')}}"><button class="btn btn-default pull-right">Create</button></a>
                @endif
                
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <!--<th>Type</th>-->
                            <!--<th>Class</th>-->
                            <!--<th>Community Group</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($zones as $zone)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$zone->name}}</td>
                            <td>{{$zone->description}}</td>
                            <!--<td>{{$zone->type_name}}</td>-->
                            <!--<td>{{$zone->class_name}}</td>-->
                            <!--<td>{{$zone->com_name}}</td>-->
                            <td>
                                @if(in_array("EditZone", array_column(json_decode($user_priv, true), 'privilege')))
                                <a href="{{url('zone/'.$zone->no.'/edit')}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                                @endif
                                @if(in_array("DeleteZone", array_column(json_decode($user_priv, true), 'privilege')))
                                <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="ConfirmDelete({{$zone->no}})"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
                                @endif
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                            </td>
                           
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        function ConfirmDelete(id){
            var token = $('#_token').val();
            var x = confirm("Are you sure you want to delete?");
            if (x){
                $.ajax({
                    url: '/zone/'+id,
                    data: {_method:'DELETE', _token:token },
                    type: 'POST',
                    success: function(data) {
                        var response = JSON.parse(data);
                       
                        $('#del_success').show();
                        setTimeout(function(){ location.reload(); }, 2000);
                    },
                    error: function() {
                        alert('something bad happened');
                    }
                });
            }
        }
        
    </script>
@endsection
