<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Container;
use App\ContainerObjectArch;
use App\Zone;
use App\Pack;
use App\Unit;
use App\Lists;
use App\CommunityGroup;
use App\CollectActivity;
use DB;

class ContainerObjectArchController extends Controller
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
        
        // $containers = DB::table('container AS z')
        //     ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
        //     ->select('z.*','cg.name AS com_name')
        //     ->whereNull('z.deleted_at')
        //     ->whereIn('com_group', $auth_user_comgrp)
        //     ->get();
            
        $containers = DB::table('arch_container_object AS z')
            ->leftjoin('container AS cg', 'z.container_no', '=', 'cg.id')
            ->select('z.*','cg.name AS container_name')
            ->whereNull('z.deleted_date')
            ->whereIn('cg.com_group', $auth_user_comgrp)
            ->get();
            
        return view('allpages.containerarch.index',compact('containers'));
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
        
        $type = Lists::where('name', 'SYS_CONTAINER_TYPE')->first();
        $type = $type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $status = Lists::where('name', 'SYS_CONTAINER_STATUS')->first();
        $status = $status->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $capacity_units = Unit::whereIn('communitygroup', $auth_user_comgrp)->get();
        $zone = Zone::whereIn('com_group', $auth_user_comgrp)->get();
        $parent_container = Container::whereIn('com_group', $auth_user_comgrp)->get();
        
        $notification_level = Lists::where('name', 'SYS_NOTIF_LEVEL')->first();
        $notification_level = $notification_level->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
            
        $object_type = Lists::where('name', 'SYS_CONT_OBJ_TYPE')->first();
        $object_type = $object_type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $object_class = Lists::where('name', 'SYS_CONT_OBJ_CLASS')->first();
        $object_class = $object_class->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $containers = DB::table('container AS z')
            ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
            ->select('z.*','cg.name AS com_name')
            ->whereNull('z.deleted_at')
            ->whereIn('com_group', $auth_user_comgrp)
            ->get();
            
        return view('allpages.containerarch.create',compact('type','status','capacity_units','zone','parent_container','notification_level','communitygrp','object_type','object_class','containers'));
        
    }
    public function unit(){
        return Unit::pluck('name','id');
    }
    public function communityGroup(){
        return CommunityGroup::pluck('name','id');
    }
    public function collectActivity(){
       return CollectActivity::pluck('name','id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'name'=>'required|unique:container',
        //     'community_group'=>'required',
        //     'description'=>'required',
        // ]);
       
        // $container = Container::create([
        //     'name'=>$request->name,
        //     'description'=>$request->description,
        //     'com_group'=>$request->community_group,
        //     'type'=>$request->type,
        //     'status'=>$request->status,
        //     'max_capacity'=>$request->max_capacity,
        //     'capacity_units'=>$request->capacity_units,
        //     'zone'=>$request->zone,
        //     'notification_level'=>$request->notification_level,
        //     'parent_container'=>$request->parent_container,
        //     'created_by'=>Auth::user()->id,
        //     'created_date_utc'=>date("Y-m-d H:i:s"),
        //     'last_changed_date'=>date("Y-m-d H:i:s"),
        //     'last_changed_by'=>Auth::user()->id,
        //     'last_changed_utc'=>date("Y-m-d H:i:s"),
        // ]);
        // $lastInsertedId= $container->id;
        
        // foreach ($request->object_name as $key => $c1) {
        //     if($c1 != ''){
                
                $container = ContainerObjectArch::create([
                    'object_name'=>$request->object_name,
                    'container_no'=>$request->c_id,
                    'object_no'=>$request->object_no,
                    'type'=>$request->object_type,
                    'class'=>$request->object_class,
                    'session_id'=>Auth::user()->id,
                    'added_date'=>date("Y-m-d H:i:s"),
                    'added_by'=>Auth::user()->id,
                    'added_utc'=>date("Y-m-d H:i:s"),
                ]);
                // $choices = new ListChoice(['name'=>$c1, 'choice_communitygroup'=>$choice_communitygroup[$key], 'community_group_id'=>$request->community_group_id]);
                
        //     }
        // }
        return redirect('containerarch')->with('success', 'Insert Successfully');
       
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
        $container = ContainerObjectArch::where('id', $id)->first();
       // $containerobject = ContainerObject::where('container_no', $id)->get();
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $type = Lists::where('name', 'SYS_CONTAINER_TYPE')->first();
        $type = $type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $status = Lists::where('name', 'SYS_CONTAINER_STATUS')->first();
        $status = $status->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $capacity_units = Unit::whereIn('communitygroup', $auth_user_comgrp)->get();
        $zone = Zone::whereIn('com_group', $auth_user_comgrp)->get();
        $parent_container = Container::whereIn('com_group', $auth_user_comgrp)->where('id','!=', $id)->get();
        
        $notification_level = Lists::where('name', 'SYS_NOTIF_LEVEL')->first();
        $notification_level = $notification_level->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
            
        $object_type = Lists::where('name', 'SYS_CONT_OBJ_TYPE')->first();
        $object_type = $object_type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $object_class = Lists::where('name', 'SYS_CONT_OBJ_CLASS')->first();
        $object_class = $object_class->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
         $containers = DB::table('container AS z')
            ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
            ->select('z.*','cg.name AS com_name')
            ->whereNull('z.deleted_at')
            ->whereIn('com_group', $auth_user_comgrp)
            ->get();
        
        return view('allpages.containerarch.edit',compact('type','status','capacity_units','zone','parent_container','notification_level','communitygrp','container','object_type','object_class','containers'));
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
        $container = ContainerObjectArch::where('id',$id)->update([
            'object_name'=>$request->object_name,
            'container_no'=>$request->c_id,
            'object_no'=>$request->object_no,
            'type'=>$request->object_type,
            'class'=>$request->object_class,
            'session_id'=>Auth::user()->id,
        ]);
        return redirect()->route('containerarch.index')->with('success','Update Data Successfull');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($no)
    {
        $container=ContainerObjectArch::where('id',$no);
        $container->update([
            'deleted_date'=>date("Y-m-d H:i:s"),
            'deleted_by'=>Auth::user()->id,
            'deleted_utc'=>date("Y-m-d H:i:s"),
        ]);
        $container->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
    
}
