@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Sensor</li>
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
                <h3 class="panel-title"><strong>View</strong> Sensor</h3>
                @if(in_array("InsertSensor", array_column(json_decode($user_priv, true), 'privilege')))
                <a href="{{url('sensor/create')}}"><button class="btn btn-default pull-right">Create</button></a>
                @endif
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sensor Type</th>
                            <th>Sensor Name</th>
                            <th>Id</th>
                            <th>Model</th>
                            <th>Brand</th>
                            <th>Ip</th>
                            <th>Owner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($sensors as $sensor)
                        
                        <tr>
                            <td>{{ $no++}}</td>
                            <td>{{$sensor->sensor_type_name}}</td>
                            <td>{{$sensor->name}}</td>
                            <td>{{$sensor->sensorId}}</td>
                            <td>{{$sensor->model}}</td>
                            <td>{{$sensor->brand}}</td>
                            <td>{{$sensor->sensorIp}}</td>
                            <td>{{$sensor->user_name}}</td>
                            <td>
                                <!--<a href="{{route('sensor.edit',$sensor->id)}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>-->
                                @if(in_array("EditSensor", array_column(json_decode($user_priv, true), 'privilege')))
                                <a href="{{route('sensor.edit',$sensor->id)}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                                @endif
                                <form method="post" action="{{route('sensor.destroy',$sensor->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    @if(in_array("DeleteSensor", array_column(json_decode($user_priv, true), 'privilege')))
                                    <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
                                    @endif
                                </form>
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
    <script>
        function ConfirmDelete(id){
            var token = $('#_token').val();
            var x = confirm("Are you sure you want to delete?");
            if (x){
                $.ajax({
                    url: '/schoolsetting/school/'+id,
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
        function notyConfirm(){
            noty({
                text: 'Do you want to continue?',
                layout: 'topRight',
                buttons: [
                    {addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
                            $noty.close();
                            noty({text: 'You clicked "Ok" button', layout: 'topRight', type: 'success'});
                        }
                    },
                    {addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
                            $noty.close();
                            noty({text: 'You clicked "Cancel" button', layout: 'topRight', type: 'error'});
                        }
                    }
                ]
            })
        }
    </script>
@endsection
