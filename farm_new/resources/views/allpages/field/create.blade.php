@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Create Field</li>
@endsection

@php

@endphp

@section('maincontent')

    <style>
        .mandatory{ color:red; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" enctype="multipart/form-data" action="/field">
                <div class="panel panel-colorful">
                    <div class="panel-heading">
                        <!--<h3 class="panel-title">Google Map1</h3>-->
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
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    <!--<div class="row">-->
    <!--    <div class="col-md-12">-->
    <!--        <form class="form-horizontal" id="add_form" method="post" enctype="multipart/form-data" action="/field">-->
    <!--            <div class="panel panel-default">-->
    <!--                <div class="panel-heading">-->
    <!--                    <h3 class="panel-title"><strong>Create</strong> Field</h3>-->
    <!--                    <ul class="panel-controls">-->
    <!--                        <li><a href="{{url('person')}}"><span class="fa fa-times"></span></a></li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--                <div class="panel-body">-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Name <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                            {{csrf_field()}}
                                            <!--<input type="hidden" name="_method" value="PUT">-->
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Country <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="country" id="country">
                                                <option value="">select</option>
                                                @foreach($country_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Region <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="region" id="region">
                                                <option value="">select</option>
                                                @foreach($region_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Locality <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="locality" id="locality">
                                                <option value="">select</option>
                                                @foreach($locality_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Surface Area</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="surface_area" id="surface_area" value="{{old('surface_area')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Area Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="area_unit" id="area_unit">
                                                <!--<option value="HETARS">HETARS</option>-->
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}">{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Number of Plant</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="number_of_plant" id="number_of_plant" value="{{old('number_of_plant')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Main Culture</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="mainculture" id="mainculture">
                                                @foreach($culture_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                                <!--<option value="CACAO">CACAO</option>-->
                                                <!--<option value="PLANTAIN">PLANTAIN</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Other Culture</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="otherculture" id="otherculture">
                                                <option value="">select</option>
                                                @foreach($culture_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                                <!--<option value="MANIOC">MANIOC</option>-->
                                                <!--<option value="PINEAPPLES">PINEAPPLES</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="communitygroup" id="communitygroup">
                                                <option value="">select</option>
                                                @foreach($communitygrp as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                                <!--<option value="GAB_01">GAB_01</option>-->
                                                <!--<option value="GAB_02">GAB_02</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Plant Type</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="planttype" id="planttype">
                                                <option value="">select</option>
                                                @foreach($planttype_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                                <!--<option value="">select</option>-->
                                                <!--<option value="Cacao Forestero">Cacao Forestero</option>-->
                                                <!--<option value="Cacao Criollo">Cacao Criollo</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Soil Type</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="soiltype" id="soiltype">
                                                <option value="">select</option>
                                                @foreach($soiltype_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                                <!--<option value="Rich in Iron">Rich in Iron</option>-->
                                                <!--<option value="Argile">Argile</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">-->
                                    <!--    <label class="col-md-3 control-label">Unit</label>-->
                                    <!--    <div class="col-md-9">-->
                                    <!--        <select class="form-control select" name="unit_id" id="unit_id">-->
                                    <!--            <option value="">select</option>-->
                                    <!--            @foreach($units as $unit) <option value="{{$unit->id}}">{{$unit->name}}</option> @endforeach-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Team</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="team_id" id="team_id">
                                                <option value="">select</option>
                                                @foreach($teams as $team) <option value="{{$team->id}}">{{$team->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">-->
                                    <!--    <label class="col-md-3 control-label">List</label>-->
                                    <!--    <div class="col-md-9">-->
                                    <!--        <select class="form-control select" name="list_id" id="list_id">-->
                                    <!--            <option value="">select</option>-->
                                    <!--            @foreach($lists as $list) <option value="{{$list->id}}">{{$list->name}}</option> @endforeach-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Vegetation</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="vegetation1" id="vegetation1">
                                                <option value="">select</option>
                                                @foreach($vegetation_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                                <!--<option value="Nut trees">Nut trees</option>-->
                                                <!--<option value="Deep Forest">Deep Forest</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Climate</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="climate" id="climate">
                                                <!--<option value="Humid Equatorial">Humid Equatorial</option>-->
                                                <option value="">select</option>
                                                @foreach($climate_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Altitude</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="altitude" id="altitude" value="{{old('altitude')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Altitude Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="altitude_unit" id="altitude_unit">
                                                <!--<option value="HETARS">HETARS</option>-->
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}">{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Temperature</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="temperature" id="temperature" value="{{old('temperature')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Temperture Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="temp_unit" id="temp_unit">
                                                <!--<option value="C">C</option>-->
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}">{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Humidity</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="humidity" id="humidity" value="{{old('humidity')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Humidity Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="humidity_unit" id="humidity_unit">
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}">{{$unit->name}}</option> @endforeach
                                                <!--<option value="UNIT001">UNIT001</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Pluviometry</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="pluviometry" id="pluviometry" value="{{old('pluviometry')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Pluviometry Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="pluviometry_unit" id="pluviometry_unit">
                                                <!--<option value="PLUV_UNIT001">PLUV_UNIT001</option>-->
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}">{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Harvest Period</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="harvestperiod" id="harvestperiod">
                                                <option value="">select</option>
                                                @foreach($month_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                                <!--<option value="January-March">January-March</option>-->
                                                <!--<option value="September-December">September-December</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Field Class <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="field_class" id="field_class">
                                                <option value="">select</option>
                                                @foreach($class_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Field Type <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="field_type" id="field_type">
                                                <option value="">select</option>
                                                @foreach($type_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Field Contact <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="field_contact" id="field_contact">
                                                <option value="">select</option>
                                                @foreach($people as $person) <option value="{{$person->id}}">{{$person->fname.' '.$person->lname}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Visited By Person</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="last_visited_by" id="last_visited_by">
                                                <option value="">select</option>
                                                @foreach($people as $person) <option value="{{$person->id}}">{{$person->fname.' '.$person->lname}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="field_lat" id="field_lat" value="">
                        <input type="hidden" name="field_lng" id="field_lng" value="">
                        <input type="hidden" name="field_boundary" id="field_boundary" value="">
                        <input type="hidden" name="main_culture" id="main_culture" value="">
                        <input type="hidden" name="other_culture" id="other_culture" value="">
                        <input type="hidden" name="plant_type" id="plant_type" value="">
                        <input type="hidden" name="soil_type" id="soil_type" value="">
                        <input type="hidden" name="vegetation" id="vegetation" value="">
                        <input type="hidden" name="harvest_period" id="harvest_period" value="">
                        <button1 class="btn btn-default" onClick="$('#add_form')[0].reset();">Clear Form</button1>
                        <button class="btn btn-primary pull-right">Submit</button>
                    </div>
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
                                <input type="number" class="form-control" name="north_boundary" id="north_boundary" placeholder="North Boundary" value="-0.447191" >
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="south_boundary" id="south_boundary" placeholder="South Boundary" value="-0.279653" >
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="east_boundary" id="east_boundary" placeholder="East Boundary" value="13.284779" >
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="west_boundary" id="west_boundary" placeholder="West Boundary" value="13.032094" >
                            </div>
                        </div>
                    </div><!-- -0.279653, 13.032094     -0.447191, 13.284779-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="initMap()">Save</button>
                </div>
            </div>
        </div>
    </div>
    
<!--    value="33.685"-->
<!--value="33.671"-->
<!--value="-116.234"-->
<!--value="-116.251"-->

@endsection

@section('javascript')

<script>
let rectangle;
let map;
let infoWindow;
let markers = [];

function initMap() {
    var centerX = parseFloat($('#north_boundary').val()) + ((parseFloat($('#south_boundary').val()) - parseFloat($('#north_boundary').val())) / 2);
    var centerY = parseFloat($('#east_boundary').val()) + ((parseFloat($('#west_boundary').val()) - parseFloat($('#east_boundary').val())) / 2);

    var newlatlong = new google.maps.LatLng(centerX, centerY);
    map = new google.maps.Map(document.getElementById("google_map"), {
        // center: { lat: 33.678, lng: -116.243 },
        //center: { lat: -0.6319174325195819, lng: 11.802388910156258 },
        center: newlatlong,
        zoom: 12,
        mapTypeId: 'satellite'
    });
    const bounds = {
        north: parseFloat($('#north_boundary').val()), /*44.599,*/
        south: parseFloat($('#south_boundary').val()), /*44.49,*/
        east: parseFloat($('#east_boundary').val()), /*-78.443,*/
        west: parseFloat($('#west_boundary').val()), /*-78.649,*/
    };
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
    // alert(JSON.stringify(bounds));
  
    // Define the rectangle and set its editable property to true.
    rectangle = new google.maps.Rectangle({
        bounds: bounds,
        editable: true,
        draggable: true,
        
        strokeColor: "rgb(26 115 232)",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "rgb(26 115 232)",
        fillOpacity: 0.35,
    });
    rectangle.setMap(map);
    // Add an event listener on the rectangle.
    rectangle.addListener("bounds_changed", showNewRect);
    // Define an info window on the map.
    infoWindow = new google.maps.InfoWindow();
  
    // alert(rectangle.getBounds());
    
    // var bounds = rectangle.getBounds();
    
    // const ne = rectangle.getBounds().getNorthEast();
    // const sw = rectangle.getBounds().getSouthWest();
    
    var boundary = {
        north: rectangle.getBounds().getNorthEast().lat(),
        south:rectangle.getBounds().getSouthWest().lat(),
        east: rectangle.getBounds().getNorthEast().lng(),
        west: rectangle.getBounds().getSouthWest().lng(),
    };
    
    $('#field_boundary').val(JSON.stringify(boundary));
    
     //added by vidhi
    var field_lat = rectangle.getBounds().getCenter().lat();
    var field_lng = rectangle.getBounds().getCenter().lng();
    $('#field_lat').val(field_lat);
    $('#field_lng').val(field_lng);
    
    // alert('map : '+JSON.stringify(bounds));
    // alert('json : '+JSON.stringify(boundary));
    
    google.maps.event.addListener(rectangle, 'click', function(event) {
        // alert('latitude: ' + event.latLng.lat() + ' , longitude: ' + event.latLng.lng()); 
        
        var marker = new google.maps.Marker({
            // position: event.latLng, 
            position: rectangle.getBounds().getCenter(), 
            map: map,
            id: 'marker_',
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
            }
        });
        markers.push(marker);
        
        const ne = rectangle.getBounds().getNorthEast();
        const sw = rectangle.getBounds().getSouthWest();
        const contentString =
            "<b>Rectangle Field.</b><br>" +
            "New north-east corner: " +
            ne.lat() +
            ", " +
            ne.lng() +
            "<br>" +
            "New south-west corner: " +
            sw.lat() +
            ", " +
            sw.lng();
        // Set the info window's content and position.
        infoWindow.setContent(contentString);
        infoWindow.setPosition(sw);
        infoWindow.open(map);
    });
}

function showNewRect() {
    
    // setMapOnAll(null);
    
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    
    infoWindow.close();
    
    var boundary = {
        north: rectangle.getBounds().getNorthEast().lat(),
        south:rectangle.getBounds().getSouthWest().lat(),
        east: rectangle.getBounds().getNorthEast().lng(),
        west: rectangle.getBounds().getSouthWest().lng(),
    };
    
    $('#field_boundary').val(JSON.stringify(boundary));
    
     //added by vidhi
    var field_lat = rectangle.getBounds().getCenter().lat();
    var field_lng = rectangle.getBounds().getCenter().lng();
    $('#field_lat').val(field_lat);
    $('#field_lng').val(field_lng);
}
</script>

<script>

var jvalidate = $("#add_form").validate({
    ignore: [],
    rules: {
        name: { required: true },
        description: { required: true },
        field_class: { required: true },
        field_type: { required: true },
        communitygroup: { required: true },
        country: { required: true },
        region: { required: true },
        locality: { required: true },
        field_contact: { required: true },
    }
});

$( "#mainculture" ).change(function() {
    $('#main_culture').val($( "#mainculture" ).val());
});
$( "#otherculture" ).change(function() {
    $('#other_culture').val($( "#otherculture" ).val());
});
$( "#planttype" ).change(function() {
    $('#plant_type').val($( "#planttype" ).val());
});
$( "#soiltype" ).change(function() {
    $('#soil_type').val($( "#soiltype" ).val());
});
$( "#vegetation1" ).change(function() {
    $('#vegetation').val($( "#vegetation1" ).val());
});
$( "#harvestperiod" ).change(function() {
    $('#harvest_period').val($( "#harvestperiod" ).val());
});
    

    // $('#fname').val('test fname');
    // $('#lname').val('test lname');
    // $('#email').val('test@gmail.com');
    // $('#contact').val('9865320147');
    // $('#dob').val('1991-01-01');
    // $('#birth_place').val('test birth_place');
    // $('#address').val('test address');
    // $('#certification').val('test certification');
    // $('#last_certification_date').val('2021-01-01');
    // $('#description').val('test description');
    </script>
    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&callback=initMap&libraries=places&v=weekly" async ></script>
@endsection
