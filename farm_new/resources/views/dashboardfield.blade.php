@extends('mainlayout')

@php
//$cookiename = 'userlogin_roleid';
//echo $value = Cookie::get($cookiename);
@endphp

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Dashboard Fields</li>
@endsection

@section('maincontent')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Dashboard Fields</strong></h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3">
                        <label>Country</label>
                    </div>
                    <div class="col-md-9">
                        <select class="form-control select" name="country_id" id="country_id" onChange="viewMarker();">
                        <option value="">All</option>
                        @foreach($country_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <div id="map" style="height: 400px; width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

@endsection

@section('javascript')

<script type="text/javascript">
    var map;
    var markers  = [];

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 1,
        center: { lat: -33.9, lng: 151.2 },
      });
      
    }
    
    // Adds a marker to the map and push to the array.
    function addMarker(location,title) {
        const marker = new google.maps.Marker({
            map:map,
            position:location,
            title: title,
            draggable: true,
        });
        const contentString ='<h3>'+title+'</h3>';
        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });
        markers.push(marker);
    }
    
    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }
    
    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }
    
    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
    }
    

    function viewMarker(){
        deleteMarkers();
        markers  = [];
        var token = $('#_token').val();
            country_id = $('#country_id').val();
            
        jQuery.ajax({
            url: '/getFields',
            type: 'POST',
            dataType: 'json',
            data: { _token:token,'country_id':country_id},
            success: function(doc) {
        
                const geocoder = new google.maps.Geocoder();
                const address =$('#country_id option:selected').html();
                if(country_id != ''){
                    geocoder.geocode({ address: address }, (results, status) => {
                        if (status === "OK") {
                            map.setZoom(4);      // This will trigger a zoom_changed on the map
                            map.setCenter(results[0].geometry.location);
                        }
                    });
                }else{
                    map.setZoom(1);      // This will trigger a zoom_changed on the map
                    map.setCenter(new google.maps.LatLng(-33.9, 151.2));
                } 
                $.each(doc.fields, function(index, value) {
                    var latlng = new google.maps.LatLng(value.latitude, value.longitude);
                    
                    addMarker(latlng,value.name);
                    
                });
                
            }
        });
       
    
    }
    $(function() {
        viewMarker();
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&callback=initMap&libraries=places&v=weekly" async ></script>
@endsection
