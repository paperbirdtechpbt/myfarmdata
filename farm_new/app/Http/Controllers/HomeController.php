<?php

namespace App\Http\Controllers;

use App\Role;
use App\Pack;
use App\DashboardSettingObject;
use Cookie;
use Illuminate\Support\Facades\Auth;
use App\DashboardSetting;
use App\GraphChart;
use App\GraphChartObject;
use App\CollectActivity;
use App\Collect_activity_result;
use App\CollectData;
use App\Lists;
use App\ListChoice;
use App\Person;
use App\Team;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        
        $cookiename = 'userlogin_roleid';
        $role_id = Cookie::get($cookiename);
        $role = Role::findorfail($role_id);
        $dashboardsettings = DashboardSetting::whereIn('id', explode(',',$role->dashboard_view))->get();
        $packs=Pack::with("unit","communityGroup","collectActivity")->whereIn('community_group_id', $auth_user_comgrp)->get();
        
        return view('dashboard', compact('dashboardsettings','packs'));
    }
    
    public function dashboard()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $cookiename = 'userlogin_roleid';
        $role_id = Cookie::get($cookiename);
        $role = Role::findorfail($role_id);
        $dashboardsettings = DashboardSetting::whereIn('id', explode(',',$role->dashboard_view))->get();
        $packs=Pack::with("unit","communityGroup","collectActivity")->whereIn('community_group_id', $auth_user_comgrp)->get();
        
        return view('dashboard', compact('dashboardsettings','packs'));
    }
    
    public function dashboardevent()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $person = Person::whereIn('communitygroup', $auth_user_comgrp)->get(); 
        $team = Team::with('person')->whereIn('communitygroup', $auth_user_comgrp)->get();
        
        return view('dashboardevent', compact('person','team'));
    }
    
    public function dashboardfield()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $country_list = Lists::where('name', 'SYS_COUNTRIES')->first();
        $country_list = $country_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('dashboardfield', compact('country_list'));
    }
    
    public function getchartdetail(Request $request)
    {
        $collectactivity = CollectActivity::where('name', 'FERMENTATION')->first();
        $dashboard_setting_id = $request->dashboard_setting_id;
        $dashboardsettingobjects = DashboardSettingObject::where('dashboard_setting_id',$dashboard_setting_id)->get();
        
        $data['id'] = $request->dashboard_setting_id;
        
        $dashboard_setting = array();
        
        foreach ($dashboardsettingobjects as $value) 
        {
            $packs_array = array(); 
            $packs = Pack::whereIn('id', $request->pack_id)->get();
            foreach ($packs as $pack) 
            {
                $chart_name = ListChoice::where('id',$value->object_class)->first();
                
                $graphchart = GraphChart::findorfail($value->object_key);
                $graphchartobjects = GraphChartObject::where('graphs_charts_id',$value->object_key)->get();
                $lines = array();
                foreach ($graphchartobjects as $value1)
                {
                    if($value1->line_type == 'Result_Line')
                    {
                    
                        $points = DB::table('collect_data AS cd')
                            ->leftJoin('collect_activity_results AS car', 'cd.result_id', '=', 'car.id')
                            ->select('cd.*')
                            ->where('cd.pack_id', $pack->id)
                            ->where('car.result_class', $value1->result_class)
                            ->WhereNull('cd.deleted_at')
                            ->WhereNull('car.deleted_at')
                            ->orderBy('cd.duration', 'asc')
                            ->get();
                            
                        $point_array = array(); 
                        foreach ($points as $point) 
                        {
                            $point =  array (
                                'id' => $point->id,
                                'pack_id' => $point->pack_id,
                                'value' => $point->value,
                                'create_at' => $point->created_at,
                                'duration' => $point->duration,
                            ); 
                            array_push($point_array, $point); 
                        }
                        
                        $line =  array (
                            'id' => $value1->id,
                            'name' => $value1->name,
                            'line_type' => $value1->line_type,
                            'result_class' =>$value1->result_class,
                            'ref_ctrl_points' =>$value1->ref_ctrl_points,
                            'points' =>$point_array,
                        ); 
                        array_push($lines, $line);
                                
                        
                    }else if($value1->line_type == 'Ref_Control_Line'){
                        
                        $points = $value1->ref_ctrl_points;
                        if($points != null || $points != ''){
                            $point_data = explode(";",$points);
                            
                            $point_array = array(); 
                            foreach ($point_data as $point) 
                            {
                                $val = explode("/",$point);
                                if(count($val) == 2){
                                    $duration = $val[0];
                                    $v = $val[1];
                                
                                    
                                    $point =  array (
                                        'id' => '',
                                        'pack_id' => $pack->id,
                                        'value' => $v,
                                        'create_at' => '',
                                        'duration' => $duration,
                                    ); 
                                    array_push($point_array, $point); 
                                }
                            }
                            
                            $line =  array (
                                'id' => $value1->id,
                                'name' => $value1->name,
                                'line_type' => $value1->line_type,
                                'result_class' =>$value1->result_class,
                                'ref_ctrl_points' =>$value1->ref_ctrl_points,
                                'points' =>$point_array,
                            ); 
                            array_push($lines, $line);
                        }
                        
                        
                        
                    }
                        
                    
                }
                $pack =  array (
                    'id' => $pack->id,
                    'lines' =>$lines,
                ); 
                array_push($packs_array, $pack);
            }
            $dashboard_setting_object =  array (
                'id' => $value->id,
                'object_class' => $value->object_class,
                'object_key' => $value->object_key,
                'graph_type' =>$chart_name->name,
                'graph_name' =>$graphchart->name,
                'graph_desc' =>$graphchart->description,
                'graph_title' =>$graphchart->title,
                'graph_abcissa_title' =>$graphchart->abcissa_title,
                'graph_ordinate_title' =>$graphchart->ordinate_title,
                'packs' =>$packs_array,
            );
            array_push($dashboard_setting, $dashboard_setting_object);
        }
       
         
        $data['charts'] = $dashboard_setting;
        $data['error'] = 'success';

        return json_encode($data);
    }
    
    public function getchartdetail_copy1(Request $request)
    {
        $collectactivity = CollectActivity::where('name', 'FERMENTATION')->first();
        $dashboard_setting_id = $request->dashboard_setting_id;
        
        $packs_array = array(); 
        $packs = Pack::whereIn('id', $request->pack_id)->get();
        foreach ($packs as $pack) 
        {
            $dashboardsettingobjects = DashboardSettingObject::where('dashboard_setting_id',$dashboard_setting_id)->get();
            $dashboard_setting = array();
            
            foreach ($dashboardsettingobjects as $value) 
            {
                $chart_name = ListChoice::where('id',$value->object_class)->first();
                $graphchart = GraphChart::findorfail($value->object_key);
                $graphchartobjects = GraphChartObject::where('graphs_charts_id',$value->object_key)->get();
                $lines = array();
                
                foreach ($graphchartobjects as $value1)
                {
                    if($value1->line_type == 'Result_Line')
                    {
                        $points = DB::table('collect_data AS cd')
                            ->leftJoin('collect_activity_results AS car', 'cd.result_id', '=', 'car.id')
                            ->select('cd.*')
                            ->where('cd.pack_id', $pack->id)
                            ->where('car.result_class', $value1->result_class)
                            ->WhereNull('cd.deleted_at')
                            ->WhereNull('car.deleted_at')
                            ->get();
                        
                        $point_array = array(); 
                        foreach ($points as $point) 
                        {
                           $point =  array (
                                'id' => $point->id,
                                'pack_id' => $point->pack_id,
                                'value' => $point->value,
                                'create_at' => $point->created_at,
                            ); 
                            array_push($point_array, $point); 
                        }
                        $line =  array (
                            'id' => $value1->id,
                            'name' => $value1->name,
                            'line_type' => $value1->line_type,
                            'result_class' =>$value1->result_class,
                            'ref_ctrl_points' =>$value1->ref_ctrl_points,
                            'points' => $point_array
                        ); 
                        array_push($lines, $line);
                    }
                }
                
                $dashboard_setting_object =  array (
                    'id' => $value->id,
                    'object_class' => $value->object_class,
                    'object_key' => $value->object_key,
                    'graph_type' =>$chart_name->name,
                    'graph_name' =>$graphchart->name,
                    'graph_desc' =>$graphchart->description,
                    'graph_title' =>$graphchart->title,
                    'graph_abcissa_title' =>$graphchart->abcissa_title,
                    'graph_ordinate_title' =>$graphchart->ordinate_title,
                    'lines' =>$lines,
                );
                array_push($dashboard_setting, $dashboard_setting_object);
            }
            $pack_ids =  array (
                'id' => $pack->id,
                'dashboard_setting_id' =>$request->dashboard_setting_id,
                'dashboard_setting' => $dashboard_setting
            );
            array_push($packs_array, $pack_ids);
        }
        $data['packs'] = $packs_array;
        $data['error'] = 'success';
        return json_encode($data);
    }
    
    public function getchartdetail1(Request $request)
    {
        $collectactivity = CollectActivity::where('name', 'FERMENTATION')->first();
        $dashboard_setting_id = $request->dashboard_setting_id;
        
        $dashboardsettingobjects = DashboardSettingObject::where('dashboard_setting_id',$dashboard_setting_id)->get();
        $dashboard_setting = array();
        foreach ($dashboardsettingobjects as $value) 
        {
            $packs_array = array(); 
            $packs = Pack::whereIn('id', $request->pack_id)->get();
            foreach ($packs as $pack) 
            {
                
                $pack_ids =  array (
                    'id' => $pack->id,
                );
                array_push($packs_array, $pack_ids);
            }
            $dashboard_setting_object =  array (
                'id' => $value->id,
                'object_class' => $value->object_class,
                'object_key' => $value->object_key,
                'graph_type' =>$chart_name->name,
                'graph_name' =>$graphchart->name,
                'graph_desc' =>$graphchart->description,
                'graph_title' =>$graphchart->title,
                'graph_abcissa_title' =>$graphchart->abcissa_title,
                'graph_ordinate_title' =>$graphchart->ordinate_title,
                'packes' =>$packs_array,
            );
            array_push($dashboard_setting, $dashboard_setting_object);
        }
        $data['charts'] = $dashboard_setting;
        $data['error'] = 'success';
        return json_encode($data);
    }
    
}
