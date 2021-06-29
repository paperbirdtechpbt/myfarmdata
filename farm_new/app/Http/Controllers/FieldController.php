<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Unit;
use App\Lists;
use App\Field;
use App\Person;
use App\ListChoice;
use App\CommunityGroup;
use Illuminate\Http\Request;

use DB;

use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource..
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $fields = Field::whereIn('communitygroup', $auth_user_comgrp)->get();
        // $lists = Lists::with('community_groups', 'choices')->get();
        return view('allpages.field.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $lists = Lists::all();
        
        
        $user = User::findorfail(Auth::user()->id);
        $community_group_id = $user->community_group_id;
        $array1 = explode(",",$community_group_id);
       
        $teams = Team::whereIn('communitygroup', $auth_user_comgrp)->get();
        // $teams = Team::all();
        $people = Person::whereIn('communitygroup', $auth_user_comgrp)->get();
        
        
        // $communitygrp = CommunityGroup::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        
        
        $class_list = Lists::where('name', 'SYS_FIELD_CLASS')->first();
        $class_list = $class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $type_list = Lists::where('name', 'SYS_FIELD_TYPE')->first();
        $type_list = $type_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $country_list = Lists::where('name', 'SYS_COUNTRIES')->first();
        $country_list = $country_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $region_list = Lists::where('name', 'SYS_REGION')->first();
        $region_list = $region_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $locality_list = Lists::where('name', 'SYS_LOCALITY')->first();
        $locality_list = $locality_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $culture_list = Lists::where('name', 'SYS_CULTURE')->first();
        $culture_list = $culture_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $planttype_list = Lists::where('name', 'SYS_PLANT_TYPE')->first();
        $planttype_list = $planttype_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $soiltype_list = Lists::where('name', 'SYS_SOIL_TYPE')->first();
        $soiltype_list = $soiltype_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $vegetation_list = Lists::where('name', 'SYS_VEGETATION')->first();
        $vegetation_list = $vegetation_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $climate_list = Lists::where('name', 'SYS_CLIMATE')->first();
        $climate_list = $climate_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $month_list = Lists::where('name', 'SYS_MONTHS')->first();
        $month_list = $month_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $fieldobj_list = Lists::where('name', 'SYS_FIELD_OBJ_TYPE')->first();
        $fieldobj_list = $fieldobj_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $units = Unit::whereIn('communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.field.create', compact('people', 'lists', 'teams', 'units', 'communitygrp', 'class_list', 'type_list', 'country_list', 'region_list', 'locality_list', 'culture_list', 'planttype_list', 'soiltype_list', 'vegetation_list', 'climate_list', 'month_list', 'fieldobj_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // 'fname' => ['required', 'unique:people'],
            // 'description' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        try {
            
            $field = new Field();
            
            $field->name = $request->name;
            $field->description = $request->description;
            $field->country = $request->country;
            $field->region = $request->region;
            $field->locality = $request->locality;
            $field->surface_area = $request->surface_area;
            $field->area_unit = $request->area_unit;
            $field->number_of_plant = $request->number_of_plant;
            $field->main_culture = $request->main_culture;
            $field->other_culture = $request->other_culture;
            $field->communitygroup = $request->communitygroup;
            $field->plant_type = $request->plant_type;
            $field->soil_type = $request->soil_type;
            $field->vegetation = $request->vegetation;
            $field->climate = $request->climate;
            $field->altitude = $request->altitude;
            $field->altitude_unit = $request->area_unit;
            $field->temperature = $request->temperature;
            $field->temp_unit = $request->temp_unit;
            $field->humidity = $request->humidity;
            $field->humidity_unit = $request->humidity_unit;
            $field->pluviometry = $request->pluviometry;
            $field->pluviometry_unit = $request->pluviometry_unit;
            $field->harvest_period = $request->harvest_period;
            $field->field_class = $request->field_class;
            $field->field_type = $request->field_type;
            // $field->latitude = $request->latitude;
            // $field->longitude = $request->longitude;
            $field->latitude = $request->field_lat;
            $field->longitude = $request->field_lng;
            $field->field_boundary = $request->field_boundary;
            $field->created_by = Auth::user()->id;
    
            $field->save();
            
            if($request->team_id != null){
                $team = Team::findorfail($request->team_id);
                $team->field()->save($field);
            }
            if($request->field_contact != null){
                $field_contact = Person::findorfail($request->field_contact);
                $field_contact->field_contact()->save($field);
            }
            if($request->last_visited_by != null){
                $last_visited_by = Person::findorfail($request->last_visited_by);
                $last_visited_by->last_visited_by()->save($field);
            }
            // $unit = Unit::findorfail($request->unit_id);
            // $list = Lists::findorfail($request->list_id);
            // $unit->field()->save($field);
            // $list->field()->save($field);
            
            return redirect('field')->with('success', 'Inserted Successfully');
            
        } catch (Exception $e) {
            return redirect('field')->with('error', $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $field = Field::findorfail($id);
        // $people = Person::all();
        $lists = Lists::all();
        // $teams = Team::all();
        
        $user = User::findorfail(Auth::user()->id);
        $community_group_id = $user->community_group_id;
        
        $array1 = explode(",",$community_group_id);
        $teams = Team::whereIn('communitygroup', $auth_user_comgrp)->get();
        // $teams = Team::all();
        $people = Person::whereIn('communitygroup', $auth_user_comgrp)->get();
        
        
        // $communitygrp = CommunityGroup::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $class_list = Lists::where('name', 'SYS_FIELD_CLASS')->first();
        $class_list = $class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $type_list = Lists::where('name', 'SYS_FIELD_TYPE')->first();
        $type_list = $type_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $country_list = Lists::where('name', 'SYS_COUNTRIES')->first();
        $country_list = $country_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
       
        $region_list = Lists::where('name', 'SYS_REGION')->first();
        $region_list = $region_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $locality_list = Lists::where('name', 'SYS_LOCALITY')->first();
        $locality_list = $locality_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $culture_list = Lists::where('name', 'SYS_CULTURE')->first();
        $culture_list = $culture_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $planttype_list = Lists::where('name', 'SYS_PLANT_TYPE')->first();
        $planttype_list = $planttype_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $soiltype_list = Lists::where('name', 'SYS_SOIL_TYPE')->first();
        $soiltype_list = $soiltype_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $vegetation_list = Lists::where('name', 'SYS_VEGETATION')->first();
        $vegetation_list = $vegetation_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $climate_list = Lists::where('name', 'SYS_CLIMATE')->first();
        $climate_list = $climate_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $month_list = Lists::where('name', 'SYS_MONTHS')->first();
        $month_list = $month_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        
        
        $fieldobj_list = Lists::where('name', 'SYS_FIELD_OBJ_TYPE')->first();
        $fieldobj_list = $fieldobj_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
         $units = Unit::whereIn('communitygroup', $auth_user_comgrp)->get();
         
        return view('allpages.field.edit', compact('field', 'people', 'lists', 'teams', 'units', 'communitygrp', 'class_list', 'type_list', 'country_list', 'region_list', 'locality_list', 'culture_list', 'planttype_list', 'soiltype_list', 'vegetation_list', 'climate_list', 'month_list', 'fieldobj_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'name' => 'required',
            // 'description' => 'required',
        ]);
        
        $field = Field::findorfail($id);
            
        $field->name = $request->name;
        $field->description = $request->description;
        $field->country = $request->country;
        $field->region = $request->region;
        $field->locality = $request->locality;
        $field->surface_area = $request->surface_area;
        $field->area_unit = $request->area_unit;
        $field->number_of_plant = $request->number_of_plant;
        $field->main_culture = $request->main_culture;
        $field->other_culture = $request->other_culture;
        $field->communitygroup = $request->communitygroup;
        $field->plant_type = $request->plant_type;
        $field->soil_type = $request->soil_type;
        $field->vegetation = $request->vegetation;
        $field->climate = $request->climate;
        $field->altitude = $request->altitude;
        $field->altitude_unit = $request->area_unit;
        $field->temperature = $request->temperature;
        $field->temp_unit = $request->temp_unit;
        $field->humidity = $request->humidity;
        $field->humidity_unit = $request->humidity_unit;
        $field->pluviometry = $request->pluviometry;
        $field->pluviometry_unit = $request->pluviometry_unit;
        $field->harvest_period = $request->harvest_period;
        $field->field_class = $request->field_class;
        $field->field_type = $request->field_type;
        // $field->latitude = $request->latitude;
        // $field->longitude = $request->longitude;
        $field->latitude = $request->field_lat;
        $field->longitude = $request->field_lng;
        $field->field_boundary = $request->field_boundary;
                
        $field->save();
        
        if($request->team_id != null){
            $team = Team::findorfail($request->team_id);
            $team->field()->save($field);
        }
        if($request->field_contact != null){
            $field_contact = Person::findorfail($request->field_contact);
            $field_contact->field_contact()->save($field);
        }
        if($request->last_visited_by != null){
            $last_visited_by = Person::findorfail($request->last_visited_by);
            $last_visited_by->last_visited_by()->save($field);
        }
        // $unit = Unit::findorfail($request->unit_id);
        // $list = Lists::findorfail($request->list_id);
        // $unit->field()->save($field);
        // $list->field()->save($field);
       
        return redirect('field')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sensortype = Field::findorfail($id);
        $sensortype->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $sensortype->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
        // return redirect('field')->with('success', 'Deleted Successfully');
    }
    
    public function test_map(){
        return view('allpages.field.test_map');
    }
    
    public function getFields(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $fields = Field::whereIn('communitygroup', $auth_user_comgrp);
        if($request->country_id !=null){
            $fields = $fields->where('country', $request->country_id);
        }
        $fields = $fields->get();
        
        // $filed_array = array(); 
        // foreach ($fields as $event) 
        // {  
        //     // $country_list = ListChoice::where('id', $event->country)->first();
        //     // $country_name = '';
        //     // if($country_list != null){
        //     //     $country_name = $country_list->name;  
        //     // }
            
        //     $event1 =  array (
        //         'id' => $event->id,
        //         'name' => $event->name,
        //         'country_id' => $event->country,
        //         // 'country_name' => $country_name,
        //     ); 
        //     array_push($filed_array, $event1); 
        // }
                        
        $data = array();
        $data['fields'] = $fields;
        return json_encode($data);
    }
}
