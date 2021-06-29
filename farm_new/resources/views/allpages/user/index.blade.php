@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">User</li>
@endsection

@php
/*
if(in_array("InsertUser", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))){ echo "true"; } else { echo "false"; }
*/
$user_priv = array();
if (session()->has('user_priv')) {
    $user_priv = session()->get('user_priv');
}
@endphp

@section('maincontent')

<div class="row">
    <div class="col-md-12">
        @include('common/flash_message')
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> User</h3>
                @if(in_array("InsertUser", array_column(json_decode($user_priv, true), 'privilege')))
                <a href="{{url('user/create')}}"><button class="btn btn-default pull-right">Create</button></a>
                @endif
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <!--<th>Role</th>-->
                            <!--<th>Collect Activity</th>-->
                            <!--<th>External Id</th>-->
                            <!--<th>Active</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $user_row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$user_row->name}}</td>
                            <td>{{$user_row->email}}</td>
                            <!--<td>-->
                            <!--    <ul>-->
                            <!--        @foreach($user_row->roles as $role)-->
                            <!--        <li>{{$role->name}}</li>-->
                            <!--        @endforeach-->
                            <!--    </ul>-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    <ul>-->
                            <!--        @foreach($user_row->collectactivities as $activity)-->
                            <!--        <li>{{$activity->name}}</li>-->
                            <!--        @endforeach-->
                            <!--    </ul>-->
                            <!--</td>-->
                            <!--<td>{{$user_row->external_id}}</td>-->
                            <!--<td>{{$user_row->is_active}}</td>-->
                            <td>
                                @if(in_array("EditUser", array_column(json_decode($user_priv, true), 'privilege')))
                                <a href="{{url('user/'.$user_row->id.'/edit')}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                                @endif
                                @if(in_array("DeleteUser", array_column(json_decode($user_priv, true), 'privilege')))
                                <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="ConfirmDelete({{$user_row->id}})"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
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
    <script>
        function ConfirmDelete(id){
            var token = $('#_token').val();
            var x = confirm("Are you sure you want to delete?");
            if (x){
                $.ajax({
                    url: '/user/'+id,
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