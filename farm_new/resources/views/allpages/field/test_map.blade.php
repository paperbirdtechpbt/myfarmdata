@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Field</li>
@endsection

@php

@endphp

@section('maincontent')

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" enctype="multipart/form-data" action="/field">
                <div class="panel panel-colorful">
                    <div class="panel-heading">
                        <!--<h3 class="panel-title">Google Map</h3>-->
                        <h3 class="panel-title"><strong>Create</strong> Field</h3>
                        <ul class="panel-controls pull-right">
                            <li><a href="{{url('field')}}"><span class="fa fa-times"></span></a></li>
                        </ul>
                        <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#modal_basic">Add Field</button>
                        <div class="col-md-6 col-xs-12 pull-right">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default marker_click" type="button" style="cursor: default;">Search Location</button>
                                </span>
                                <input type="text" class="form-control" id="pac-input">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body panel-body-map">
                        <div id="google_map" style="width: 100%; height: 300px; margin-bottom: 30px;"></div>
                    </div>
                    <!--<div class="panel-footer">-->
                    <!--    <button1 class="btn btn-default" onClick="$('#add_form')[0].reset();">Clear Form</button1>-->
                    <!--    <button class="btn btn-primary pull-right">Submit</button>-->
                    <!--</div>-->
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="modal_basic" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="defModalHead">Enter Field Boundaries</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="north_boundary" id="north_boundary" placeholder="North Boundary" value="33.685" >
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="south_boundary" id="south_boundary" placeholder="South Boundary" value="33.671" >
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="east_boundary" id="east_boundary" placeholder="East Boundary" value="-116.234" >
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="west_boundary" id="west_boundary" placeholder="West Boundary" value="-116.251" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="show_field()">Save</button>
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal" onclick="drawRec();">Save</button>-->
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('javascript')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&sensor=false&amp;callback=initialize&libraries=places" type="text/javascript"></script><!--original-->


<script>
var north_boundary = '';
    south_boundary = '';
    east_boundary = '';
    west_boundary = '';
function show_field(){
    alert('hi');
    north_boundary = $('#north_boundary').val(); 
    south_boundary = $('#south_boundary').val(); 
    east_boundary = $('#east_boundary').val(); 
    west_boundary = $('#west_boundary').val(); 

// alert(north_boundary);
// alert(south_boundary);
// alert(east_boundary);
// alert(west_boundary);
    
    var rectangle = new google.maps.Rectangle({
        strokeColor: "#FF0000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#FF0000",
        fillOpacity: 0.35,
        map,
        // bounds: {
        //     north: 33.685,
        //     south: 33.671,
        //     east: -116.234,
        //     west: -116.251,
        // },
        bounds: {
            north: north_boundary,
            south: south_boundary,
            east: east_boundary,
            west: west_boundary,
        },
    });
}
</script>

<script>
function GetLocation() {

    // var id = document.getElementById("Code").value;
    var id = 27;

    var request = $.ajax({
      url: "Path",
      type: "GET",
      data: "data=" + id,
      dataType: "html"
    });
    request.done(function(json_data) {
        alert(json_data);
    });
    request.fail(function(jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
  }
</script>

<script>
const map = new google.maps.Map(document.getElementById("google_map"), {
    zoom: 11,
    center: { lat: 33.678, lng: -116.243 },
    // center: { lat: -0.6319174325195819, lng: 11.802388910156258 },
    mapTypeId: "terrain",
});
var input = document.getElementById('pac-input');
var autocomplete = new google.maps.places.Autocomplete(input);
var marker = new google.maps.Marker({
    map: map,
});
autocomplete.addListener('place_changed', function() {
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
        window.alert("No details available for input: '" + place.name + "'");
        return;
    }
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
        map.setZoom(17);
    } else {
        map.setCenter(place.geometry.location);
        map.setZoom(12);
    }
    marker.setPosition(place.geometry.location);
});
var rectangle = new google.maps.Rectangle({
    strokeColor: "#FF0000",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: "#FF0000",
    fillOpacity: 0.35,
    map,
    bounds: {
        north: 33.685,
        south: 33.671,
        east: -116.234,
        west: -116.251,
    },
    // bounds: {
    //     north: north_boundary,
    //     south: south_boundary,
    //     east: east_boundary,
    //     west: west_boundary,
    // },
});
</script>


@endsection