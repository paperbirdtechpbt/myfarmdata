<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\DashboardSetting;
use App\DashboardSettingObject;
use App\GraphChart;
use App\GraphChartObject;
use App\CommunityGroup;
use App\Lists;
use App\ListChoice;


use Illuminate\Http\Request;

class DashboardSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $dashboardsettings = DashboardSetting::whereIn('com_group', $auth_user_comgrp)->get();
        return view('allpages.dashboardsetting.index', compact('dashboardsettings'));
        
    }
    
    public function create()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        $graphcharts = GraphChart::whereIn('com_group', $auth_user_comgrp)->get();
        
        $chart_list = Lists::where('name', 'SYS_CHART_TYPE')->first();
        $chart_list = $chart_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
            
        return view('allpages.dashboardsetting.create', compact('communitygrp','graphcharts','chart_list'));
    }
    
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ds = new DashboardSetting();
        $ds->name = $request->name;
        $ds->title = $request->title;
        $ds->description = $request->description;
        $ds->com_group = $request->community_group;
        $ds->max_number = $request->max_number;
        $ds->created_by = Auth::user()->id;
        $ds->save();
        
        foreach ($request->object_class as $key => $c1) {
            if($c1 != ''){
                $dso = new DashboardSettingObject();
                $dso->dashboard_setting_id = $ds->id;;
                $dso->object_class = $request->object_class[$key];
                $dso->object_key = $request->object_key[$key];
                $dso->created_by = Auth::user()->id;
                $dso->save();
            }
        }
        
        return redirect('dashboardsetting')->with('success', 'Inserted Successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gc = DashboardSetting::findorfail($id);
        $gc->delete();
        
        $gco = DashboardSettingObject::where('dashboard_setting_id',$id);
        $gco->delete();
        
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
    public function getdashboardobjectkey(Request $request)
    {
        $graphchartobjects = GraphChartObject::where('graphs_charts_id',$request->id)->get();
        $graphchart = GraphChart::where('object_class',$request->id)->get();
        
       
        $data['error'] = 'success';
        $data['keys'] = $graphchart;
        return json_encode($data);
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
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        $graphcharts = GraphChart::whereIn('com_group', $auth_user_comgrp)->get();
        
        $dashboardsetting = DashboardSetting::findorfail($id);
        $dashboardsettingobjects = DashboardSettingObject::where('dashboard_setting_id',$id)->get();
        
        $chart_list = Lists::where('name', 'SYS_CHART_TYPE')->first();
        $chart_list = $chart_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
            
        return view('allpages.dashboardsetting.edit', compact('communitygrp','graphcharts','dashboardsetting','dashboardsettingobjects','chart_list'));
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
        $ds = DashboardSetting::findorfail($id);
        $ds->name = $request->name;
        $ds->title = $request->title;
        $ds->description = $request->description;
        $ds->com_group = $request->community_group;
        $ds->max_number = $request->max_number;
        $ds->last_changed_by = Auth::user()->id;
        $ds->last_changed_date = date('Y-m-d H:i:s');
        $ds->save();
        
        
        foreach ($request->gc_name as $key => $c1) {
            if($c1 == 'deleted_data'){
                DashboardSettingObject::where('id',$request->ds_id[$key])->delete();
            }
            elseif($request->ds_id[$key] == 0){
               
                    $dso = new DashboardSettingObject();
                    $dso->dashboard_setting_id = $ds->id;;
                    $dso->object_class = $request->object_class[$key];
                    $dso->object_key = $request->object_key[$key];
                    $dso->created_by = Auth::user()->id;
                    $dso->save();
                
            }
            elseif($request->ds_id[$key] > 0){
                
                    $dso = DashboardSettingObject::findorfail($request->ds_id[$key]);
                    $dso->dashboard_setting_id = $ds->id;;
                    $dso->object_class = $request->object_class[$key];
                    $dso->object_key = $request->object_key[$key];
                    $dso->last_changed_by = Auth::user()->id;
                    $dso->last_changed_date = date('Y-m-d H:i:s');
                    $dso->save();
                
            }
        }

        return redirect('dashboardsetting')->with('success', 'Updated Successfully');
    }
    
}
