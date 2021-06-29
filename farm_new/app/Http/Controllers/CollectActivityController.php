<?php

namespace App\Http\Controllers;

use App\CollectActivity;
use App\Unit;
use App\Lists;
use App\Collect_activity_result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CommunityGroup;
// use DB;

use Illuminate\Http\Request;

class CollectActivityController extends Controller
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
        
        $data = array();
        $collectactivity = CollectActivity::whereIn('communitygroup', $auth_user_comgrp)->get();
        foreach($collectactivity as $collectactivity_row){
            $communitygroup = CommunityGroup::where('id',$collectactivity_row->communitygroup)->first();
            $results = $collectactivityresult = DB::table('collect_activity_results')
                                                    ->select('collect_activity_results.id', 'result_name', 'unit_id', 'type_id','units.name as unit_name')
                                                    ->join('units', 'units.id', '=', 'collect_activity_results.unit_id')
                                                    ->where('collect_activity_results.collect_activity_id', '=', $collectactivity_row->id)
                                                    ->WhereNull('collect_activity_results.deleted_at')
                                                    ->get();
                                                  
                                                    

            $data[] = array(
                'id' => $collectactivity_row->id,
                'name' => $collectactivity_row->name,
                'resultarray' => $results,
                'communitygroup' => $communitygroup->name,
                
            );
        }
        return view('allpages.collectactivity.index', compact('collectactivity', 'data'));
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
        
        //$unit = Unit::all();
        $unit=$this->getUnit();
        $lists = Lists::whereIn('communitygroup', $auth_user_comgrp)->get();
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
            
        return view('allpages.collectactivity.create', compact('unit','lists','communitygrp'));
    }
    public function getUnit(){
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        return Unit::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
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
            // 'name' => 'required', 'unique:collect_activities'
            'name' => ['required', 'unique:collect_activities'],
        ]);
        // $request->unit_id;
        //dd($request->all());
        $collectactivity=$request->all();
        //dd($collectactivity);
        $collect_activity_id = CollectActivity::create([
            'name'=>$request->name,
            'communitygroup'=>$request->communitygroup,
            'created_by' => Auth::user()->id
        ]);
       
       if (count($request->result_name)>0) {
           foreach ($request->result_name as $key => $value) {
            // print_r($collectactivity);
            // exit;
            $list_id = null;
            if($request->type_id[$key] == 'list'){
               $list_id = $request->list_id[$key]; 
            }
            if($request->is_delete[$key] == 0){
                $data2=array(
                    'collect_activity_id'=>($collect_activity_id)->id,
                    'result_name'=>$request->result_name[$key],
                    'result_class'=>$request->result_class[$key],
                    'unit_id'=>implode(',', $request->unit_id[$key]),
                    'type_id'=>$request->type_id[$key],
                    'list_id'=>$list_id,
                    'created_by' => Auth::user()->id
                );
          
            // DB::table('collect_activity_results')->create($data2);
            $collectactivityresult = Collect_activity_result::create($data2);
            $collectactivityresult->units()->attach($request->unit_id[$key]);
            }
           }
        }
        return redirect('collectactivity')->with('success', 'Inserted Successfully');
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
        // echo "helloo edit function121212";
        // $unit = Unit::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
            
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        //$unit = Unit::all();
        $unit=$this->getUnit();
        $lists = Lists::whereIn('communitygroup', $auth_user_comgrp)->get();
        
        $collectactivity = CollectActivity::findorfail($id);
        $collectactivityresult = DB::table('collect_activity_results')->select('id', 'result_name', 'unit_id', 'type_id','list_id','result_class')->where('collect_activity_id', '=', $id)->WhereNull('deleted_at')->get();
        // return view('allpages.collectactivity.edit', compact('unit'), compact('collectactivity'), compact('collectactivityresult'));
        return view('allpages.collectactivity.edit', compact('unit', 'collectactivity', 'collectactivityresult','lists','communitygrp'));
        
        //$unit = Unit::all();
        // $unit=$this->getUnit();
        // return view('allpages.collectactivity.edit', compact('unit'));
    }
    public function edit123($id)
    {
        //$unit = Unit::all();
        $unit=$this->getUnit();
        $collectactivity = CollectActivity::findorfail($id);
        //$collectactivityresult=Collect_activity_result::find($id);
       // dd($collectactivityresult);
        // $collectactivityresult = DB::table('collect_activity_results')->select('id', 'result_name', 'unit_id', 'type_id')->where('collect_activity_id', '=', $id)->WhereNull('deleted_at')->get();
        $collectactivityresult = Collect_activity_result::where('collect_activity_id', '=', $id);
        // return view('allpages.collectactivity.edit', compact('unit'), compact('collectactivity'), compact('collectactivityresult'));
        return view('allpages.collectactivity.edit', compact('unit', 'collectactivity', 'collectactivityresult'));
        // echo count($collectactivityresult);
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
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            
        ]);

        $collectactivity = CollectActivity::findorfail($id);
        $collectactivity->update([
            'name' => $request->name,
            'communitygroup'=>$request->communitygroup,
            'updated_by' => Auth::user()->id,
        ]);
        
        $count = $request->result_count;
        
        if (count($request->result_name)>0) {
           foreach ($request->result_name as $key => $value) {
               $list_id = null;
                // if($request->type_id[$key] == 'list'){
                    $list_id = $request->list_id[$key]; 
                // }
                if($request->result_id[$key] != 0 && $request->is_delete[$key] == 0){
                    $data2=array(
                        'result_name'=>$request->result_name[$key],
                        'result_class'=>$request->result_class[$key],
                        'unit_id'=>implode(',', $request->unit_id[$key]),
                        'type_id'=>$request->type_id[$key],
                        'list_id'=>$list_id,
                        'updated_by' => Auth::user()->id
                    );
                    $collectactivityresult_new = Collect_activity_result::findorfail($request->result_id[$key]);
                    $collectactivityresult = Collect_activity_result::where('id', $request->result_id[$key])->update($data2);
                    $collectactivityresult_new->units()->sync($request->unit_id[$key]);
                }
                elseif($request->is_delete[$key] == 1){
                    Collect_activity_result::where('id', $request->result_id[$key])
                    ->update([
                        'deleted_by' => Auth::user()->id,
                        'deleted_at' => date('Y-m-d H:i:s'),
                    ]);
                }
                elseif($request->result_id[$key] == 0 && $request->is_delete[$key] == 0){
                    $data2=array(
                        'collect_activity_id'=>($collectactivity)->id,
                        'result_name'=>$request->result_name[$key],
                        'result_class'=>$request->result_class[$key],
                        'unit_id'=>implode(',', $request->unit_id[$key]),
                        'type_id'=>$request->type_id[$key],
                        'list_id'=>$list_id,
                        'created_by' => Auth::user()->id
                    );
                    $collectactivityresult = Collect_activity_result::create($data2);
                    $collectactivityresult->units()->attach($request->unit_id[$key]);
                }
           }
        }
        
        // echo "helloo update function";

        return redirect('collectactivity')->with('success', 'Updated Successfully');
    }
    public function update123(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);
       $collectactivity=$request->all();
       //dd($collectactivity);
       // print_r($collectactivity);
       //  exit;
        $collectactivity = CollectActivity::findorfail($id);
        $collect_activity = Collect_activity_result::findorfail($id);
        // dd($collectactivity);
        $collectactivity->update([
            'name'=>$request->name,
            'updated_by' => Auth::user()->id,
        ]);
         // print_r($request->$result_id);
         //     exit;
      //dd($collect_activity_id);
       if (count($request->result_name)>0)

        {
           foreach ($request->result_name as $key => $value) {
          //
           // dd($request->result_id);
             if($request->result_id != 0 && $request->isdelete== 0){
               // echo "case:1";
               //  exit;
                 //dd($request->result_id);
                //\DB::table('collect_activity_results')
             $collect_activity->where('id',$request->result_id)
                ->update([
                    // 'result_name' => $request->$result_name,
                    // 'unit_id' => $request->$unit_id,
                    // 'type_id' => $request->$type_id,
                    // 'updated_by' => Auth::user()->id,
                    // 'updated_at' => date('Y-m-d H:i:s'),
                    'result_name'=>$request->result_name[$key],
                    'unit_id'=>implode(',', $request->unit_id[$key]),
                    'type_id'=>$request->type_id[$key],
                // 'result_id'=>$request->$result_id[$key],
                    'updated_by' => Auth::user()->id
                ]);
                $collect_activity->save();
                // $data2=array(
                // 'collect_activity_id'=>($collectactivity)->id,
                
            
                // dd($data2);
            // $collect_activity_id->update($data2);
            
            
           } //Collect_activity_result::update($data2);
           
        }
        // dd($data2);
    }
        // $collectactivity->update([
        //     'name' => $request->name,
        //     'updated_by' => Auth::user()->id,
        // ]);
        
        // $count = $request->result_count;
        
        // for($i = 0; $i<=$count; $i++){
            
        //     // $privilege_title = "privilege$i";
        //     // $privilege_isdelete = "privilege_is_delete$i";
        //     // $privilege_id = "privilege_id$i";
        //     // $isdelete = $request->$privilege_isdelete;
            
        //     $result_name = "result_name$i";
        //     $unit_id = "unit_id$i";
        //     $type_id = "type_id$i";
        //     $privilege_isdelete = "is_delete$i";
        //     $isdelete = $request->$privilege_isdelete;
        //     $result_id = "result_id$i";
            
        //     if($request->$result_id != 0 && $isdelete == 0){
        //         // echo "case:1";
        //         \DB::table('collect_activity_results')
        //         ->where('id', $request->$result_id)
        //         ->update([
        //             'result_name' => $request->$result_name,
        //             'unit_id' => $request->$unit_id,
        //             'type_id' => $request->$type_id,
        //             'updated_by' => Auth::user()->id,
        //             'updated_at' => date('Y-m-d H:i:s'),
        //         ]);
        //     }
        //     elseif($isdelete == 1){
        //         // echo "case:2";
        //         \DB::table('collect_activity_results')
        //         ->where('id', $request->$result_id)
        //         ->update([
        //             'deleted_by' => Auth::user()->id,
        //             'deleted_at' => date('Y-m-d H:i:s'),
        //         ]);
        //     }
        //     elseif($request->$result_id == 0 && $isdelete == 0){
        //         // echo "case:3";
        //         if($request->$result_name != ''){
        //             \DB::table('collect_activity_results')->insert([
        //                 'collect_activity_id' => $id,
        //                 'result_name' => $request->$result_name,
        //                 'unit_id' => $request->$unit_id,
        //                 'type_id' => $request->$type_id,
        //                 'created_by' => Auth::user()->id,
        //                 'created_at' => date('Y-m-d H:i:s'),
        //             ]);
        //         }
        //     }
        //     else{
        //         // echo "case:else";
        //     }
        // }

        return redirect('collectactivity')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collectactivity = CollectActivity::findorfail($id);
        $collectactivity->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $collectactivity->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
}
