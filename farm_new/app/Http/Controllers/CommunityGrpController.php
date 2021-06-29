<?php

namespace App\Http\Controllers;

use App\CommunityGroup;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class CommunityGrpController extends Controller
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
        
        $communitygroup = DB::table('community_groups As cg1')
            ->leftjoin('community_groups As cg2', 'cg1.community_group', '=', 'cg2.id')
            ->select('cg1.*','cg2.name AS parent_group')
            ->whereIn('cg1.id', $auth_user_comgrp)
            ->get();
            
        
        // $communitygroup = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        return view('allpages.communitygrp.index', compact('communitygroup'));
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
        
        $communitygroup = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        return view('allpages.communitygrp.create', compact('communitygroup'));
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
            'name' => ['required', 'unique:community_groups'],
            'description' => 'required',
            'community_group' => 'required',
        ]);
        
        $communitygrp = CommunityGroup::create([
            'name' => $request->name,
            'description' => $request->description,
            'community_group' => $request->community_group,
            'created_by' => Auth::user()->id,
            // 'created_by' => $request->user_id,
        ]);
        $last_id = $communitygrp->id;
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $c = $auth_user->community_group_id.",".$last_id;
        //$auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $user = User::findorfail(Auth::user()->id);
        $user->update([
            'community_group_id' => $c,
        ]);
        //$communitygroupid = explode(',',$c);
        //dd($communitygroupid);
        $user->communitygrp()->attach($last_id);
        
        return redirect('communitygrp')->with('success', 'Inserted Successfully');
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
        
        $communitygroup = CommunityGroup::findorfail($id);
        $communitygroup1 = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        return view('allpages.communitygrp.edit', compact('communitygroup','communitygroup1'));
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
        ]);

        $communitygrp = CommunityGroup::findorfail($id);
        $communitygrp->update([
            'name' => $request->name,
            'description' => $request->description,
            'community_group' => $request->community_group,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect('communitygrp')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $communitygrp = CommunityGroup::findorfail($id);
        $communitygrp->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $communitygrp->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
}
