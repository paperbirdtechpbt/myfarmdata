<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Lists;
use App\ListChoice;
use App\CollectActivity;
use App\CommunityGroup;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $user = User::whereIn('communitygroup', $auth_user_comgrp)->get();
        //$user = User::get();
        //dd($user);
        return view('allpages.user.index', compact('user'));
    }

    public function create()
    {
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $collectactivity = CollectActivity::whereIn('communitygroup', $auth_user_comgrp)->get();
        $role = Role::whereIn('community_group', $auth_user_comgrp)->get();
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        
        $language = Lists::where('name', 'SYS_LANGUAGE')->first();
        $language = $language->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $timezones = Lists::where('name', 'SYS_UTC_TIMEZONE')->first();
        $timezones = $timezones->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
       
        return view('allpages.user.create', compact('collectactivity', 'role', 'communitygrp', 'language', 'timezones'));
    }
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password' => ['required', 'string', 'min:8'],
            'family_name' => 'required',
            'collect_activity_id' => 'required',
            'role_id' => 'required',
            'external_id' => 'required',
            'is_active' => 'required',
            'community_group_id' => 'required',
        ]);
        // \DB::connection()->enableQueryLog();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'family_name' => $request->family_name,
            'collect_activity_id' => $request->collect_activity_id,
            'role_id' => $request->role_id,
            'external_id' => $request->external_id,
            'is_active' => $request->is_active,
            'community_group_id' => $request->community_group_id,
            'communitygroup' => $request->communitygroup,
            'language' => $request->language,
            'timezone' => $request->timezone,
            // 'created_by' => Auth::user()->id,
            'created_by' => $request->user_id,
        ]);
        // dd(\DB::getQueryLog());
        $user_id = $user->id;
        $user = User::find($user_id);
        $roles = explode(',', $request->role_id);
        for($i = 0; $i < count($roles); $i++){
            $user->roles()->attach($roles[$i]);
        }
        $collectactivityid = explode(',', $request->collect_activity_id);
        for($i = 0; $i < count($collectactivityid); $i++){
            $user->collectactivities()->attach($collectactivityid[$i]);
        }
        $communitygrpid = explode(',', $request->community_group_id);
        //dd($communitygrpid);
        for($i = 0; $i < count($communitygrpid); $i++){
            $user->communitygrp()->attach($communitygrpid[$i]);
            
        }
        return redirect('user')->with('success','Inserted Successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::with('roles')->findorfail($id);
        $user_role = '';
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $collectactivity = CollectActivity::whereIn('communitygroup', $auth_user_comgrp)->get();
        $role = Role::whereIn('community_group', $auth_user_comgrp)->get();
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        
        $language = Lists::where('name', 'SYS_LANGUAGE')->first();
        $language = $language->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $timezones = Lists::where('name', 'SYS_UTC_TIMEZONE')->first();
        $timezones = $timezones->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.user.edit', compact('user', 'user_role', 'collectactivity', 'role', 'communitygrp', 'language', 'timezones'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'family_name' => 'required',
            'collect_activity_id' => 'required',
            // 'role_id' => 'required',
            'external_id' => 'required',
            'is_active' => 'required',
            'community_group_id' => 'required',
        ]);
        $user = User::findorfail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'family_name' => $request->family_name,
            // 'collect_activity_id' => $request->collect_activity_id,
            'external_id' => $request->external_id,
            'is_active' => $request->is_active,
            'community_group_id' => $request->community_group_id,
            'communitygroup' => $request->communitygroup,
            'language' => $request->language,
            'timezone' => $request->timezone,
            'updated_by' => Auth::user()->id,
        ]);
        // $user = User::findorfail(1);
        // $user->collectactivities()->sync([1]);
        // $user->collectactivities()->sync(array(1, 3));
        if($request->collect_activity_id != 0){
            $collectactivityid = explode(',', $request->collect_activity_id);
            $user->collectactivities()->sync($collectactivityid);
        }
        if($request->role_id != 0){
            $roles = explode(',', $request->role_id);
            $user->roles()->sync($roles);
        }
        if($request->community_group_id != 0){
            $communitygroupid = explode(',', $request->community_group_id);
            $user->communitygrp()->sync($communitygroupid);
        }
        return redirect('user')->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $user = User::findorfail($id);
        $user->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $user->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
    
    public function getCommunityGroupByUser(Request $request)
    {
        $user = User::findorfail(Auth::user()->id);
        $users = User::where('id',$request->user_id)->first();
        
        $array1 = explode(",",$user->community_group_id);
        $array2 = explode(",",$users->community_group_id);
        $diff_result = array_intersect($array1, $array2);
                                                    
        $CommunityGroup = CommunityGroup::whereIn('id',$diff_result)->get();
       
        $data['error'] = 'success';
        $data['CommunityGroup'] = $CommunityGroup;
        return json_encode($data);
    }
}
