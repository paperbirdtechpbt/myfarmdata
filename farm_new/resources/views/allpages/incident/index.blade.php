@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Incident</li>
@endsection

@section('maincontent')

@php
$user_priv = array();
if (session()->has('user_priv')) {
    $user_priv = session()->get('user_priv');
}

@endphp
<style>

</style>
<div class="row">
    <div class="col-md-12">
        @include('common/flash_message')
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> Incident </h3>
                @if(in_array("InsertIncident", array_column(json_decode($user_priv, true), 'privilege')))
                <a href="{{url('incident/create')}}"><button class="btn btn-default pull-right">Create</button></a>
                @endif
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            
                            <th>Action</th>
                            <th>Status</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incidents as $incident)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$incident->title}}</td>
                            <td>{{$incident->description}}</td>
                            <!--<td>{{$incident->status}}</td>-->
                            <td>
                                @if(in_array("CloseIncident", array_column(json_decode($user_priv, true), 'privilege')))
                                <a href="{{url('incident/'.$incident->id.'/edit')}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                               
                                <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="ConfirmDelete({{$incident->id}})"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
                            </td>
                            <td>
                                @if($incident->status != 'CLOSED')
                                    <input type="checkbox" class="toggle-class" data-id="{{$incident->id}}" data-toggle="toggle" data-on="Closed" data-off="{{$incident->status}}" {{$incident->status=='CLOSED' ? 'checked' :''}}>
                                    @else
                                    <input  disabled type="checkbox" class="switch notoggle" data-id="{{$incident->id}}" data-toggle="toggle" data-on="Closed" data-off="{{$incident->status}}" {{$incident->status=='CLOSED' ? 'checked' :''}}>
                                    @endif
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
    (function($) {
        $.fn.toggleDisabled = function(){
            return this.each(function(){
                this.disabled = !this.disabled;
                
            });
        };
    })(jQuery);
    
        $('.toggle-class').on('change',function(evt){
            var on = $(this).attr("data-on");
            var off = $(this).attr("data-off");
            var status=$(this).prop('checked')==true ? on :off;
            var id=$(this).data('id');
            var val = 0;
            
            
            $.ajax({
                type:'GET',
                dataType:'json',
                async: false,
                url:'{{route("incidentChangeStatus")}}',
                data:{'status': status, 'id':id},
                success:function(data){
                    val = 1;
                    alert(data.success);
                }
            });
            if(val == 1){
                $(this).toggleDisabled();
                $(this).parent().attr('disabled','disabled');
            }
            
        
        });
        function ConfirmDelete(id){
            var token = $('#_token').val();
            var x = confirm("Are you sure you want to delete?");
            if (x){
                $.ajax({
                    url: '/incident/'+id,
                    data: {_method:'DELETE', _token:token },
                    type: 'POST',
                    success: function(data) {
                        var response = JSON.parse(data);
                        alert(response.message);
                        location.reload();
                    },
                    error: function() {
                        alert('something bad happened');
                    }
                });
            }
        }
    </script>
@endsection
