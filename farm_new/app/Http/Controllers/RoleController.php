<?php

namespace App\Http\Controllers;

use App\Role;
use Cookie;
use Illuminate\Support\Facades\Auth;
use App\DashboardSetting;
use App\DashboardSettingObject;

use DB;

use Illuminate\Http\Request;

class RoleController extends Controller
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
        
        // $role = Role::all();
        // return view('allpages.role.index', compact('role'));
        
        $role = array();
        
        $role1 = Role::whereIn('community_group', $auth_user_comgrp)->get();
        
        foreach($role1 as $role_data){

            $role_privilege = DB::table('role_privileges')->select('id as privilege_id', 'privilege')->where('role_id', '=', $role_data->id)->WhereNull('deleted_at')->get();

            $role[] = array(
                'id' => $role_data->id,
                'name' => $role_data->name,
                'description' => $role_data->description,
                'role_privileges_count' => count($role_privilege),
                'role_privileges' => $role_privilege,
            );
        }
        
        return view('allpages.role.index', compact('role'));
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
        
        $cookiename = 'userlogin_roleid';
        $role_id = Cookie::get($cookiename);
        
        $privileges = DB::table('privileges')->get();
        
        // $communitygrp = DB::table('role_user AS ur')
        //     ->join('roles AS r', 'ur.role_id', '=', 'r.id')
        //     ->select('r.community_group')
        //     ->groupBy('r.community_group')
        //     ->where('ur.user_id', Auth::user()->id)
        //     ->where('r.id', $role_id)
        //     ->whereNotNull('r.community_group')
        //     ->get();
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $dashboardsettings = DashboardSetting::whereIn('com_group', $auth_user_comgrp)->get();
        
        return view('allpages.role.create', compact('privileges','communitygrp','dashboardsettings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:roles'],
            'description' => 'required',
            'community_group' => 'required',
            'dashboard_view' => 'required',
        ]);
        
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'community_group' => $request->community_group,
            'dashboard_view' => $request->dashboard_view1,
            'created_by' => Auth::user()->id,
        ]);
        
        $role_id = $role->id;
        
        \DB::table('role_privileges')->insert([
            'role_id' => $role_id,
            'privilege' => $request->privilege0,
            'created_by' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $count = $request->privilege_count;
        
        for($i = 1; $i<=$count; $i++){
            
            $privilege_title = "privilege$i";
            $privilege_isdelete = "privilege_is_delete$i";
            $isdelete = $request->$privilege_isdelete;
            
            if($isdelete == 0){
                \DB::table('role_privileges')->insert([
                    'role_id' => $role_id,
                    'privilege' => $request->$privilege_title,
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        
        return redirect('role')->with('success', 'Inserted Successfully');
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
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $role = Role::findorfail($id);
        $role_privilege = DB::table('role_privileges')->select('id', 'privilege')->where('role_id', '=', $id)->WhereNull('deleted_at')->get();
        $privileges = DB::table('privileges')->get();
        
        $cookiename = 'userlogin_roleid';
        $role_id = Cookie::get($cookiename);
        
        // $communitygrp = DB::table('role_user AS ur')
        //     ->join('roles AS r', 'ur.role_id', '=', 'r.id')
        //     ->select('r.community_group')
        //     ->groupBy('r.community_group')
        //     ->where('ur.user_id', Auth::user()->id)
        //     ->where('r.id', $role_id)
        //     ->whereNotNull('r.community_group')
        //     ->get();
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        $dashboardsettings = DashboardSetting::whereIn('com_group', $auth_user_comgrp)->get();
        // return view('allpages.role.edit', compact('role'), compact('role_privilege'), compact('privileges'));
        return view('allpages.role.edit', compact('role','role_privilege','privileges','communitygrp','dashboardsettings'));
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'community_group' => 'required',
            'dashboard_view' => 'required',
        ]);

        $role = Role::findorfail($id);
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'community_group' => $request->community_group,
            'dashboard_view' => $request->dashboard_view1,
            'updated_by' => Auth::user()->id,
            
            // 'updated_by' => $request->user_id,
        ]);
        
        $count = $request->privilege_count;
        
        for($i = 0; $i<=$count; $i++){
            
            $privilege_title = "privilege$i";
            $privilege_isdelete = "privilege_is_delete$i";
            $privilege_id = "privilege_id$i";
            $isdelete = $request->$privilege_isdelete;
            
            // echo "<br>";
            // echo $privilege_title;
            // echo "<br>";
            
            if($request->$privilege_id != 0 && $isdelete == 0){
                // echo "case:1";
                \DB::table('role_privileges')
                ->where('id', $request->$privilege_id)
                ->update([
                    'privilege' => $request->$privilege_title,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            elseif($isdelete == 1){
                // echo "case:2";
                \DB::table('role_privileges')
                ->where('id', $request->$privilege_id)
                ->update([
                    'deleted_by' => Auth::user()->id,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            }
            elseif($request->$privilege_id == 0 && $isdelete == 0){
                // echo "case:3";
                if($request->$privilege_title != ''){
                    \DB::table('role_privileges')->insert([
                        'role_id' => $id,
                        'privilege' => $request->$privilege_title,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            else{
                // echo "case:else";
            }
        }

        return redirect('role')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findorfail($id);
        $role->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $role->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
}
