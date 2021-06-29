<?php

namespace App\Http\Controllers;

use App\Lists;
use App\ListChoice;
use App\CommunityGroup;
use Illuminate\Http\Request;

use DB;

use Illuminate\Support\Facades\Auth;

class ListController extends Controller
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
        
        $lists = Lists::with('community_groups', 'choices')->whereIn('communitygroup', $auth_user_comgrp)->get();
        return view('allpages.list.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$communitygrp = CommunityGroup::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        return view('allpages.list.create', compact('communitygrp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        
        // $this->validate($request, [
        //     'name' => ['required', 'unique:lists'],
        //     'description' => 'required',
        // ]);
        
        // echo "hello list store";
        
        $list = new Lists();
        $list->name = $request->name;
        $list->description = $request->description;
        $list->communitygroup = $request->communitygroup;
        $list->created_by = Auth::user()->id;
        
        $list->save();
        
        // $community_group = CommunityGroup::findorfail($request->community_group_id);
        
        // $community_group->list()->save($list);
        
        $choice_communitygroup = $request->choice_communitygroup;
        
        // \DB::connection()->enableQueryLog();
        
        foreach ($request->choice as $key => $c1) {
            if($c1 != ''){
                // $choices = new ListChoice(['name'=>$c1, 'choice_communitygroup'=>$choice_communitygroup[$key], 'community_group_id'=>$request->community_group_id]);
                $choices = new ListChoice();
                $choices->name = $c1;
                $choices->choice_communitygroup = $choice_communitygroup[$key];
                $choices->community_group_id = $request->community_group_id;
                $list->choices()->saveMany([$choices]);
            }
        }
        
        // $queries = \DB::getQueryLog();
        // return dd($queries);

        // $list->community_groups()->sync($request->community_group_id);
        
        return redirect('list')->with('success', 'Inserted Successfully');
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
        $lists = Lists::findorfail($id);
        $lists->with('choices', 'community_group');
        //$communitygrp = CommunityGroup::all();
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $communitygrp = CommunityGroup::whereIn('id', $auth_user_comgrp)->get();
        $communitygrp1 = CommunityGroup::withTrashed()->get();
        
        // $communitygrp = DB::table('community_group_user')
        //     ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
        //     ->select('community_groups.*')
        //     ->where('community_group_user.user_id', Auth::user()->id)
        //     ->get();
        $communitygrp1 = [];
        
        foreach($lists->choices as $choice){
            $a = CommunityGroup::whereIn('id', $auth_user_comgrp);
            $b = CommunityGroup::withTrashed()->where('id', $choice->choice_communitygroup)->union($a)->get();
             array_push($communitygrp1, $b);
        }

        return view('allpages.list.edit', compact('lists', 'communitygrp','communitygrp1'));
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
        // echo "hello list update";
        
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
        
        $list = Lists::findorfail($id);

        $list->name = $request->name;
        $list->description = $request->description;
        $list->communitygroup = $request->communitygroup;
        $list->updated_by = Auth::user()->id;
        
        $list->save();
        
        // $community_group = CommunityGroup::findorfail($request->community_group_id);
        
        // $community_group->list()->save($list);
            
        // foreach ($request->choice as $key => $c1) {
        //     if($c1 == 'deleted_data'){
        //         $list->choices()->whereId($request->choice_id[$key])->delete();
        //     }
        //     elseif($request->choice_id[$key] == 0){
        //         if($c1 != ''){
        //             $choices = new ListChoice(['name'=>$c1, 'community_group_id'=>$request->community_group_id]);
        //             $list->choices()->saveMany([$choices]);
        //         }
        //     }
        //     elseif($request->choice_id[$key] > 0){
        //         if($c1 != ''){
        //             $list->choices()->where('id', $request->choice_id[$key])->update(['name'=>$c1, 'community_group_id'=>$request->community_group_id]);
        //         }
        //     }
        // }
        
        foreach ($request->choice as $key => $c1) {
            if($c1 == 'deleted_data'){
                $list->choices()->whereId($request->choice_id[$key])->delete();
            }
            elseif($request->choice_id[$key] == 0){
                if($c1 != ''){
                
                    $choices = new ListChoice(['name'=>$c1, 'choice_communitygroup'=>$request->choice_communitygroup[$key]]);
                    $list->choices()->saveMany([$choices]);
                }
            }
            elseif($request->choice_id[$key] > 0){
                if($c1 != ''){
                    $list->choices()->where('id', $request->choice_id[$key])->update(['name'=>$c1, 'choice_communitygroup'=>$request->choice_communitygroup[$key]]);
                }
            }
        }

        return redirect('list')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sensortype = Lists::findorfail($id);
        $sensortype->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $sensortype->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
}
