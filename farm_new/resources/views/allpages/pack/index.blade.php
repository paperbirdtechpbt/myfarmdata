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
                <a href="{{url('pack/create')}}"><button class="btn btn-default pull-right">Create</button></a>
            </div>
            <div class="panel-body">

                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Creation Date</th>
                            <th>Species</th>
                            <th>Quantity</th>
                            <th>Units</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($packs as $pack)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pack->creation_date}}</td>
                            <td>{{$pack->species}}</td>
                            <td>{{$pack->quantity}}</td>
                            <td>{{$pack->unit['name']}}</td>
                            <td>
                                <form method="post" action="{{route('pack.destroy',$pack->id)}}">
                                    <a href="{{route('pack.edit',$pack->id)}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                               
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" value="delete" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o" style="color: #E04B4A"></i></button>
                                </form>                        
                            </td>
                            <td>
                                <input type="checkbox" class="toggle-class" data-id="{{$pack->id}}" data-toggle="toggle" data-on="Active" data-off="InActive" {{$pack->is_active==true ? 'checked' :''}}>
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
            var pack_id=$(this).data('id');
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'{{route("changeStatus")}}',
                data:{'status': status, 'pack_id':pack_id},
                success:function(data){
                    alert(data.success);
                }
            });
        });
    </script>
@endsection
