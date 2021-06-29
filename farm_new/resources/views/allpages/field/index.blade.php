@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Field</li>
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
                <h3 class="panel-title"><strong>View</strong> Field</h3>
                @if(in_array("InsertField", array_column(json_decode($user_priv, true), 'privilege')))
                <a href="{{url('field/create')}}"><button class="btn btn-default pull-right">Create</button></a>
                @endif
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <!--<th>Country</th>-->
                            <!--<th>Region</th>-->
                            <!--<th>Locality</th>-->
                            <!--<th>Surface Area</th>-->
                            <!--<th>Plants</th>-->
                            <!--<th>Community Group</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fields as $field)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$field->name}}</td>
                            <td>{{$field->description}}</td>
                            <!--<td>{{$field->country}}</td>-->
                            <!--<td>{{$field->region}}</td>-->
                            <!--<td>{{$field->locality}}</td>-->
                            <!--<td>{{$field->surface_area.' '.$field->area_unit}}</td>-->
                            <!--<td>{{$field->number_of_plant}}</td>-->
                            <!--<td>{{$field->communitygroup}}</td>-->
                            <td>
                                @if(in_array("EditField", array_column(json_decode($user_priv, true), 'privilege')))
                                <a href="{{url('field/'.$field->id.'/edit')}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                                @endif
                                @if(in_array("DeleteField", array_column(json_decode($user_priv, true), 'privilege')))
                                <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="ConfirmDelete({{$field->id}})"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
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
                    url: '/field/'+id,
                    data: {_method:'DELETE', _token:token },
                    type: 'POST',
                    success: function(data) {
                        var response = JSON.parse(data);
                        // alert(response.message);
                        // location.reload();
                        $('#del_success').show();
                        setTimeout(function(){ location.reload(); }, 2000);
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
