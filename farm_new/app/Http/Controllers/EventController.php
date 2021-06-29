<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\CommunityGroup;
use App\Person;
use App\Team;
use App\Event;
use App\Task;

use App\Field;

use App\TaskField;

use App\TaskConfig;
use App\TaskConfigField;
use App\TaskConfigFunction;
use App\Lists;
use App\ListChoice;


use DB;

class EventController extends Controller
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
        
        $events = Event::whereIn('com_group', $auth_user_comgrp)->get();
        return view('allpages.event.index',compact('events'));
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
        $person = Person::whereIn('communitygroup', $auth_user_comgrp)->get(); 
        $team = Team::with('person')->whereIn('communitygroup', $auth_user_comgrp)->get(); 
        
        $event_type = Lists::where('name', 'SYS_EVENT_TYPE')->first();
        $event_type = $event_type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $event_status = Lists::where('name', 'SYS_EVENT_STATUS')->first();
        $event_status = $event_status->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.event.create',compact('communitygrp','event_type','event_status','person','team'));
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gc = new Event();
        $gc->name = $request->name;
        $gc->description = $request->description;
        $gc->type = $request->type;
        $gc->exp_start_date = $request->exp_start_date;
        $gc->exp_end_date = $request->exp_end_date;
        $gc->exp_duration = $request->exp_duration;
        $gc->actual_start_date = $request->actual_start_date;
        $gc->actual_end_date = $request->actual_end_date;
        $gc->actual_duration = $request->actual_duration;
        $gc->com_group = $request->community_group;
        $gc->status = $request->status;
        $gc->responsible = $request->responsible;
        $gc->assigned_team = $request->assigned_team;
        $gc->created_by = Auth::user()->id;
        $gc->closed = $request->closed;
        if( $request->closed == 1){
            $gc->closed_date = date('Y-m-d H:i:s');
            $gc->closed_by =  Auth::user()->id;
        }
        
        $gc->save();
        return redirect('event')->with('success', 'Inserted Successfully');
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
        
        $event = Event::findorfail($id);
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        $person = Person::whereIn('communitygroup', $auth_user_comgrp)->get(); 
        $team = Team::with('person')->whereIn('communitygroup', $auth_user_comgrp)->get(); 
        
        $event_type = Lists::where('name', 'SYS_EVENT_TYPE')->first();
        $event_type = $event_type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $event_status = Lists::where('name', 'SYS_EVENT_STATUS')->first();
        $event_status = $event_status->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.event.edit',compact('communitygrp','event_type','event_status','person','team','event'));
    
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
        $gc = Event::findorfail($id);
        
        $gc->name = $request->name;
        $gc->description = $request->description;
        $gc->type = $request->type;
        $gc->exp_start_date = $request->exp_start_date;
        $gc->exp_end_date = $request->exp_end_date;
        $gc->exp_duration = $request->exp_duration;
        $gc->actual_start_date = $request->actual_start_date;
        $gc->actual_end_date = $request->actual_end_date;
        $gc->actual_duration = $request->actual_duration;
        $gc->com_group = $request->community_group;
        $gc->status = $request->status;
        $gc->responsible = $request->responsible;
        $gc->assigned_team = $request->assigned_team;
        $gc->last_changed_by = Auth::user()->id;
        $gc->last_changed_date = date('Y-m-d H:i:s');
        $gc->closed = $request->closed;
        
        if( $request->closed == 1){
            $gc->closed_date = date('Y-m-d H:i:s');
            $gc->closed_by =  Auth::user()->id;
        }
        $gc->save();
        
        return redirect('event')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gc = Event::findorfail($id);
        $gc->delete();
        
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
    public function getEvents(Request $request)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $events = Event::whereIn('com_group', $auth_user_comgrp);
        if($request->person !=null){
            $events->where('responsible',$request->person);
        }
        if($request->team !=null){
            $events->where('assigned_team',$request->team);
        }
        $events = $events->get();
        
        $event_array = array(); 
        foreach ($events as $event) 
        {
            $url = 0;
            $task_id = null;
            if($event->task_id != null){
               $task = Task::where('id',$event->task_id)->first();
                if($task !=null){
                    if($task != null){
                        $url = 1;
                        $task_id = $event->task_id;
                    }  
               }
              
                
            }
            $event1 =  array (
                'id' => $event->id,
                'name' => $event->name,
                'exp_start_date' => $event->exp_start_date,
                'exp_end_date' => $event->exp_end_date,
                'actual_start_date' => $event->actual_start_date,
                'actual_end_date' => $event->actual_end_date,
                'task_id' => $task_id,
                'url' => $url,
            ); 
            array_push($event_array, $event1); 
        }
                        
        $data = array();
        $data['events'] = $event_array;
        $data['today_date'] = date('Y-m-d');
    
        return json_encode($data);
    }
    
   
}
