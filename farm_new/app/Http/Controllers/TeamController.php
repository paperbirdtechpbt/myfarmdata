<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\Lists;
use App\Field;
use App\Person;
use App\ListChoice;
use App\CommunityGroup;
use Illuminate\Http\Request;

use DB;

use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        // \DB::connection()->enableQueryLog();
        // $teams = Team::all();
        $teams = Team::with('person')->whereIn('communitygroup', $auth_user_comgrp)->get();
        // $queries = \DB::getQueryLog();
        // dd($queries);
        return view('allpages.team.index', compact('teams'));
    }

    public function create()
    {
       $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        // \DB::connection()->enableQueryLog();
        
        $teamclass = Lists::where('name', 'SYS_TEAM_CLASS')->first();//->whereIn('choice_communitygroup', $auth_user_comgrp)
        $teamclass = $teamclass->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $person = Person::whereIn('communitygroup', $auth_user_comgrp)->get();
        //$communitygrp = CommunityGroup::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        // dd(\DB::getQueryLog());
        
        $teamtype = Lists::where('name', 'SYS_TEAM_TYPE')->first();
        $teamtype = $teamtype->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        
        
        // dd($auth_user->communitygrp()->pluck('community_groups.id'));
        
        return view('allpages.team.create', compact('person', 'teamclass', 'teamtype', 'communitygrp'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'fname' => ['required', 'unique:people'],
            // 'description' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        try {
            
            $team = new Team();
            
            $team->name = $request->name;
            $team->description = $request->description;
            $team->communitygroup = $request->communitygroup;
            $team->email = $request->email;
            $team->contact = $request->contact;
            $team->address = $request->address;
            // $team->responsible = $request->responsible;
            $team->team_class = $request->team_class;
            $team->team_type = $request->team_type;
            $team->created_by = Auth::user()->id;
            
            if($request->image != null){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('file_upload/team'), $imageName);
                $team->logo = $imageName;
            }
    
            $team->save();
            
            $responsible_peron = Person::findorfail($request->responsible);
            $responsible_peron->responsible_team()->save($team);
            
            // $team->responsible_person()->save($responsible_peron);
            // $user->company()->save($company);
            
            $team->person()->sync($request->person);
            
            // foreach ($request->choice as $key => $c1) {
            //     if($c1 != ''){
            //         $choices = new ListChoice(['name'=>$c1, 'community_group_id'=>$request->community_group_id]);
            //         $list->choices()->saveMany([$choices]);
            //     }
            // }
            
            return redirect('team')->with('success', 'Inserted Successfully');
            
        } catch (Exception $e) {
            return redirect('team')->with('error', $e);
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
        
        $team = Team::findorfail($id);
        $person = Person::whereIn('communitygroup', $auth_user_comgrp)->get();
        // $communitygrp = CommunityGroup::all();
         $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $teamclass = Lists::where('name', 'SYS_TEAM_CLASS')->first();//->whereIn('choice_communitygroup', $auth_user_comgrp)
        $teamclass = $teamclass->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $teamtype = Lists::where('name', 'SYS_TEAM_TYPE')->first();
        $teamtype = $teamtype->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.team.edit', compact('team', 'person', 'teamclass', 'teamtype', 'communitygrp'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'name' => 'required',
            // 'description' => 'required',
        ]);
        
        $team = Team::findorfail($id);
            
        $team->name = $request->name;
        $team->description = $request->description;
        $team->communitygroup = $request->communitygroup;
        $team->email = $request->email;
        $team->contact = $request->contact;
        $team->address = $request->address;
        $team->responsible = $request->responsible;
        $team->team_class = $request->team_class;
        $team->team_type = $request->team_type;
        $team->updated_by = Auth::user()->id;
        
        if($request->image != null){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('file_upload/team'), $imageName);
            $team->logo = $imageName;
        }
                
        $team->save();
        
        $responsible_peron = Person::findorfail($request->responsible);
        $responsible_peron->responsible_team()->save($team);
        
        $team->person()->sync($request->person);
       
        return redirect('team')->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $sensortype = Team::findorfail($id);
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

}
