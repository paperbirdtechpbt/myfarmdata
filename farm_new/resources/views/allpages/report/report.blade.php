@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Report</li>
@endsection

@section('maincontent')

<div class="row">
    <div class="col-md-12">
        @include('common/flash_message')
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>View</strong> Report</h3>
                <!--<a href="{{url('collectdata/create')}}"><button class="btn btn-default pull-right">Create</button></a>-->
            </div>
            <div class="panel-body">
                <div class="row" style="margin-bottom: 30px;">
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-btn"><button class="btn btn-default" type="button">Search Pack</button></span>
                                <select class="form-control select" name="pack_id" id="pack_id" onchange="getPackReportData(this.value)">
                                    <option value="">select</option>
                                    @foreach($packs as $pack_data)
                                        <option value="{{$pack_data->id}}">{{$pack_data->species}}</option>
                                    @endforeach
                                    <!--<option value="true">result1</option>-->
                                    <!--<option value="false">result2</option>-->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                                        
                <table class="table datatable table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pack Number</th>
                            <th>Value Units</th>
                            <th>Sensors</th>
                            <th>User Collecting</th>
                            <th>Date Time Collected</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody id="tbody_tag">
                        <tr>
                            <td>1</td>
                            <td>001</td>
                            <td>unit1</td>
                            <td>sensor1</td>
                            <td>name1</td>
                            <td>2020-01-01</td>
                            <!-- <td>
                                <a href="{{url('collectdata/1/edit')}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: #1caf9a"></i></a>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

@endsection

@section('javascript')
    <script>
        function getPackReportData(id){
            var token = $('#_token').val();
            $.ajax({
                url: '/getPackReportData',
                data: {pack_id:id, _token:token },
                type: 'POST',
                success: function(data) {
                    // alert(data);
                    var response = JSON.parse(data);
                    var html_data = '';
                    // alert(response.length);
                    for(var i=0; i<response.length; i++){
                        html_data += '<tr>';
                        html_data += '<td>'+response[i].id+'</td>';
                        html_data += '<td>'+response[i].id+'</td>';
                        html_data += '<td>'+response[i].unit_name+'</td>';
                        html_data += '<td>'+response[i].sensor_name+'</td>';
                        html_data += '<td>'+response[i].user_name+'</td>';
                        html_data += '<td>'+response[i].created_at+'</td>';
                        html_data += '</tr>';
                    }
                    // alert(html_data);
                    $('#tbody_tag').html(html_data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
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
