@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Pack</li>
@endsection

@section('maincontent')

<div class="row">
    <div class="col-md-12">
        @include('common/flash_message')
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> Pack</h3>
                @if(in_array("InsertPack", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')))
                <a href="{{url('pack/create')}}"><button class="btn btn-default pull-right">Create</button></a>
                @endif
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pack Number</th>
                            <th>Creation Date</th>
                            <th>Species</th>
                            <th>Quantity</th>
                            <th>Units</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($packs as $pack)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pack->id}}</td>
                            <td>{{$pack->creation_date}}</td>
                            <td>{{$pack->species}}</td>
                            <td>{{$pack->quantity}}</td>
                            <td>{{$pack->unit['name']}}</td>
                            <td>
                                <input type="checkbox" class="toggle-class" data-id="{{$pack->id}}" data-toggle="toggle" data-on="Active" data-off="InActive" {{$pack->status==true ? 'checked' :''}}>
                                <form method="post" action="{{route('pack.destroy',$pack->id)}}">
                                    @if(in_array("EditPack", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')))
                                    <a href="{{route('pack.edit',$pack->id)}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                                    @endif
                                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                    @method('DELETE')
                                    @if(in_array("DeletePack", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')))
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
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
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
        $(function(){
            $('#toggle-two').bootstrapToggle({
                on:'Active',
                off:'InActive'
            });
        });
        $('.toggle-class').on('change',function(){
            var status=$(this).prop('checked')==true ? 1 :0;
            // alert(status);
            var pack_id=$(this).data('id');
            // var token = $('#_token').val();
            // $.ajax({
            //     url: '/changeStatus',
            //     data: {_token:token, is_active:status, pack_id:pack_id },
            //     type: 'POST',
            //     success: function(data) {
            //         alert(data);
            //         // var response = JSON.parse(data);
            //         // alert(response.message);
            //         // location.reload();
            //         $('.row').append(data);
            //     },
            //     error: function() {
            //         alert('something bad happened');
            //     }
            // });
            $.ajax({
                type:'GET',
                // dataType:'json',
                url:'{{route("changeStatus")}}',
                data:{'status': status, 'pack_id':pack_id},
                success:function(data){
                    // alert(data);
                    alert(data.success);
                    // alert(data.queries);
                }
            });
        });
    </script>
@endsection
