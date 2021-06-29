@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Collect Activity</li>
@endsection

@section('maincontent')

@php
$user_priv = array();
if (session()->has('user_priv')) {
    $user_priv = session()->get('user_priv');
}
@endphp

<style>
    
ol {
  margin:0 0 1.5em;
  padding:0;
  counter-reset:item;
}
 
ol>li {
  margin:0;
  padding:0 0 0 2em;
  text-indent:-2em;
  list-style-type:none;
  counter-increment:item;
}
 
ol>li:before {
  display:inline-block;
  width:1.5em;
  padding-right:0.5em;
  font-weight:bold;
  text-align:right;
  content:counter(item) ".";
}
    
</style>

<div class="row">
    <div class="col-md-12">
        @include('common/flash_message')
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> Collect Acitvity</h3>
                @if(in_array("InsertCollectActivity", array_column(json_decode($user_priv, true), 'privilege')))
                <a href="{{url('collectactivity/create')}}"><button class="btn btn-default pull-right">Create</button></a>
                @endif
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Collect Name</th>
                            <th>Community Group</th>
                            <!--<th>Result Name</th>-->
                            <!--<th>Units</th>-->
                            <!--<th>Type</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $collect_activity)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$collect_activity['name']}}</td>
                            <td>{{$collect_activity['communitygroup']}}</td>
                            <!--<td><ol>-->
                            <!--    @foreach($collect_activity['resultarray'] as $result)-->
                            <!--        <li>{{$result->result_name}}</li>-->
                            <!--    @endforeach-->
                            <!--</ol></td>-->
                            <!--<td><ol>-->
                            <!--    @foreach($collect_activity['resultarray'] as $result)-->
                            <!--        @php-->
                            <!--            $values = explode(",",$result->unit_name);-->
                            <!--        @endphp-->

                            <!--        @if(in_array("$result->unit_name", $values)) -->
                                       
                            <!--           <li>{{$result->unit_name}}</li>                        -->
                            <!--        @endif -->
                                   
                            <!--    @endforeach-->
                            <!--</ol></td>-->
                            <!--<td><ol>-->
                            <!--    @foreach($collect_activity['resultarray'] as $result)-->
                            <!--        <li>{{$result->type_id}}</li>-->
                            <!--    @endforeach-->
                            <!--</ol></td>-->
                            <td>
                                @if(in_array("EditCollectActivity", array_column(json_decode($user_priv, true), 'privilege')))
                                <a href="{{url('collectactivity/'.$collect_activity['id'].'/edit')}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                                @endif
                                @if(in_array("DeleteCollectActivity", array_column(json_decode($user_priv, true), 'privilege')))
                                <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete" onclick="ConfirmDelete({{$collect_activity['id']}})"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
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
                    url: '/collectactivity/'+id,
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
