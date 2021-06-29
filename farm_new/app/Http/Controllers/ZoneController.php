<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Zone;
use App\Pack;
use App\Unit;
use App\Lists;
use App\CommunityGroup;
use App\CollectActivity;
use DB;

class ZoneController extends Controller
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
        
        $zones = DB::table('zone AS z')
            ->leftjoin('list_choices AS lc', 'z.type', '=', 'lc.id')
            ->leftjoin('list_choices AS lc2', 'z.class', '=', 'lc2.id')
            ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
            ->select('z.*','lc.name AS type_name','lc2.name AS class_name','cg.name AS com_name')
            ->whereNull('z.deleted_at')
            ->whereIn('z.com_group', $auth_user_comgrp)
            ->get();
            
        return view('allpages.zone.index',compact('zones'));
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
        
        $zones=Zone::whereIn('com_group', $auth_user_comgrp)->get();
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $classes = Lists::where('name', 'SYS_ZONE_CLASS')->first();
        $classes = $classes->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $types = Lists::where('name', 'SYS_ZONE_TYPE')->first();
        $types = $types->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        
        return view('allpages.zone.create',compact('zones','communitygrp','classes','types'));
        
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
        $this->validate($request,[
                'name'=>'required|unique:zone',
                'class'=>'required',
                'community_group'=>'required',
                'description'=>'required',
                'type'=>'required',
            ]);
       
        $zone = Zone::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'com_group'=>$request->community_group,
            'type'=>$request->type,
            'parent_zone'=>$request->parent_zone,
            'class'=>$request->class,
            'created_by'=>Auth::user()->id,
        ]);
         return redirect('zone')->with('success', 'Insert Successfully');
       
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
        $zone = DB::table('zone AS z')
            ->leftjoin('list_choices AS lc', 'z.type', '=', 'lc.id')
            ->leftjoin('list_choices AS lc2', 'z.class', '=', 'lc2.id')
            ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
            ->select('z.*','lc.name AS type_name','lc2.name AS class_name','cg.name AS com_name')
            ->whereNull('z.deleted_at')
            ->where('z.no',$id)
            ->first();
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
         
        $zones=Zone::where('no','!=',$id)->whereIn('com_group', $auth_user_comgrp)->get();
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        $classes = Lists::where('name', 'SYS_ZONE_CLASS')->first();
        $classes = $classes->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $types = Lists::where('name', 'SYS_ZONE_TYPE')->first();
        $types = $types->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        
        return view('allpages.zone.edit',compact('zones','communitygrp','classes','types','zone'));
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
        $this->validate($request,[
                // 'name'=>'required|unique:zone',
                'class'=>'required',
                'community_group'=>'required',
                'description'=>'required',
                'type'=>'required',
            ]);
       
        $zone = Zone::where('no',$id)->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'com_group'=>$request->community_group,
            'type'=>$request->type,
            'parent_zone'=>$request->parent_zone,
            'class'=>$request->class,
            'last_changed_by'=>Auth::user()->id,
            'last_changed_date'=>date("Y-m-d H:i:s"),
            'last_changed_utc'=>date("Y-m-d H:i:s"),
           
        ]);
        
        
        return redirect()->route('zone.index')->with('success','Update Data Successfull');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($no)
    {
        $zone=Zone::where('no',$no);
        $zone->update([
            'deleted_at'=>date("Y-m-d H:i:s"),
        ]);
        $zone->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
    
}
