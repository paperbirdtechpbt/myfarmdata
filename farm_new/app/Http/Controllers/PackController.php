<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Pack;
use App\Unit;
use App\CommunityGroup;
use App\CollectActivity;
use App\Lists;
use App\TaskObject;
use DB;

class PackController extends Controller
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
        
        $packs=Pack::with("unit","communityGroup","collectActivity")->whereIn('community_group_id', $auth_user_comgrp)->get();
       // $packs=Pack::all();
        return view('allpages.pack.index',compact('packs'))->with('no',1);
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
        
        $unit=$this->unit();
        // $communityGroup=$this->communityGroup();
        
        // \DB::connection()->enableQueryLog();
        
        // $communityGroup = CommunityGroup::with('user')->get();//->where('users.id', Auth::user()->id)
        
        // $queries = \DB::getQueryLog();
        // // return dd($queries);
        
        
        // $communityGroup = $communityGroup->where('users.id', Auth::user()->id)->get();
        
        // dd($communityGroup);
        
        // $user = User::findorfail(Auth::user()->id);
        
        // $communitygrp = $user->with('communitygrp')->get();
        
        // $communitygrp = $user->with('communitygrp')->get();
        
        // $communitygrp = CommunityGroup::with(array('user' => function($query){
        //      $query->where('users.id', Auth::user()->id);
        //     //  $query->whereIn('community_groups.id', 'users.community_group_id');
        // }))->get();
        
        $communityGroup = User::with(array('communitygrp' => function($query){
             $query->where('user_id', Auth::user()->id);
            //  $query->whereIn('community_groups.id', 'users.community_group_id');
        }))->where('users.id', Auth::user()->id)->get();
        
        // dd($communitygrp);
        // $queries = \DB::getQueryLog();
        // return dd($queries);
        $object_type = Lists::where('name', 'SYS_CONT_OBJ_TYPE')->first();
        $object_type = $object_type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $object_class = Lists::where('name', 'SYS_CONT_OBJ_CLASS')->first();
        $object_class = $object_class->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $collectActivity=$this->collectActivity();
        
        return view('allpages.pack.create',compact('unit','communityGroup','collectActivity','object_type','object_class'));
        
    }
    public function unit(){
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        return Unit::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
    }
    public function communityGroup(){
        return CommunityGroup::pluck('name','id');
    }
    public function collectActivity(){
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
       return CollectActivity::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //         'creation_date'=>'required',
        //         'species'=>'required',
        //         'quantity'=>'required',
        //         'unit_id'=>'required',
        //         'collect_activity_id'=>'required',
        //         'community_group_id'=>'required',
                
        //     ]);
        // $pack = Pack::create($request->all());
        $pack = Pack::create([
            'creation_date'=>$request->creation_date,
            'species'=>$request->species,
            'quantity'=>$request->quantity,
            'unit_id'=>$request->unit_id,
            'collect_activity_id'=>$request->collect_activity,
            'community_group_id'=>$request->com_group_id,
            'description'=>$request->description,
            'type' => $request->object_type,
            'class' => $request->object_class,
            'created_by'=>Auth::user()->id,
        ]);
        $pack_id = $pack->id;
        $collectactivityid = explode(',', $request->collect_activity_id);
        for($i = 0; $i < count($collectactivityid); $i++){
            \DB::table('pack_collect_activity')->insert([
                'pack_id' => $pack_id,
                'collect_activity_id' => $collectactivityid[$i],
            ]);
        }
        return redirect()->route('pack.index');
       
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
        $pack=Pack::find($id);
        $unit=$this->unit();
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        // $communityGroup=$this->communityGroup();
        $communityGroup = User::with(array('communitygrp' => function($query){
             $query->where('user_id', Auth::user()->id);
            //  $query->whereIn('community_groups.id', 'users.community_group_id');
        }))->where('users.id', Auth::user()->id)->get();
        
        
        $collectActivity=$this->collectActivity();
        
         $object_type = Lists::where('name', 'SYS_CONT_OBJ_TYPE')->first();
        $object_type = $object_type->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $object_class = Lists::where('name', 'SYS_CONT_OBJ_CLASS')->first();
        $object_class = $object_class->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.pack.edit',compact('pack','id','unit','communityGroup','collectActivity','object_class','object_type'));
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
    
        $pack=Pack::find($id);
        // $pack->creation_date=$request['creation_date'];
        // $pack->species=$request['species'];
        // $pack->quantity=$request['quantity'];
        // $pack->unit_id=$request['unit_id'];
        // // $pack->collect_activity_id=$request['collect_activity_id'];
        // $pack->community_group_id=$request['community_group_id'];
        $pack->update([
            'creation_date'=>$request->creation_date,
            'species'=>$request->species,
            'quantity'=>$request->quantity,
            'unit_id'=>$request->unit_id,
            'collect_activity_id'=>$request->collect_activity,
            'community_group_id'=>$request->com_group_id,
            'description'=>$request->description,
             'type' => $request->object_type,
            'class' => $request->object_class,
            'updated_by'=>Auth::user()->id,
        ]);
        
        // if($request->collect_activity_id_old != $request->collect_activity_id){
        if($request->collect_activity_id != 0){
            
            $pack->collect_activity_id=$request['collect_activity_id'];
        
            $pack_delete = \DB::table('pack_collect_activity')->where('pack_id', '=', $id)->delete();
            $collectactivityid = explode(',', $request->collect_activity_id);
            for($i = 0; $i < count($collectactivityid); $i++){
                \DB::table('pack_collect_activity')->insert([
                    'pack_id' => $id,
                    'collect_activity_id' => $collectactivityid[$i],
                ]);
            }
        }

        $pack->save();
        return redirect()->route('pack.index')->with('success','Update Data Successfull');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pack=Pack::find($id);
        $pack->update([
            'deleted_by'=>Auth::user()->id,
        ]);
        $pack->delete();
        return redirect()->route('pack.index')->with('success','Delete Data Successfull');
    }
    
    public function changeStatus(Request $request){
        
        // echo "helloo";
        
        
        $pack=Pack::find($request->pack_id);
        
        // dd($pack);
        
        // echo $pack->species; 
        
        \DB::connection()->enableQueryLog();
        
        // $pack->is_active =  $request->is_active;
        $pack->is_active =  $request->status;
        $pack->save();
        
        // $queries = \DB::getQueryLog();
        // return dd($queries);
        // // , 'queries'=>$queries['query']

        return response()->json(['success'=>'status change Successfull']);
    }
    
    // public function createPack(Request $request){
        
    //     $pack_id = '';
    //     $pack = Pack::where('initial_task_no',$request->task_id)->first();
        
    //     if($pack == null){
    //         $pack = Pack::create([
    //             'creation_date'=>$request->creation_date,
    //             'species'=>$request->species,
    //             'quantity'=>$request->quantity,
    //             'unit_id'=>$request->unit_id,
    //             'collect_activity_id'=>$request->collect_activity_id,
    //             'community_group_id'=>$request->com_group_id,
    //             'description'=>$request->description_task,
    //             'type' => $request->object_type,
    //             'class' => $request->object_class,
    //             'created_by'=>Auth::user()->id,
    //             'initial_task_no'=>$request->task_id,
    //         ]);
           
    //     }else{
    //         $pack_id = $pack->id;
    //         $pack = Pack::where('initial_task_no',$request->task_id)->update([
    //             'creation_date'=>$request->creation_date,
    //             'species'=>$request->species,
    //             'quantity'=>$request->quantity,
    //             'unit_id'=>$request->unit_id,
    //             'collect_activity_id'=>$request->collect_activity_id,
    //             'community_group_id'=>$request->com_group_id,
    //             'description'=>$request->description_task,
    //             'type' => $request->object_type,
    //             'class' => $request->object_class,
    //             'updated_by'=>Auth::user()->id,
    //             'initial_task_no'=>$request->task_id,
    //         ]);
            
    //     }
        
    //     $pack = Pack::where('id',$pack_id)->first();
    //     $collectactivityid = explode(',', $request->collect_activity_id);
        
    //     $pack_delete = \DB::table('pack_collect_activity')->where('pack_id', '=', $pack_id)->delete();
        
    //     for($i = 0; $i < count($collectactivityid); $i++){
    //         \DB::table('pack_collect_activity')->insert([
    //             'pack_id' => $pack_id,
    //             'collect_activity_id' => $collectactivityid[$i],
    //         ]);
    //     }
    //     $taskObject = TaskObject::where('task_id',$request->task_id)->where('function','CREATE_PACK')->first();
    //     if($taskObject == null){
    //         $taskObject = new TaskObject();
    //     }
    //     $taskObject->task_id = $request->task_id;
    //     $taskObject->function =  'CREATE_PACK';
    //     $taskObject->no =    $pack_id;
    //     $taskObject->name =  $pack->species;
    //     $taskObject->type =  $pack->type;
    //     $taskObject->class = $pack->class;
    //     $taskObject->last_changed_by = Auth::user()->id;
    //     $taskObject->last_changed_date = date('Y-m-d H:i:s');
    //     $taskObject->origin = 'CREATED';
    //     $taskObject->save();
        
    //     return response()->json([ 'success' => true, 'message' => 'Pack created Successfully'], 200);
    // }
    
     public function createPack(Request $request){
            $pack = Pack::create([
                'creation_date'=>$request->creation_date,
                'species'=>$request->species,
                'quantity'=>$request->quantity,
                'unit_id'=>$request->unit_id,
                'collect_activity_id'=>$request->collect_activity_id,
                'community_group_id'=>$request->com_group_id,
                'description'=>$request->description_task,
                'type' => $request->object_type,
                'class' => $request->object_class,
                'created_by'=>Auth::user()->id,
                'initial_task_no'=>$request->task_id,
            ]);
      
        $pack_id = $pack->id;
        $pack = Pack::where('id',$pack_id)->first();
        $collectactivityid = explode(',', $request->collect_activity_id);
        
        $pack_delete = \DB::table('pack_collect_activity')->where('pack_id', '=', $pack_id)->delete();
        
        for($i = 0; $i < count($collectactivityid); $i++){
            \DB::table('pack_collect_activity')->insert([
                'pack_id' => $pack_id,
                'collect_activity_id' => $collectactivityid[$i],
            ]);
        }
        $taskObject = TaskObject::where('task_id',$request->task_id)->where('function','CREATE_PACK')->where('no',$pack_id)->first();
        if($taskObject == null){
            $taskObject = new TaskObject();
        }
        $taskObject->task_id = $request->task_id;
        $taskObject->function =  'CREATE_PACK';
        $taskObject->no =    $pack_id;
        $taskObject->name =  $pack->species;
        $taskObject->type =  $pack->type;
        $taskObject->class = $pack->class;
        $taskObject->last_changed_by = Auth::user()->id;
        $taskObject->last_changed_date = date('Y-m-d H:i:s');
        $taskObject->origin = 'CREATED';
        $taskObject->save();
        
        return response()->json([ 'success' => true, 'message' => 'Pack created Successfully'], 200);
    }
}


