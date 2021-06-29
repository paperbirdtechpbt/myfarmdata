<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notification;
use DB;

class NotificationController extends Controller
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
        
        $notifications = DB::select( DB::raw("SELECT n.id,n.result_id,car.result_name,n.message,n.level,lc.name as 'level_name',lc1.name as 'type_name',n.status,n.closed from notifications n left join collect_activity_results car on n.result_id = car.id left join list_choices lc on n.level = lc.id left join list_choices lc1 on lc1.id = n.type"));
        return view('allpages.notification.index',compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    
    public function changeStatus(Request $request)
    {
        $incident = Notification::find($request->id);
        $incident->closed =  $request->status;
        $incident->closed_by = Auth::user()->id;
        $incident->closed_date = date('Y-m-d H:i:s');
        $incident->save();

        return response()->json(['success'=>'Status Change Successfull']);
    }
    
   
    
 
    
     
}


