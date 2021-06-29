@extends('mainlayout')

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Edit Field</li>
@endsection

@php

$boundary = json_decode($field->field_boundary, true);

//echo $boundary['north'];

//dd($field);

//echo "main_culture : ".$field->main_culture;

@endphp

@section('maincontent')

    <style>
        .mandatory{ color:red; }
    </style>
    
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="add_form" method="post" enctype="multipart/form-data" action="/field/{{$field->id}}">
                <div class="panel panel-colorful">
                    <div class="panel-heading">
                        <!--<h3 class="panel-title">Google Map</h3>-->
                        <h3 class="panel-title"><strong>Edit</strong> Field</h3>
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
                                            <input type="text" class="form-control" name="name" id="name" value="{{$field->name}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="PUT">
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
                                                @foreach($country_list as $value)<option value="{{$value->id}}" @if($field->country  == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="GABON" >GABON</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Region <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="region" id="region">
                                                <option value="">select</option>
                                                @foreach($region_list as $value)<option value="{{$value->id}}" @if($field->region  == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Locality <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="locality" id="locality">
                                                <option value="">select</option>
                                                @foreach($locality_list as $value)<option value="{{$value->id}}" @if($field->locality  == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Surface Area</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="surface_area" id="surface_area" value="{{$field->surface_area}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Area Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="area_unit" id="area_unit">
                                                <!--<option value="HETARS" @if($field->area_unit  == 'GABON') selected @endif>HETARS</option>-->
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}"  @if($field->area_unit  == $unit->id) selected @endif>{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Number of Plant</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="number_of_plant" id="number_of_plant" value="{{$field->number_of_plant}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Main Culture</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="mainculture" id="mainculture">
                                                <!--@foreach($culture_list as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach-->
                                                @foreach($culture_list as $value)<option value="{{$value->id}}" @if(in_array($value->id, explode(',', $field->main_culture))) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="CACAO" @if(strpos($field->main_culture, 'CACAO') !== false) selected @endif>CACAO</option>-->
                                                <!--<option value="PLANTAIN" @if(strpos($field->main_culture, 'PLANTAIN') !== false) selected @endif>PLANTAIN</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Other Culture</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="otherculture" id="otherculture">
                                                @foreach($culture_list as $value)<option value="{{$value->id}}" @if(in_array($value->id, explode(',', $field->other_culture))) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="MANIOC" @if(strpos($field->other_culture, 'MANIOC') !== false) selected @endif>MANIOC</option>-->
                                                <!--<option value="PINEAPPLES" @if(strpos($field->other_culture, 'PINEAPPLES') !== false) selected @endif>PINEAPPLES</option>-->
                                                <!--<option value="MANIOC" @if($field->other_culture  == 'MANIOC') selected @endif>MANIOC</option>-->
                                                <!--<option value="PINEAPPLES" @if($field->other_culture  == 'PINEAPPLES') selected @endif>PINEAPPLES</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Community Group <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="communitygroup" id="communitygroup">
                                                <option value="">select</option>
                                                @foreach($communitygrp as $value)<option value="{{$value->id}}" @if($field->communitygroup  == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="GAB_01" @if($field->communitygroup  == 'GAB_01') selected @endif>GAB_01</option>-->
                                                <!--<option value="GAB_02" @if($field->communitygroup  == 'GAB_02') selected @endif>GAB_02</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Plant Type</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="planttype" id="planttype">
                                                <!--<option value="">select</option>-->
                                                @foreach($planttype_list as $value)<option value="{{$value->id}}" @if(in_array($value->id, explode(',', $field->plant_type))) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="Cacao Forestero" @if(strpos($field->plant_type, 'Cacao Forestero') !== false) selected @endif>Cacao Forestero</option>-->
                                                <!--<option value="Cacao Criollo" @if(strpos($field->plant_type, 'Cacao Criollo') !== false) selected @endif>Cacao Criollo</option>-->
                                                <!--<option value="Cacao Forestero" @if($field->plant_type  == 'Cacao Forestero') selected @endif>Cacao Forestero</option>-->
                                                <!--<option value="Cacao Criollo" @if($field->plant_type  == 'Cacao Criollo') selected @endif>Cacao Criollo</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Soil Type</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="soiltype" id="soiltype">
                                                <!--<option value="">select</option>-->
                                                @foreach($soiltype_list as $value)<option value="{{$value->id}}" @if(in_array($value->id, explode(',', $field->soil_type))) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="Rich in Iron" @if(strpos($field->soil_type, 'Rich in Iron') !== false) selected @endif>Rich in Iron</option>-->
                                                <!--<option value="Argile" @if(strpos($field->soil_type, 'Argile') !== false) selected @endif>Argile</option>-->
                                                <!--<option value="Rich in Iron" @if($field->soil_type  == 'Rich in Iron') selected @endif>Rich in Iron</option>-->
                                                <!--<option value="Argile" @if($field->soil_type  == 'Argile') selected @endif>Argile</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">-->
                                    <!--    <label class="col-md-3 control-label">Unit</label>-->
                                    <!--    <div class="col-md-9">-->
                                    <!--        <select class="form-control select" name="unit_id" id="unit_id">-->
                                    <!--            <option value="">selecte</option>-->
                                    <!--            @foreach($units as $unit) <option value="{{$unit->id}}" @if($field->unit_id  == $unit->id) selected @endif>{{$unit->name}}</option> @endforeach-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Team</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="team_id" id="team_id">
                                                <option value="">select</option>
                                                @foreach($teams as $team) <option value="{{$team->id}}" @if($field->team_id  == $team->id) selected @endif>{{$team->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!--<div class="form-group">-->
                                    <!--    <label class="col-md-3 control-label">List</label>-->
                                    <!--    <div class="col-md-9">-->
                                    <!--        <select class="form-control select" name="list_id" id="list_id">-->
                                    <!--            <option value="">selecte</option>-->
                                    <!--            @foreach($lists as $list) <option value="{{$list->id}}" @if($field->lists_id  == $list->id) selected @endif>{{$list->name}}</option> @endforeach-->
                                    <!--        </select>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="description" id="description" value="{{$field->description}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Vegetation</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="vegetation1" id="vegetation1">
                                                @foreach($vegetation_list as $value)<option value="{{$value->id}}" @if(in_array($value->id, explode(',', $field->vegetation))) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="Nut trees" @if(strpos($field->vegetation, 'Nut trees') !== false) selected @endif>Nut trees</option>-->
                                                <!--<option value="Deep Forest" @if(strpos($field->vegetation, 'Deep Forest') !== false) selected @endif>Deep Forest</option>-->
                                                <!--<option value="Nut trees" @if($field->vegetation  == 'Nut trees') selected @endif>Nut trees</option>-->
                                                <!--<option value="Deep Forest" @if($field->vegetation  == 'Deep Forest') selected @endif>Deep Forest</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Climate</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="climate" id="climate">
                                                <option value="">select</option>
                                                @foreach($climate_list as $value)<option value="{{$value->id}}" @if($field->climate  == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="Humid Equatorial" >Humid Equatorial</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Altitude</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="altitude" id="altitude" value="{{$field->altitude}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Altitude Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="altitude_unit" id="altitude_unit">
                                                <!--<option value="HETARS">HETARS</option>-->
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}" @if($field->temp_unit  == $unit->id) selected @endif >{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Temperature</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="temperature" id="temperature" value="{{$field->temperature}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Temperture Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="temp_unit" id="temp_unit">
                                                <!--<option value="C" @if($field->temp_unit  == 'C') selected @endif>C</option>-->
                                                <option value="">select</option>
                                                @foreach($units as $unit) <option value="{{$unit->id}}" @if($field->temp_unit  == $unit->id) selected @endif >{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Humidity</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="humidity" id="humidity" value="{{$field->humidity}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Humidity Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="humidity_unit" id="humidity_unit">
                                                @foreach($units as $unit) <option value="{{$unit->id}}" @if($field->humidity_unit  == $unit->id) selected @endif >{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Pluviometry</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control number" name="pluviometry" id="pluviometry" value="{{$field->pluviometry}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Pluviometry Unit</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="pluviometry_unit" id="pluviometry_unit">
                                                @foreach($units as $unit) <option value="{{$unit->id}}" @if($field->pluviometry_unit  == $unit->id) selected @endif >{{$unit->name}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Harvest Period</label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select multiple class="form-control select" name="harvestperiod" id="harvestperiod">
                                                <!--<option value="">select</option>-->
                                                @foreach($month_list as $value)<option value="{{$value->id}}" @if(in_array($value->id, explode(',', $field->harvest_period))) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="January-March" @if(strpos($field->harvest_period, 'January-March') !== false) selected @endif>January-March</option>-->
                                                <!--<option value="September-December" @if(strpos($field->harvest_period, 'September-December') !== false) selected @endif>September-December</option>-->
                                                <!--<option value="January-March" @if($field->harvest_period  == 'January-March') selected @endif>January-March</option>-->
                                                <!--<option value="September-December" @if($field->harvest_period  == 'September-December') selected @endif>September-December</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Field Class <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="field_class" id="field_class">
                                                <option value="">select</option>
                                                @foreach($class_list as $value)<option value="{{$value->id}}" @if($field->field_class  == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="CLASS001" >CLASS001</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Field Type <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <!--<input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">-->
                                            <select class="form-control select" name="field_type" id="field_type">
                                                <option value="">select</option>
                                                @foreach($type_list as $value)<option value="{{$value->id}}" @if($field->field_type  == $value->id) selected @endif>{{$value->name}}</option>@endforeach
                                                <!--<option value="TYPE001" >TYPE001</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Field Contact <span class="mandatory">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="field_contact" id="field_contact">
                                                <option value="">select</option>
                                                @foreach($people as $person) <option value="{{$person->id}}" @if($field->field_contact  == $person->id) selected @endif>{{$person->fname.' '.$person->lname}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Visited By Person</label>
                                        <div class="col-md-9">
                                            <select class="form-control select" name="last_visited_by" id="last_visited_by">
                                                <option value="">select</option>
                                                @foreach($people as $person) <option value="{{$person->id}}" @if($field->last_visited_by  == $person->id) selected @endif>{{$person->fname.' '.$person->lname}}</option> @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <input type="hidden" name="field_lat" id="field_lat" value="{{$field->latitude}}">
                        <input type="hidden" name="field_lng" id="field_lng" value="{{$field->longitude}}">
                        <input type="hidden" name="field_boundary" id="field_boundary" value="{{$field->field_boundary}}">
                        <input type="hidden" name="main_culture" id="main_culture" value="{{$field->main_culture}}">
                        <input type="hidden" name="other_culture" id="other_culture" value="{{$field->other_culture}}">
                        <input type="hidden" name="plant_type" id="plant_type" value="{{$field->plant_type}}">
                        <input type="hidden" name="soil_type" id="soil_type" value="{{$field->soil_type}}">
                        <input type="hidden" name="vegetation" id="vegetation" value="{{$field->vegetation}}">
                        <input type="hidden" name="harvest_period" id="harvest_period" value="{{$field->harvest_period}}">
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
                                <input type="number" class="form-control" name="north_boundary" id="north_boundary" placeholder="North Boundary" value="{{$boundary['north']}}" >
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="south_boundary" id="south_boundary" placeholder="South Boundary" value="{{$boundary['south']}}" >
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="east_boundary" id="east_boundary" placeholder="East Boundary" value="{{$boundary['east']}}" >
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="west_boundary" id="west_boundary" placeholder="West Boundary" value="{{$boundary['west']}}" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="initMap()">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

<script>
let rectangle;
let map;
let infoWindow;
let markers = [];

function initMap() {
        // center of the polygon is the starting point plus the midpoint
    var centerX = parseFloat($('#north_boundary').val()) + ((parseFloat($('#south_boundary').val()) - parseFloat($('#north_boundary').val())) / 2);
    var centerY = parseFloat($('#east_boundary').val()) + ((parseFloat($('#west_boundary').val()) - parseFloat($('#east_boundary').val())) / 2);

    var newlatlong = new google.maps.LatLng(centerX, centerY);
    map = new google.maps.Map(document.getElementById("google_map"), {
        // center: { lat: 33.678, lng: -116.243 },
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
            "<b>Field Name : {{$field->name}}</b><br>" +
            "Description : {{$field->description}}<br>" +
            "Contact :  "+$( "#field_contact option:selected" ).text()+"<br><br>" +
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
        infoWindow.setPosition(ne);
        infoWindow.open(map);
    });
    
    // alert('map : '+JSON.stringify(bounds));
    // alert('json : '+JSON.stringify(boundary));
}

function showNewRect() {
    
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
    
    // function readURL(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();
    //         reader.onload = function (e) {
    //             $('#pic').attr('src', e.target.result);
    //         };
    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }

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
