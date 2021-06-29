<?php

namespace App\Http\Controllers;

use App\CommunityGroup;
use App\Incident;
use App\Pack;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Person;
use App\Team;
use App\Event;
use App\Task;
use App\Alert;
use App\AlertRange;

use App\Field;

use App\TaskField;

use App\TaskConfig;
use App\TaskConfigField;
use App\TaskConfigFunction;
use App\Lists;
use App\ListChoice;


class IncidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $incidents = Incident::whereIn('com_group', $auth_user_comgrp)->get();
       
        return view('allpages.incident.index', compact('incidents'));
    }

    public function create()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        $packs = Pack::select('packs.id','packs.species','packs.creation_date')
                ->join('community_groups','community_groups.id','=','packs.community_group_id')
                ->join('community_group_user','community_group_user.community_group_id','=','community_groups.id')
                ->where('community_group_user.user_id','=',Auth::user()->id)
                ->get();
        
        return view('allpages.incident.create', compact('communitygrp','packs'));
    }

    public function store(Request $request)
    {
        try {
            $pic_name = null;
            if($request->file('pic_link') != null ){
                $file      = $request->file('pic_link');
                $pic_name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/file_upload/incident/images/', $pic_name);
            }
            
            $video_name = null;
            if($request->file('video_link') != null ){
                $file      = $request->file('video_link');
                $video_name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/file_upload/incident/videos/', $video_name);
            }
            
            $incident = new Incident();
            
            $incident->title = $request->title;
            $incident->description = $request->description;
            $incident->pack_reference = $request->pack_reference;
            $incident->com_group = $request->com_group;
            $incident->pic_link = $pic_name;
            $incident->video_link = $video_name;
            $incident->status = 'NEW';
            $incident->created_by = Auth::user()->id;
            $incident->save();
            
            return redirect('incident')->with('success', 'Inserted Successfully');
            
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
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        $packs = Pack::select('packs.id','packs.species','packs.creation_date')
                ->join('community_groups','community_groups.id','=','packs.community_group_id')
                ->join('community_group_user','community_group_user.community_group_id','=','community_groups.id')
                ->where('community_group_user.user_id','=',Auth::user()->id)
                ->get();
        
        $incident = Incident::find($id);
        
        return view('allpages.incident.edit', compact('communitygrp', 'packs', 'incident'));
    }

    public function update(Request $request, $id)
    {
        $incident = Incident::findorfail($id);
        $incident->status = $request->status;
        $incident->resolution = $request->resolution;
        $incident->save();
        return redirect('incident')->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $incident = Incident::findorfail($id);
        $incident->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
    public function changeStatus(Request $request)
    {
        $incident = Incident::find($request->id);
        $incident->status =  $request->status;
        $incident->closed_by = Auth::user()->id;
        $incident->closed_date = date('Y-m-d H:i:s');
        $incident->save();

        return response()->json(['success'=>'Status Change Successfull']);
    }
    
    
}