<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\GraphChart;
use App\GraphChartObject;
use App\Lists;
use App\ListChoice;
use App\CommunityGroup;

use Illuminate\Http\Request;

class GraphsChartsController extends Controller
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
        
        $graphcharts = GraphChart::whereIn('com_group', $auth_user_comgrp)->get();
        return view('allpages.graphchart.index', compact('graphcharts'));
    }
    
    public function create()
    {
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        
        $object_class_list = Lists::where('name', 'SYS_LINE_TYPE')->first();
        $object_class_list = $object_class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $chart_list = Lists::where('name', 'SYS_CHART_TYPE')->first();
        $chart_list = $chart_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.graphchart.create', compact('communitygrp','object_class_list','chart_list'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gc = new GraphChart();
        $gc->name = $request->name;
        $gc->description = $request->description;
        $gc->com_group = $request->community_group;
        $gc->object_class = $request->object_class;
        $gc->title = $request->title;
        $gc->abcissa_title = $request->abcissa_title;
        $gc->ordinate_title = $request->ordinate_title;
        $gc->created_by = Auth::user()->id;
        $gc->save();
        
        foreach ($request->gc_name as $key => $c1) {
            if($c1 != ''){
                $gco = new GraphChartObject();
                $gco->graphs_charts_id = $gc->id;;
                $gco->name = $c1;
                $gco->line_type = $request->line_type[$key];
                $gco->result_class = $request->result_class[$key];
                $gco->ref_ctrl_points = $request->points[$key];
                $gco->created_by = Auth::user()->id;
                $gco->save();
            }
        }
        
        return redirect('graphchart')->with('success', 'Inserted Successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gc = GraphChart::findorfail($id);
        $gc->delete();
        
        $gco = GraphChartObject::where('graphs_charts_id',$id);
        $gco->delete();
        
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
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
        
        $graphchart = GraphChart::findorfail($id);
        $graphchartobjects = GraphChartObject::where('graphs_charts_id',$id)->get();
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        
        $object_class_list = Lists::where('name', 'SYS_LINE_TYPE')->first();
        $object_class_list = $object_class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $chart_list = Lists::where('name', 'SYS_CHART_TYPE')->first();
        $chart_list = $chart_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.graphchart.edit', compact('communitygrp','graphchart','graphchartobjects','object_class_list','chart_list'));
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
        $gc = GraphChart::findorfail($id);
        $gc->name = $request->name;
        $gc->description = $request->description;
        $gc->com_group = $request->community_group;
        $gc->object_class = $request->object_class;
        $gc->title = $request->title;
        $gc->abcissa_title = $request->abcissa_title;
        $gc->ordinate_title = $request->ordinate_title;
        $gc->last_changed_by = Auth::user()->id;
        $gc->save();
        
        
        foreach ($request->gc_name as $key => $c1) {
            if($c1 == 'deleted_data'){
                GraphChartObject::where('id',$request->gc_id[$key])->delete();
            }
            elseif($request->gc_id[$key] == 0){
                if($c1 != ''){
                    
                    $gco = new GraphChartObject();
                    $gco->graphs_charts_id = $gc->id;;
                    $gco->name = $request->gc_name[$key];
                    $gco->line_type = $request->line_type[$key];
                    $gco->result_class = $request->result_class[$key];
                    $gco->ref_ctrl_points = $request->points[$key];
                    $gco->last_changed_by = Auth::user()->id;
                    $gco->save();
                    
                }
            }
            elseif($request->gc_id[$key] > 0){
                if($c1 != ''){
                    $gco = GraphChartObject::findorfail($request->gc_id[$key]);
                    $gco->graphs_charts_id = $gc->id;;
                    $gco->name = $request->gc_name[$key];
                    $gco->line_type = $request->line_type[$key];
                    $gco->result_class = $request->result_class[$key];
                    $gco->ref_ctrl_points = $request->points[$key];
                    $gco->last_changed_by = Auth::user()->id;
                    $gco->save();
                }
            }
        }

        return redirect('graphchart')->with('success', 'Updated Successfully');
    }
}
