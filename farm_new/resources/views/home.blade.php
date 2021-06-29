@extends('mainlayout')

@php
//$cookiename = 'userlogin_roleid';
//echo $value = Cookie::get($cookiename);
@endphp

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Dashboard</li>
@endsection

@section('maincontent')

<div class="row">
    <div class="col-md-12">
        <!-- TABS WIDGET -->
        @if(count($dashboardsettings) > 0)
        <div class="panel panel-default tabs">
            <ul class="nav nav-tabs nav-justified">
                @foreach($dashboardsettings as $dashboardsetting)
                <li class=" @php if ($loop->index == '0') { echo "active"; } @endphp"><a href="#tab{{$loop->index}}" data-toggle="tab">{{$dashboardsetting->name}}</a></li>
                @endforeach
            </ul>
            <div class="panel-body tab-content">
                @foreach($dashboardsettings as $dashboardsetting) 
               
                <div class="tab-pane @php if ($loop->index == '0') { echo "active"; } @endphp" id="tab{{$loop->index}}">
                    <input type="hidden" value="{{$dashboardsetting->id}}" name="dashboard_setting[]"  id = "dashboard_setting{{$loop->index}}">
                    <h3 style="text-align:center">{{$dashboardsetting->title}}</h3>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Pack Number</label>
                            <div class="col-md-9">
                                <!--<select class="form-control select" multiple name="pack_id[]" id="pack_id{{$loop->index}}" onchange="getChartDetail({{$loop->index}},this.value);">-->
                                <select class="form-control select pack_id" multiple name="pack_id[]" id="pack_id{{$loop->index}}" >
                                    @foreach($packs as $value)<option value="{{$value->id}}">{{sprintf('%04d', $loop->iteration)}}</option>@endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 row" id="chartdiv{{$loop->index}}">
                        <!--<div class="col-md-6">-->
                        <!--    <div id="morris-line-example" style="height: 300px;"></div>-->
                        <!--</div> -->
                    </div>
                    
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <!-- END TABS WIDGET -->
    </div>
</div>
<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

@endsection

