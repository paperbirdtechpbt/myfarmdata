<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Unit;
use App\Alert;
use App\Lists;
use App\Field;
use App\Person;
use App\AlertRange;
use App\ListChoice;
use App\CommunityGroup;
use App\CollectActivity;
use App\Collect_activity_result;
use Illuminate\Http\Request;

use DB;

use Illuminate\Support\Facades\Auth;

class AlertRangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $alerts = Alert::whereIn('communitygroup', $auth_user_comgrp)->get();
        $alert_ranges = AlertRange::with('alert')->get();
        return view('allpages.alertrange.index', compact('alerts', 'alert_ranges'));
    }

    public function create()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $activities = CollectActivity::whereIn('communitygroup', $auth_user_comgrp)->get();
        $results = Collect_activity_result::all();
        // $communitygrp = CommunityGroup::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $notiflevel = Lists::where('name', 'SYS_NOTIF_LEVEL')->first();
        $notiflevel = $notiflevel->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $alerttype = Lists::where('name', 'SYS_ALERT_TYPE')->first();
        $alerttype = $alerttype->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.alertrange.create', compact('activities', 'results', 'communitygrp', 'notiflevel', 'alerttype'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'fname' => ['required', 'unique:people'],
            // 'description' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        try {
            
            $alert = new Alert();
            
            $alert->name = $request->name;
            $alert->description = $request->description;
            $alert->communitygroup = $request->communitygroup;
            $alert->created_by = Auth::user()->id;
    
            $alert->save();
            
            $result_id = $request->result_id;
            $min_value = $request->min_value;
            $max_value = $request->max_value;
            $duration_min_value = $request->duration_min_value;
            $duration_max_value = $request->duration_max_value;
            $notif_level = $request->notif_level;
            $notif_message = $request->notif_message;
            $alert_type = $request->alert_type;
            
            foreach ($request->collect_activity_id as $key => $activity_id) {
                
                $range = new AlertRange();
                $range->collect_activity_id = $activity_id;
                $range->result_id = $result_id[$key];
                $range->min_value = $min_value[$key];
                $range->max_value = $max_value[$key];
                $range->duration_min_value = $duration_min_value[$key];
                $range->duration_max_value = $duration_max_value[$key];
                $range->notif_level = $notif_level[$key];
                $range->notif_message = $notif_message[$key];
                $range->alert_type = $alert_type[$key];
                $range->created_by = Auth::user()->id;
                
                $alert->alert_ranges()->saveMany([$range]);

            }
            return redirect('alertrange')->with('success', 'Inserted Successfully');
            
        } catch (Exception $e) {
            return redirect('alertrange')->with('error', $e);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $alert = Alert::with('alert_ranges')->whereId($id)->firstOrFail();
        $activities = CollectActivity::whereIn('communitygroup', $auth_user_comgrp)->get();
        $results = Collect_activity_result::all();
        // $communitygrp = CommunityGroup::all();
         $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $notiflevel = Lists::where('name', 'SYS_NOTIF_LEVEL')->first();
        $notiflevel = $notiflevel->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $alerttype = Lists::where('name', 'SYS_ALERT_TYPE')->first();
        $alerttype = $alerttype->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.alertrange.edit', compact('alert', 'activities', 'results', 'communitygrp', 'notiflevel', 'alerttype'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'name' => 'required',
            // 'description' => 'required',
        ]);
        
        $alert = Alert::findorfail($id);
            
        $alert->name = $request->name;
        $alert->description = $request->description;
        $alert->communitygroup = $request->communitygroup;
        $alert->created_by = Auth::user()->id;

        $alert->save();
        
        $result_id = $request->result_id;
        $min_value = $request->min_value;
        $max_value = $request->max_value;
        $duration_min_value = $request->duration_min_value;
        $duration_max_value = $request->duration_max_value;
        $notif_level = $request->notif_level;
        $notif_message = $request->notif_message;
        $alert_type = $request->alert_type;
        
        foreach ($request->collect_activity_id as $key => $activity_id) {
            
            if($request->is_range[$key] == 'deleted_data'){
                $alert->alert_ranges()->whereId($request->alert_range_id[$key])->delete();
            }
            elseif($request->alert_range_id[$key] == 0){
                // $choices = new ListChoice([
                //     'collect_activity_id'=>$activity_id,
                //     'result_id'=>$result_id[$key],
                //     'min_value'=>$min_value[$key],
                //     'max_value'=>$max_value[$key],
                //     'notif_level'=>$notif_level[$key],
                //     'notif_message'=>$notif_message[$key],
                //     'alert_type'=>$alert_type[$key],
                //     'created_by'=>Auth::user()->id,
                // ]);
                // $alert->alert_ranges()->saveMany([$choices]);
                $range = new AlertRange();
                $range->collect_activity_id = $activity_id;
                $range->result_id = $result_id[$key];
                $range->min_value = $min_value[$key];
                $range->max_value = $max_value[$key];
                $range->duration_min_value = $duration_min_value[$key];
                $range->duration_max_value = $duration_max_value[$key];
                $range->notif_level = $notif_level[$key];
                $range->notif_message = $notif_message[$key];
                $range->alert_type = $alert_type[$key];
                $range->created_by = Auth::user()->id;
                
                $alert->alert_ranges()->saveMany([$range]);
            }
            elseif($request->alert_range_id[$key] > 0){
                $alert->alert_ranges()->where('id', $request->alert_range_id[$key])->update([
                    'collect_activity_id'=>$activity_id,
                    'result_id'=>$result_id[$key],
                    'min_value'=>$min_value[$key],
                    'max_value'=>$max_value[$key],
                    'duration_min_value'=>$duration_min_value[$key],
                    'duration_max_value'=>$duration_max_value[$key],
                    'notif_level'=>$notif_level[$key],
                    'notif_message'=>$notif_message[$key],
                    'alert_type'=>$alert_type[$key],
                    'updated_by'=>Auth::user()->id,
                ]);
            }
            
            // $range = new AlertRange();
            // $range->collect_activity_id = $activity_id;
            // $range->result_id = $result_id[$key];
            // $range->min_value = $min_value[$key];
            // $range->max_value = $max_value[$key];
            // $range->notif_level = $notif_level[$key];
            // $range->notif_message = $notif_message[$key];
            // $range->alert_type = $alert_type[$key];
            // $range->created_by = Auth::user()->id;
            
            // $alert->alert_ranges()->saveMany([$range]);

        }
       
        return redirect('alertrange')->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $sensortype = Alert::findorfail($id);
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
    
    public function getResultByCollectActivity(Request $request)
    {
        $results = Collect_activity_result::where('collect_activity_id',$request->collect_activity)->get();
    
        $data['error'] = 'success';
        $data['results'] = $results;
        return json_encode($data);
    }
}
