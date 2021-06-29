@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Notification</li>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> Notification </h3>
                @if(in_array("InsertEvent", array_column(json_decode($user_priv, true), 'privilege')))
                <!--<a href="{{url('event/create')}}"><button class="btn btn-default pull-right">Create</button></a>-->
                @endif
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Notification Msg</th>
                            <th>Type</th>
                            <th>Level</th>
                            <th>Result Name</th>
                            <th>Status</th>
                            <!--<th>Closed</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$notification->message}}</td>
                            <td>{{$notification->type_name}}</td>
                            <td>{{$notification->level_name}}</td>
                            <td>{{$notification->result_name}}</td>
                            <!--<td>{{$notification->status}}</td>-->
                            <!--<td>{{$notification->closed}}</td>-->
                            <td>
                                @if($notification->closed != 'F')
                                    <input type="checkbox" class="toggle-class" data-id="{{$notification->id}}" data-toggle="toggle" data-on="Closed" data-off="{{$notification->status}}" {{$notification->closed=='F' ? 'checked' :''}}>
                                    @else
                                    <input disabled type="checkbox" class="toggle-class" data-id="{{$notification->id}}" data-toggle="toggle" data-on="Closed" data-off="{{$notification->status}}" {{$notification->closed=='F' ? 'checked' :''}}>
                                    
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
            var status=$(this).prop('checked')==true ? 'F' :'T';
            var id=$(this).data('id');
            var val = 0;
            
            
            $.ajax({
                type:'GET',
                dataType:'json',
                async: false,
                url:'{{route("notificationChangeStatus")}}',
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
                    url: '/event/'+id,
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
