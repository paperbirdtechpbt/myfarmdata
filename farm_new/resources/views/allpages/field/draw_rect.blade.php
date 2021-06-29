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
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal" onclick="show_field()">Save</button>-->
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="drawRec();">Save</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('javascript')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&sensor=false&amp;callback=initialize&libraries=drawing" type="text/javascript"></script>

<script>

var map;
var drawingManager = new google.maps.drawing.DrawingManager();

function initialize() {
    var mapOptions = {
        center: new google.maps.LatLng(44.5452, -78.5389),
        zoom: 9
    };
    map = new google.maps.Map(document.getElementById('google_map'),
    mapOptions);
}

function drawRec() {
        //Setting options for the Drawing Tool. In our case, enabling Polygon shape.
        drawingManager.setOptions({
            drawingMode : google.maps.drawing.OverlayType.RECTANGLE,
            drawingControl : true,
            drawingControlOptions : {
                position : google.maps.ControlPosition.TOP_CENTER,
                drawingModes : [ google.maps.drawing.OverlayType.RECTANGLE ]
            },
            rectangleOptions : {
                strokeColor : '#6c6c6c',
                strokeWeight : 3.5,
                fillColor : '#926239',
                fillOpacity : 0.6,
                editable: true,
                draggable: true
            }   
        });
        // Loading the drawing Tool in the Map.
        drawingManager.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>



@endsection