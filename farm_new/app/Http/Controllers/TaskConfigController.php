<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\CommunityGroup;
use App\TaskConfig;
use App\TaskConfigField;
use App\TaskConfigFunction;
use App\Lists;
use App\ListChoice;
use App\Field;
use App\Person;
use App\Team;
use App\TaskField;
use App\Task;
use DB;

class TaskConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $taskconfigs = TaskConfig::whereIn('com_group', $auth_user_comgrp)->get();
    
        return view('allpages.taskconfig.index',compact('taskconfigs'));
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
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        
        $type_list = Lists::where('name', 'SYS_TASK_CONFIG_TYPE')->first();
        $type_list = $type_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $class_list = Lists::where('name', 'SYS_TASK_CONFIG_CLASS')->first();
        $class_list = $class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $fieldtype_list = Lists::where('name', 'SYS_TASK_CONFIG_FIELD_TYPE')->first();
        $fieldtype_list = $fieldtype_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $field_list = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
        $field_list = $field_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
      
        
        $function_list = Lists::where('name', 'SYS_TASK_CONFIG_FUNCTION')->first();
        $function_list = $function_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $privileges = DB::table('privileges')->get();
        
        $lists = Lists::with('community_groups', 'choices')->whereIn('communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.taskconfig.create',compact('communitygrp','type_list','class_list','fieldtype_list','privileges','lists','field_list','function_list'));
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gc = new TaskConfig();
        $gc->name = $request->name;
        $gc->description = $request->description;
        $gc->type = $request->type;
        $gc->class = $request->class;
        $gc->com_group = $request->community_group;
        $gc->name_prefix = $request->name_prefix;
        $gc->record_event = $request->record_event;
        $gc->created_by = Auth::user()->id;
        $gc->save();
        
        foreach ($request->field_name as $key => $c1) {
            if($c1 != ''){
                $check = TaskConfigField::where('field_name',$request->field_name[$key])->where('task_config_id',$gc->id)->first();
                if($check == null){
                    $gco = new TaskConfigField();
                }else{
                    $gco = TaskConfigField::findorfail($check->id);
                }
                
                $gco->task_config_id = $gc->id;
                $gco->field_name = $request->field_name[$key];
                $gco->field_description = $request->field_description[$key];
                $gco->editable = $request->editable[$key];
                $gco->field_type = $request->field_type[$key];
                $gco->list = $request->list[$key];
                $gco->created_by = Auth::user()->id;
                $gco->save();
            }
        }
        
        foreach ($request->function_name as $key => $c1) {
            if($c1 != ''){
                $check = TaskConfigFunction::where('name',$request->function_name[$key])->where('task_config_id',$gc->id)->first();
                if($check == null){
                    $gco = new TaskConfigFunction();
                }else{
                    $gco = TaskConfigFunction::findorfail($check->id);
                }
                
                $gco->task_config_id = $gc->id;
                $gco->name = $request->function_name[$key];
                $gco->description = $request->function_description[$key];
                $gco->privilege = $request->privilege[$key];
                $gco->created_by = Auth::user()->id;
                $gco->save();
            }
        }
        
        return redirect('taskconfig')->with('success', 'Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $taskconfig = TaskConfig::findorfail($id);
        $taskconfigfields = TaskConfigField::where('task_config_id',$id)->get();
        $taskconfigfunctions = TaskConfigFunction::where('task_config_id',$id)->get();
       
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        
        $type_list = Lists::where('name', 'SYS_TASK_CONFIG_TYPE')->first();
        $type_list = $type_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $class_list = Lists::where('name', 'SYS_TASK_CONFIG_CLASS')->first();
        $class_list = $class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $fieldtype_list = Lists::where('name', 'SYS_TASK_CONFIG_FIELD_TYPE')->first();
        $fieldtype_list = $fieldtype_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $field_list = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
        $field_list = $field_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
       
        $function_list = Lists::where('name', 'SYS_TASK_CONFIG_FUNCTION')->first();
        $function_list = $function_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
       
        $privileges = DB::table('privileges')->get();
        
        $lists = Lists::with('community_groups', 'choices')->whereIn('communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.taskconfig.edit',compact('communitygrp','type_list','class_list','fieldtype_list','privileges','lists','taskconfig','taskconfigfields','taskconfigfunctions','field_list','function_list'));
    
        
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
        
        $gc = TaskConfig::findorfail($id);
        $gc->name = $request->name;
        $gc->description = $request->description;
        $gc->type = $request->type;
        $gc->class = $request->class;
        $gc->com_group = $request->community_group;
        $gc->name_prefix = $request->name_prefix;
        $gc->record_event = $request->record_event;
        $gc->last_changed_by = Auth::user()->id;
        $gc->last_changed_date = date('Y-m-d H:i:s');
        $gc->save();
        
        
        foreach ($request->field_name as $key => $c1) {
            if($request->field_delete[$key] == 'deleted_data'){
        
                TaskConfigField::where('id',$request->field_id[$key])->delete();
            }
            elseif($request->field_id[$key] == 0){
                
                if($c1 != ''){
                    $check = TaskConfigField::where('field_name',$request->field_name[$key])->where('task_config_id',$gc->id)->first();
                    if($check == null){
                        $gco = new TaskConfigField();
                    }else{
                        $gco = TaskConfigField::findorfail($check->id);
                    }
                    
                    $gco->task_config_id = $gc->id;
                    $gco->field_name = $request->field_name[$key];
                    $gco->field_description = $request->field_description[$key];
                    $gco->editable = $request->editable[$key];
                    $gco->field_type = $request->field_type[$key];
                    $gco->list = $request->list[$key];
                    $gco->created_by = Auth::user()->id;
                    $gco->save();
                    
                    
                }
            }
            elseif($request->field_id[$key] > 0){
                if($c1 != ''){
                    $check = TaskConfigField::where('field_name',$request->field_name[$key])->where('task_config_id',$gc->id)->first();
                    if($check == null){
                        $gco = TaskConfigField::findorfail($request->field_id[$key]);
                    }else if($check->id == $request->field_id[$key]){
                        $gco = TaskConfigField::findorfail($request->field_id[$key]);
                    }else{
                        $gco = TaskConfigField::findorfail($check->id);
                    }
                    
                    $gco->task_config_id = $gc->id;
                    $gco->field_name = $request->field_name[$key];
                    $gco->field_description = $request->field_description[$key];
                    $gco->editable = $request->editable[$key];
                    $gco->field_type = $request->field_type[$key];
                    $gco->list = $request->list[$key];
                    $gco->last_changed_by = Auth::user()->id;
                    $gco->last_changed_date = date('Y-m-d H:i:s');
                    $gco->save();
                    
                    if($check != null){
                        if($check->id != $request->field_id[$key]){
                            TaskConfigField::where('id',$request->field_id[$key])->delete();
                        }
                    }
                }
            }
        }
        
         foreach ($request->function_name as $key => $c1) {
            if($request->function_delete[$key] == 'deleted_data'){
                TaskConfigFunction::where('id',$request->function_id[$key])->delete();
            }
            elseif($request->function_id[$key] == 0){
                if($c1 != ''){
                    $check = TaskConfigFunction::where('name',$request->function_name[$key])->where('task_config_id',$gc->id)->first();
                    if($check == null){
                        $gco = new TaskConfigFunction();
                    }else{
                        $gco = TaskConfigFunction::findorfail($check->id);
                    }
                    
                    $gco->task_config_id = $gc->id;
                    $gco->name = $request->function_name[$key];
                    $gco->description = $request->function_description[$key];
                    $gco->privilege = $request->privilege[$key];
                    $gco->created_by = Auth::user()->id;
                    $gco->save();
                }
            }
            elseif($request->function_id[$key] > 0){
                if($c1 != ''){
                    
                    $check = TaskConfigFunction::where('name',$request->function_name[$key])->where('task_config_id',$gc->id)->first();
                    if($check == null){
                        $gco = TaskConfigFunction::findorfail($request->function_id[$key]); 
                    }else if($check->id == $request->function_id[$key]){
                        $gco = TaskConfigFunction::findorfail($request->function_id[$key]);
                    }else{
                        $gco = TaskConfigFunction::findorfail($check->id);
                    }
                    
                    $gco->task_config_id = $gc->id;
                    $gco->name = $request->function_name[$key];
                    $gco->description = $request->function_description[$key];
                    $gco->privilege = $request->privilege[$key];
                    $gco->last_changed_by = Auth::user()->id;
                    $gco->last_changed_date = date('Y-m-d H:i:s');
                    $gco->save();
                    
                    if($check != null){
                        if($check->id != $request->function_id[$key]){
                            TaskConfigFunction::where('id',$request->function_id[$key])->delete();
                        }
                    }
                    
                }
            }
        }
        
        return redirect('taskconfig')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gc = TaskConfig::findorfail($id);
        $gc->delete();
        
        $gco1 = TaskConfigField::where('task_config_id',$id);
        $gco1->delete();
        
        $gco2 = TaskConfigFunction::where('task_config_id',$id);
        $gco2->delete();
        
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    //config type get
    public function gettaskconfig_copy(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $list = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
        
        $fields_array = array(); 
        
        //------TASK_STATUS -------//
        $field_name = 'TASK_STATUS';$field_type = null;$field_type_list = null;
        $field_list = $list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->where('name',$field_name)->first();
        if($field_list != null){
            $field = TaskConfigField::where('task_config_id',$request->id)->where('field_name',$field_list->id)->first();
            if($field != null){
                $field_type = $field->field_type;
                if($field->list != 'N/A'){
                    $list = Lists::where('id', $field->list)->first();
                    $field_type_list = $list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
                }
            }
        }
        $fields_array1 =  array (
            'name' => $field_name,
            'field_type' => $field_type,
            'field_list' =>$field_type_list,
        ); 
        array_push($fields_array, $fields_array1);
        
        //------UNIT_AREA -------//
        // $field_name = 'UNIT_AREA';$field_type = null;$field_type_list = null;
        // $field_list = $list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->where('name',$field_name)->first();
        // if($field_list != null){
        //     $field = TaskConfigField::where('task_config_id',$request->id)->where('field_name',$field_list->id)->orderBy('id', 'desc')->first();
        //     if($field != null){
        //         $field_type = $field->field_type;
        //         if($field->list != 'N/A'){
        //             $list = Lists::where('id', $field->list)->first();
        //             $field_type_list = $list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        //         }
        //     }
        // }
        // $fields_array1 =  array (
        //     'name' => $field_name,
        //     'field_type' => $field_type,
        //     'field_list' =>$field_type_list,
        // ); 
        // array_push($fields_array, $fields_array1);
        
        $data = array();
        $data['fields'] = $fields_array;
        return json_encode($data);
    }
    
    //config type get
    public function gettaskconfig(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $list = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
        
        $fields_array = array(); 
        
        $taskconfig = TaskConfig::where('id',$request->id)->first();
        $fields = TaskConfigField::where('task_config_id',$request->id)->get();
        $task = Task::where('task_config_id', $request->id)->orderBy('name', 'desc')->value('name');
        $max = 1;
        if($task == '' || $task == null){
            $max = 1; 
        }else{
            $max = intval($task)+1;
        }
        foreach ($fields as $value) 
        {
            $field_id = $value->field_name;
            $field_name = null;
            $field_type = $value->field_type;
            $editable = $value->editable;
            $field_type_list = null;
            $field_value = null;
            $field_description = $value->field_description;
            
            
            $field_list = $list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->where('id',$field_id)->first();
            
            if($field_list != null){
                $field_name = $field_list->name;
            }
            if($field_description == null){
                $field_description = $field_name;
            }
            
            $field_type_list_array = array();
            
            if($value->list != 'N/A'){
            
                if($value->list == 'Field'){
                    $field_type_list = Field::whereIn('communitygroup', $auth_user_comgrp)->get();
                    
                    foreach ($field_type_list as $value1) {
                        $field_type_list_array1 =  array (
                            'id' => $value1->id,
                            'name' => $value1->name,
                        ); 
                        array_push($field_type_list_array, $field_type_list_array1);
                    }
                }else if($value->list == 'Person'){
                  $field_type_list = Person::whereIn('communitygroup', $auth_user_comgrp)->get(); 
                   
                    foreach ($field_type_list as $value1) {
                        $field_type_list_array1 =  array (
                            'id' => $value1->id,
                            'name' => $value1->fname.' '.$value1->lname,
                        ); 
                        array_push($field_type_list_array, $field_type_list_array1);
                    }
                }else if($value->list == 'Team'){
                  $field_type_list = Team::with('person')->whereIn('communitygroup', $auth_user_comgrp)->get(); 
                   
                    foreach ($field_type_list as $value1) {
                        $field_type_list_array1 =  array (
                            'id' => $value1->id,
                            'name' => $value1->name,
                        ); 
                        array_push($field_type_list_array, $field_type_list_array1);
                    }
                }else{
                    $list1 = Lists::where('id', $value->list)->first();
                    $field_type_list = $list1->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
                   
                    foreach ($field_type_list as $value1) {
                        $field_type_list_array1 =  array (
                            'id' => $value1->id,
                            'name' => $value1->name,
                        ); 
                        array_push($field_type_list_array, $field_type_list_array1);
                    }
                }
                
            }
            
            if(isset($request->task_id)){
               $task_field = TaskField::where('task_id',$request->task_id)->where('field_id',$field_id)->first();
               if($task_field != null){
                   $field_value = $task_field->value;
               }
            }
            
            $fields_array1 =  array (
                'field_id' => $field_id,
                'field_name' => $field_name,
                'field_description' => $field_description,
                'field_type' => $field_type,
                'field_value' => $field_value,
                'editable' => $editable,
                'field_list' =>$field_type_list_array,
            ); 
            array_push($fields_array, $fields_array1);
        }
        
        $data = array();
        $data['fields'] = $fields_array;
        $data['taskconfig'] = $taskconfig;
        $data['max'] = $max;
        return json_encode($data);
    }
    
   
}