@section('javascript')
<script type="text/javascript">
    $( ".pack_id" ).change(function() {
        
        var token = $('#_token').val();
            pack_id = $(this).val();
            
            count = $(this).attr('id').replace('pack_id','');
            dashboard_setting = $('#dashboard_setting'+count).val();
        
        if(pack_id == null){
            $('#chartdiv'+count).html('');
            return false;
        }
        $.ajax({
            url: '/getchartdetail',
                data: {'pack_id':pack_id,'dashboard_setting_id':dashboard_setting, _token:token },
                type: 'POST',
                success: function(data) {
                    console.log(data);
                    
                    var res = JSON.parse(data);
                    var htmlData = '';
                    if(res.charts.length > 0){
                        $.each(res.charts, function(k, v){
                            htmlData += '<div class="col-md-12"><h3 style="text-align: center;text-decoration-line: underline;margin: 17px;">'+v.graph_name+'</h3>';
                            
                            $.each(v.packs, function(k1, v1) {
                                var  point_count = false; 
                                $.each(v1.lines, function(k2, v2) {
                                    var points = v2.points;
                                    if(points.length > 0){
                                        $.each(points, function(k3, v3) {
                                            //alert(v3);
                                        });
                                        point_count = true;
                                    }
                                });
                                if(point_count == true){
                                    var pack_txt = $("#pack_id"+count+" option[value="+v1.id+"]").text();
                                    htmlData += '<div class="col-md-4">';
                                        htmlData += '<div class="panel panel-default" >';
                                            htmlData += '<div class="panel-heading">'+v.graph_name+' - Pack Number '+pack_txt+'</div>';
                                            htmlData += '<div class="panel-body">';
                                                htmlData += '<div id="line_'+dashboard_setting+'_'+v.id+'_'+v1.id+'" style="height: 300px;"></div>';
                                            htmlData += '</div>';
                                        htmlData += '</div>';
                                    htmlData += '</div>';
                                    
                                }    
                            });
                            
                            htmlData +='</div>';
                            $('#chartdiv'+count).html(htmlData);
                        });
                        
                        $.each(res.charts, function(k, v){
                            var graph_ordinate_title = v.graph_ordinate_title;
                            var graph_abcissa_title = v.graph_abcissa_title;
                            $.each(v.packs, function(k1, v1) {
                                
                                var data_arr = [];
                                    linename_arr = [];
                                    ykeys_arr = [];
                                    
                                var point_count = false;
                                var loop = 1;
                                var line_count = v1.lines.length;
                                $.each(v1.lines, function(k2, v2) {
                                    
                                    var line_name = 'line '+loop;
                                        ykeys_arr.push(line_name);
                                        linename_arr.push(v2.name+' ('+graph_ordinate_title +')');
                            
                                    var points = v2.points;
                                    if(points.length > 0){
                                       
                                        $.each(points, function(k3, v3) {
                                            var j = 1;
                                            var obj = {};
                                            if(v3.duration != null){
                                                
                                               obj['y'] = (v3.duration).toString();
                                            
                                                $.each(v1.lines, function(k2, v2) {
                                                    if(loop == j){
                                                        obj['line '+j] = v3.value;
                                                    }else{
                                                        obj['line '+j] = null;
                                                    }
                                                    j++;
                                                });
                                                
                                                data_arr.push(obj); 
                                            }
                                            
                                        });
                                        point_count = true;
                                    }
                                    loop++;
                                });
                                console.log(data_arr);

var new_arr = [];
$.each(data_arr, function(k, v) {
    var index_value = -1;
    var found = new_arr.some((el) => {
        index_value = new_arr.indexOf(el);// -1
        return el.y === v.y;
    });
    
    // console.log(found);
    // console.log(index_value);
    if(found == false){
        var obj = {};
        $.each(v, function(k1, v1) {
            obj[k1] = v1;
        });
        new_arr.push(obj);
    }else{
        console.log(new_arr[index_value]);
        if(index_value != -1){
            
        //   myArray[objIndex].name = "Laila"
            $.each(new_arr[index_value], function(k1, v1) {
                console.log(k1 +':'+v1);
                if(v1 == null){
                    console.log(new_arr[index_value].k1); 
                   new_arr[index_value][k1] = v[k1]; 
                }
                // obj[k1] = v1;
            });
        }
       
    }
    
});
                               
data_arr1 = new_arr.sort(function(a, b){
    var a1= parseFloat(a.y), b1= parseFloat(b.y);
    if(a1== b1) return 0;
    return a1> b1? 1: -1;
});
console.log(new_arr);





                                if(point_count == true){
                                    Morris.Line({
                                        element:'line_'+dashboard_setting+'_'+v.id+'_'+v1.id,
                                        data: data_arr1,
                                        xkey: 'y',
                                        ykeys: ykeys_arr,
                                        labels: linename_arr,
                                        resize: false,
                                        parseTime: false,
                                        hoverCallback: function(index, options, content, row) {
                                            var data = options.data[index]; 
                                            var htmlData = '<div class="morris-hover-row-label">'+graph_abcissa_title+' : '+data.y+'</div>';
                                            
                                            $.each(options.ykeys, function(k, v) {
                                                if(data[v] != null){
                                                     htmlData += '<div class="morris-hover-point">'+options.labels[k]+': '+data[v]+'</div>';
                                                }
                                            });
                                           
                                            return htmlData;

                                        },
                                        // xLabelFormat: function(x){ console.log(x);return x;},
                                        
                                    });
                                    
                                }    
                            });
                            
                    
                            
                        });
                        
                    }else{
                       htmlData = '';
                       $('#chartdiv'+count).html(htmlData);
                    }
                    
                    // if(res.packs.length > 0){
                    // $.each(res.packs, function(key, value) {
                        
                    //     var  point_count = false; 
                    //     $.each(value.dashboard_setting, function(k, v) {
                            
                    //         $.each(v.lines, function(k1, v1) {
                                
                    //             var points = v1.points;
                    //             if(points.length > 0){
                                    
                    //                 $.each(points, function(k2, v2) {
                    //                     //alert(v3);
                    //                 });
                                    
                    //             point_count = true;   
                    //             }
                                
                    //         });
                            
                    //     });
                        
                    //     if(point_count == true){
                    //         var pack_txt = $("#pack_id"+count+" option[value="+value.id+"]").text();
                    //         htmlData += '<div class="col-md-6"><div class="col-md-12" id="line_'+dashboard_setting+'_'+pack_id+'" style="height: 300px;"></div><div class="col-md-12">Pack Number '+pack_txt+'</div></div>';
                    //     }
                    //     $('#chartdiv'+count).html(htmlData);
                    // });
                    
                    // }
                    
                    return false;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('error : '+xhr.responseText);
                    alert('something bad happened');
                }
            });
    //   alert($(".page-content").height());
    });
    
    function addOrreplace(){
        
    }

</script>
@endsection 
