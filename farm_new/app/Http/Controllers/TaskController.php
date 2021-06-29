<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\CommunityGroup;
use App\TaskConfig;
use App\TaskConfigFunction;
use App\TaskConfigField;
use App\Field;
use App\Task;
use App\TaskField;
use App\Event;
use App\Lists;
use App\ListChoice;
use App\TaskObject;
use DB;
use App\Container;
use App\Unit;
use App\CollectActivity;
use App\User;
use App\Pack;
use App\TaskMediaFile;

class TaskController extends Controller
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
        
        // $tasks = Task::whereIn('com_group', $auth_user_comgrp)->get();
        $tasks = Task::select("tasks.*","task_configs.name as task_config_name","task_configs.name_prefix as name_prefix")
            ->join("task_configs", "task_configs.id", "=", "tasks.task_config_id")
            ->whereIn('tasks.com_group', $auth_user_comgrp)
            ->whereIn('task_configs.com_group', $auth_user_comgrp)
            ->get();
        // dd($users);
                        
       
        
    
        return view('allpages.task.index',compact('tasks'));
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
        $taskconfigs = TaskConfig::whereIn('com_group', $auth_user_comgrp)->get();
        
        
        return view('allpages.task.create',compact('communitygrp','taskconfigs'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $exp_start_date = date('Y-m-d H:i:s');
        // $exp_end_date = date('Y-m-d H:i:s');
        // $actual_start_date = date('Y-m-d H:i:s');
        // $actual_end_date = date('Y-m-d H:i:s');

        $exp_start_date = null;
        $exp_end_date = null;
        $actual_start_date = null;
        $actual_end_date = null;
        
        $exp_duration = 10;
        $actual_duration = 10;
        $responsible = null;
        $assigned_team = null;
        
        $task = Task::where('task_config_id', $request->config_type)->max('id');
        $max = 1;
        if($task == '' || $task == null){
            $max = 1; 
        }else{
            $max = intval($task)+1;
        }
        
        $gc = new Task();
        $gc->name = $max;
        $gc->description = $request->description;
        $gc->task_config_id = $request->config_type;
        $gc->com_group = $request->community_group;
        $gc->created_by = Auth::user()->id;
        $gc->save();
        
        $task_id = $gc->id;
        
        $field_array = json_decode($request->field_array);
        foreach ($field_array as $key => $value) {

            $f_id = $value->f_id;
            $f_value = $value->f_value;
            if($f_value != ''){
                if(is_array($f_value)){
                    $f_value = implode(',',$f_value);
                }else{
                    $f_value = $field_array[$key]->f_value;
                }
                $gco = new TaskField();
                $gco->task_id = $task_id;
                $gco->value = $f_value;
                $gco->field_id = $f_id;
                $gco->save();
                
                $field = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
                $field = $field->choices()->where('id', $f_id)->first();
               
                if($field->name == 'EXP_START_DATE'){ $exp_start_date = $f_value; }
                if($field->name == 'EXP_END_DATE'){ $exp_end_date = $f_value; }
                if($field->name == 'EXP_DURATION'){ $exp_duration = $f_value; }
                if($field->name == 'START_DATE'){ $actual_start_date = $f_value; }
                if($field->name == 'END_DATE'){ $actual_end_date = $f_value; }
                
                if($field->name == 'RESPONSIBLE'){ $responsible = $f_value; }
                if($field->name == 'TEAM_ASSIGNED'){ $assigned_team = $f_value; }
            }
        }
        // foreach ($request->f_name as $key => $value) {
        //     if($value != null){
        //         $gco = new TaskField();
        //         $gco->task_id = $task_id;
        //         $gco->value = $request->f_name[$key];
        //         $gco->field_id = $request->f_id[$key];
        //         $gco->save();
                
        //         $field = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
        //         $field = $field->choices()->where('id', $request->f_id[$key])->first();
               
        //         if($field->name == 'EXP_START_DATE'){ $exp_start_date = $request->f_name[$key]; }
        //         if($field->name == 'EXP_END_DATE'){ $exp_end_date = $request->f_name[$key]; }
        //         if($field->name == 'EXP_DURATION'){ $exp_duration = $request->f_name[$key]; }
        //         if($field->name == 'START_DATE'){ $actual_start_date = $request->f_name[$key]; }
        //         if($field->name == 'END_DATE'){ $actual_end_date = $request->f_name[$key]; }
                
        //         if($field->name == 'RESPONSIBLE'){ $responsible = $request->f_name[$key]; }
        //         if($field->name == 'TEAM_ASSIGNED'){ $assigned_team = $request->f_name[$key]; }
        //     }
        // }
        
        $taskconfig = TaskConfig::findorfail($request->config_type);
        if($taskconfig->record_event == 1){
            $gc = new Event();
            $gc->name = $request->name1.sprintf('%04d', $max);
            $gc->description = $request->description;
            $gc->exp_start_date = $exp_start_date;
            $gc->exp_end_date = $exp_end_date;
            $gc->exp_duration = $exp_duration;
            $gc->actual_start_date = $actual_start_date;
            $gc->actual_end_date = $actual_end_date;
            $gc->actual_duration = $actual_duration;
            $gc->com_group = $request->community_group;
            $gc->responsible = $responsible;
            $gc->assigned_team = $assigned_team;
            $gc->created_by = Auth::user()->id;
            $gc->task_id = $task_id;
            $gc->save();
        }
        
        
        $msg = 'Inserted Successfully. '.'Task : '.$request->name1.sprintf('%04d', $max);
        return redirect('task')->with('success', $msg);
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
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        
        
        $task = Task::findorfail($id);
        $taskconfig = TaskConfig::where('id',$task->task_config_id)->first();
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        $taskconfigs = TaskConfig::whereIn('com_group', $auth_user_comgrp)->get();
        $taskconfigfunction = TaskConfigFunction::where('task_config_id', $task->task_config_id)->get();
       
        $taskconfigfields = TaskConfigField::where('task_config_id',$task->task_config_id)->get();
        $function_list = Lists::where('name', 'SYS_TASK_CONFIG_FUNCTION')->first();
        $function_list = $function_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        $filter_function_list = $function_list;
        $function_list = $filter_function_list->filter(function ($value, $key) use($taskconfigfunction) {
           
            
    return in_array($value->id,$taskconfigfunction->pluck('name')->toArray());
    

        
        // dd($communitygrp);
        // $queries = \DB::getQueryLog();
        // return dd($queries);
        
       
});
     $unit=$this->unit();
      $collectActivity=$this->collectActivity();
     $communityGroup = User::with(array('communitygrp' => function($query){
             $query->where('user_id', Auth::user()->id);
            //  $query->whereIn('community_groups.id', 'users.community_group_id');
        }))->where('users.id', Auth::user()->id)->get();
// $containers = DB::table('container AS z')
//             ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
//             ->select('z.*','cg.name AS com_name')
//             ->whereNull('z.deleted_at')
//             ->where('com_group',2)
//             ->get();
          $object_type = Lists::where('name', 'SYS_CONT_OBJ_TYPE')->first();
        $object_type = $object_type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $object_class = Lists::where('name', 'SYS_CONT_OBJ_CLASS')->first();
        $object_class = $object_class->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        return view('allpages.task.edit',compact('communitygrp','taskconfigs','task','taskconfig','taskconfigfunction','function_list','communityGroup','communityGroup','unit','collectActivity','object_type','object_class'));
    
        
    }

 public function taskContainer(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $containers = DB::table('container AS z')
            ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
            ->select('z.*','cg.name AS com_name')
            ->whereNull('z.deleted_at')
            ->whereIn('com_group', $auth_user_comgrp)
            ->get();
        return response()->json(['data' => $containers,'success' => true, 'message' => 'success'], 200);
    }
    
    
    public function taskPacks(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        // $packs=Pack::where('community_group_id', $request->community_group)->where('is_active',1)->get();
        $packs=Pack::with("unit","communityGroup","collectActivity")->whereIn('community_group_id', $auth_user_comgrp)->where('is_active',1)->get();
        return response()->json(['data' => $packs,'success' => true, 'message' => 'success'], 200);
    }
    public function getPack(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        
        $taskObject = TaskObject::where('task_id',$request->task_id)->where('function','CREATE_PACK')->first();
        $pack=Pack::where('initial_task_no',$request->task_id)->first();
        
        
        return response()->json(['data' => $pack,'taskObject' =>$taskObject, 'success' => true, 'message' => 'success'], 200);
    }
    
    public function taskStartEndDate(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
       
        if($request->task_func == 169){
            $field_id = 134;
        }else{
            $field_id = 135;
        }
        
        $taskExpStartEnd = TaskField::where('task_id',$request->task_id)->where('field_id',$field_id)->first();
        
        return response()->json(['data' => $taskExpStartEnd, 'success' => true, 'message' => 'success'], 200);
    }
    
    public function getMediaFiles(Request $request)
    {
        $files=TaskMediaFile::where('task_id', $request->task_id)->get();
        return response()->json(['data' => $files, 'success' => true, 'message' => 'success'], 200);
    }
    
    public function taskPersons(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $person = DB::table('people')
            ->join('community_groups', 'people.communitygroup', '=', 'community_groups.id')
            ->select('people.*','community_groups.name as com_group')
            ->whereIn('people.communitygroup', $auth_user_comgrp)
            ->whereNull('people.deleted_at')
            ->get();
        return response()->json(['data' => $person, 'success' => true, 'message' => 'success'], 200);
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
        
       //  dd($request->all());
        // $exp_start_date = date('Y-m-d H:i:s');
        // $exp_end_date = date('Y-m-d H:i:s');
        // $actual_start_date = date('Y-m-d H:i:s');
        // $actual_end_date = date('Y-m-d H:i:s');
        
        $exp_start_date = null;
        $exp_end_date = null;
        $actual_start_date = null;
        $actual_end_date = null;
        
        
        $exp_duration = 10;
        $actual_duration = 10;
        $responsible = null;
        $assigned_team = null;
        
        $delete = TaskField::where('task_id',$id);
        $delete->delete();
        
        $gc = Task::findorfail($id);
        $task_func = $gc->task_func;
        $gc->name = $request->name;
        $gc->description = $request->description;
        $gc->task_config_id = $request->config_type;
        $gc->com_group = $request->community_group;
        $gc->task_func = $request->task_func;
        $gc->last_changed_by = Auth::user()->id;
        $gc->last_changed_date = date('Y-m-d H:i:s');
        $gc->save();
        
        $task_id = $id;
        
        $field_array = json_decode($request->field_array);
        foreach ($field_array as $key => $value) {

            $f_id = $value->f_id;
            $f_value = $value->f_value;
            if($f_value != ''){
                if(is_array($f_value)){
                    $f_value = implode(',',$f_value);
                }else{
                    $f_value = $field_array[$key]->f_value;
                }
                $gco = new TaskField();
                $gco->task_id = $task_id;
                $gco->value = $f_value;
                $gco->field_id = $f_id;
                $gco->save();
                
                $field = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
                $field = $field->choices()->where('id', $f_id)->first();
               
                if($field->name == 'EXP_START_DATE'){ $exp_start_date = $f_value; }
                if($field->name == 'EXP_END_DATE'){ $exp_end_date = $f_value; }
                if($field->name == 'EXP_DURATION'){ $exp_duration = $f_value; }
                if($field->name == 'START_DATE'){ 
                    
                    
                    $actual_start_date = $f_value; 
                    

                    
                }
                if($field->name == 'END_DATE'){ 
                    
                    $actual_end_date = $f_value;
                    
                   
                    
                    
                }
                
                
                
       
                
                if($field->name == 'RESPONSIBLE'){ $responsible = $f_value; }
                if($field->name == 'TEAM_ASSIGNED'){ $assigned_team = $f_value; }
            }
        }
        
       
        
        // foreach ($request->f_name as $key => $value) {
        //     if($value != null){
        //         $gco = new TaskField();
        //         $gco->task_id = $task_id;
        //         $gco->value = $request->f_name[$key];
        //         $gco->field_id = $request->f_id[$key];
        //         $gco->save();
                
        //         $field = Lists::where('name', 'SYS_TASK_CONFIG_FIELD')->first();
        //         $field = $field->choices()->where('id', $request->f_id[$key])->first();
               
        //         if($field->name == 'EXP_START_DATE'){ $exp_start_date = $request->f_name[$key]; }
        //         if($field->name == 'EXP_END_DATE'){ $exp_end_date = $request->f_name[$key]; }
        //         if($field->name == 'EXP_DURATION'){ $exp_duration = $request->f_name[$key]; }
        //         if($field->name == 'START_DATE'){ $actual_start_date = $request->f_name[$key]; }
        //         if($field->name == 'END_DATE'){ $actual_end_date = $request->f_name[$key]; }
                
        //         if($field->name == 'RESPONSIBLE'){ $responsible = $request->f_name[$key]; }
        //         if($field->name == 'TEAM_ASSIGNED'){ $assigned_team = $request->f_name[$key]; }
        //     }
        // }
        
        $taskconfig = TaskConfig::findorfail($request->config_type);
        if($taskconfig->record_event == 1){
            $getrecord = Event::where('task_id', $task_id)->first();
            if($getrecord != null){
                
                $gc = Event::findorfail($getrecord->id);
        
            
                $gc->name = $request->name1;
                $gc->description = $request->description;
                $gc->exp_start_date = $exp_start_date;
                $gc->exp_end_date = $exp_end_date;
                $gc->exp_duration = $exp_duration;
                $gc->actual_start_date = $actual_start_date;
                $gc->actual_end_date = $actual_end_date;
                $gc->actual_duration = $actual_duration;
                $gc->com_group = $request->community_group;
                $gc->responsible = $responsible;
                $gc->assigned_team = $assigned_team;
                $gc->last_changed_by = Auth::user()->id;
                $gc->last_changed_date = date('Y-m-d H:i:s');
                $gc->task_id = $task_id;
                $gc->save();
            }
        }
        return redirect('task')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gc = Task::findorfail($id);
        $gc->delete();
        
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
    public function destroytaskobject($id)
    {
        $gc = TaskObject::findorfail($id);
        $gc->delete();
        
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
   public function taskExecuteFunction(Request $request)
   {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        
        //---FOR TIMEZONE---//
        $field = Lists::where('name', 'SYS_UTC_TIMEZONE')->first();
        $field = $field->choices()->where('id', $auth_user->timezone)->first();
        
        
        $timezonedetail = explode("UTC",$field->name);
        $sign = '+';
        
        if (strpos($timezonedetail[1], '-') !== false) {
            $sign = '-';
        }
        $timezonedetail1 = explode($sign,$timezonedetail[1]);
        $timezonedetail2 = explode(":",$timezonedetail1[1]);
        
        $hours = $timezonedetail2[0] * 60;
        $minutes = $hours + $timezonedetail2[1];
        
        
        $old = new \DateTimeZone(date_default_timezone_get());
        $new = new \DateTimeZone("UTC");
        $date = new \DateTime( now(), $old );
        $date->setTimezone( $new);
        $newdate = $date->format('Y-m-d H:i:s');
        
        $newtimestamp = strtotime($newdate .$sign. $minutes.' minute');
        $userutcdate = date('Y-m-d\TH:i', $newtimestamp);
        
        //-----//
        
        if($request->task_func == 169){
             $taskField = TaskField::where('task_id',$request->task_id)->where('field_id',134)->first();
             $taskExpStart = TaskField::where('task_id',$request->task_id)->where('field_id',129)->first();
             
             
             if($taskExpStart != null){
                $taskExpStartTime = strtotime($taskExpStart->value);
                $taskStartTime = strtotime(now());
                if ($taskStartTime > $taskExpStartTime){
                    Task::where('id',$request->task_id)->update(['started_late' => true]);
                }
                 
             }
             if($taskField == null){
                  $taskField = new TaskField();
             }
                $taskField->task_id = $request->task_id;
                // $taskField->value =  date("Y-m-d\TH:i", strtotime(now()));
                $taskField->value =  $userutcdate;
                $taskField->field_id = 134;
                $taskField->save();
                Task::where('id',$request->task_id)->update(['status' => 'started']);
                return response()->json(['data' => $taskField,'success' => true, 'message' => 'success'], 200);

        }
        
        if($request->task_func == 170){
             $taskField = TaskField::where('task_id',$request->task_id)->where('field_id',135)->first();
              $taskExpEnd = TaskField::where('task_id',$request->task_id)->where('field_id',131)->first();
             
             
             if($taskExpEnd != null){
                $taskExpEndTime = strtotime($taskExpEnd->value);
                $taskEndTime = strtotime(now());
                if ($taskEndTime > $taskExpEndTime){
                    Task::where('id',$request->task_id)->update(['ended_late' => true]);
                }
                 
             }
             if($taskField == null){
                  $taskField = new TaskField();
             }
                $taskField->task_id = $request->task_id;
                // $taskField->value =  date("Y-m-d\TH:i", strtotime(now()));
                $taskField->value =  $userutcdate;
                $taskField->field_id = 135;
                $taskField->save();
                Task::where('id',$request->task_id)->update(['status' => 'completed']);
             return response()->json(['data' => $taskField,'success' => true, 'message' => 'success'], 200);
       }
       
        else if($request->task_func == 176){
           
            if($request->container == ''){
               return response()->json(['success' => false, 'message' => 'Select container'], 200);
            }
            $taskStartDate = TaskField::where('field_id',134)->where('task_id',$request->task_id)->first();
            if($taskStartDate == null){
                return response()->json(['success' => false, 'message' => 'Task not started yet. Please start task first'], 200);
            }else{
                $taskObject = TaskObject::where('task_id',$request->task_id)->where('function','CONTAINER')->where('no',$request->container)->first();
                $Container = Container::where('id',$request->container)->first();
                if($taskObject == null){
                    $taskObject = new TaskObject();
                    $taskObject->task_id = $request->task_id;
                    $taskObject->function =  'CONTAINER';
                    $taskObject->no =  $request->container;
                    $taskObject->name =  $Container->name;
                    $taskObject->type =  $Container->type;
                    $taskObject->class = $Container->class;
                    $taskObject->last_changed_by = Auth::user()->id;
                    $taskObject->last_changed_date = date('Y-m-d H:i:s');
                    $taskObject->origin = 'ADDED';
                    $taskObject->save();
                    return response()->json(['success' => true, 'message' => 'success'], 200);
                }else{
                    return response()->json(['success' => true, 'message' => 'success'], 200);
                }
            }
            
        }
        else if($request->task_func == 171){
           
            if($request->person == ''){
               return response()->json(['success' => false, 'message' => 'Select Person'], 200);
            }
            $taskStartDate = TaskField::where('field_id',134)->where('task_id',$request->task_id)->first();
            
            if($taskStartDate == null){
                return response()->json(['success' => false, 'message' => 'Task not started yet. Please start task first'], 200);
            }else{
                
                $taskObject = TaskObject::where('task_id',$request->task_id)->where('function','PERSON')->where('no',$request->person)->first();
                $person = DB::table('people')->where('id',$request->person)->first();
             
                if($taskObject == null){
                    $taskObject = new TaskObject();
                    $taskObject->task_id = $request->task_id;
                    $taskObject->function =  'PERSON';
                    $taskObject->no =  $request->person;
                    $taskObject->name =  $person->fname.' '.$person->lname;
                    $taskObject->type =  $person->person_type;
                    $taskObject->class = $person->person_class;
                    $taskObject->last_changed_by = Auth::user()->id;
                    $taskObject->last_changed_date = date('Y-m-d H:i:s');
                    $taskObject->origin = 'ADDED';
                    $taskObject->save();
                    return response()->json(['success' => true, 'message' => 'success'], 200);
                }else{
                    return response()->json(['success' => true, 'message' => 'success'], 200);
                //   return response()->json(['success' => false, 'message' => 'Already Selected.'], 200); 
                }
                
            }
            
        }
        else if($request->task_func == 175 ){
           
            if($request->pack == ''){
               return response()->json(['success' => false, 'message' => 'Select pack'], 200);
            }
            $taskStartDate = TaskField::where('field_id',134)->where('task_id',$request->task_id)->first();
            
            if($taskStartDate == null){
                 return response()->json(['success' => false, 'message' => 'Task not started yet. Please start task first'], 200);
            }else{
                $taskObject = TaskObject::where('task_id',$request->task_id)->where('function','PACK')->where('no',$request->pack)->first();
                $pack = Pack::where('id',$request->pack)->first();
                if($taskObject == null){
                    $taskObject = new TaskObject();
                    $taskObject->task_id = $request->task_id;
                    $taskObject->no =  $request->pack;
                    $taskObject->function =  'PACK';
                    $taskObject->name =  $pack->species;
                    $taskObject->type =  $pack->type;
                    $taskObject->class = $pack->class;
                    $taskObject->last_changed_by = Auth::user()->id;
                    $taskObject->last_changed_date = date('Y-m-d H:i:s');
                    $taskObject->origin = 'ADDED';
                    $taskObject->save();
                    
                    $pack->update([
                        'initial_task_no'=>$request->task_id,
                        'updated_by'=>Auth::user()->id,
                    ]);
                    return response()->json(['success' => true, 'message' => 'success'], 200);
                }else{
                     return response()->json(['success' => true, 'message' => 'success'], 200);
                }
            }
        }
        
        else if($request->task_func == 173 ){
            if($request->TotalFiles > 0){
               for ($x = 0; $x < $request->TotalFiles; $x++) 
                {
                    if ($request->hasFile('files'.$x)) 
                    {
                        $file      = $request->file('files'.$x);
                        $name = time().'_'.$file->getClientOriginalName();
                        $file->move(public_path() . '/file_upload/media/', $name);
                        
                        $TaskMediaFile = new TaskMediaFile();
                        $TaskMediaFile->task_id = $request->task_id;
                        $TaskMediaFile->name = $name;
                        $TaskMediaFile->created_by = Auth::user()->id;
                        $TaskMediaFile->save();
                        
                    }
                }
                 return response()->json(['success' => true, 'message' => 'success'], 200);
            }else{
               return response()->json(['success' => false, 'message' => 'Please Attach Media'], 200);
            }
           
        }
      
    }
    
    public function unit(){
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        return Unit::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
    }
    
    public function communityGroup(){
        return CommunityGroup::pluck('name','id');
    }
    
    public function collectActivity(){
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
       return CollectActivity::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
    }
    
    public function gettaskobjects(Request $request){
        
        $taskObject = TaskObject::where('task_id',$request->task_id)->get();
        
        return response()->json(['taskObject' => $taskObject, 'success' => true, 'message' => 'success'], 200);    }
    }
