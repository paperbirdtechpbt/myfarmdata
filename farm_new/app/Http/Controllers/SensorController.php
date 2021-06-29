<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sensor;
use App\SensorType;
use App\User;
use App\Unit;

use DB;

class SensorController extends Controller
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
        
        $sensors=Sensor::with("sensorType","owner")->whereIn('community_group', $auth_user_comgrp)->get();
        // dd($sensors);
        $sensors=Sensor::select('sensors.*', 'sensor_types.name as sensor_type_name', 'users.name as user_name')
                ->join('sensor_types', 'sensors.sensor_type_id', '=', 'sensor_types.id')
                ->join('users', 'sensors.user_id', '=', 'users.id')
                ->whereIn('sensors.community_group', $auth_user_comgrp)
                ->get();
                
            // dd($sensors);
            
        return view('allpages.sensor.index',compact('sensors'))->with('no', 1);
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
        
        $sensorType= $this->getSensorType();
        //dd($sensorType);
        $user=$this->getUser();
        //dd($user);
        // $unit = Unit::all();
        $unit = Unit::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
        
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
         $containers = DB::table('container AS z')
            ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
            ->select('z.*','cg.name AS com_name')
            ->whereNull('z.deleted_at')
            ->whereIn('com_group', $auth_user_comgrp)
            ->get();
            
        return view('allpages.sensor.create',compact('sensorType','user','unit','communitygrp','containers'));
    }
    public function getSensorType(){
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        return SensorType::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
    }
    public function getUser(){
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        return User::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
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
        //     'sensor_type_id'=>'required',
        //     'sensorId'=>'required',
        //     'brand'=>'required',
        //     'owner'=>'required',
        //     // 'name'=>'required',
        //     'name'=>['required', 'unique:sensors'],
        //     'model'=>'required',
        //     'sensorIp'=>'required'
        // ]);
        
        // echo "hello121213";
        
        // dd($request);
        
        // echo $request->minimum;
        // echo $request->maximum;
        
        // DB::connection()->enableQueryLog();
        
      $sensor= Sensor::create([
          'sensor_type_id'=>$request->sensor_type_id,
          'sensorId'=>$request->sensorId,
          'brand'=>$request->brand,
          'user_id'=>$request->user_id,
          'unit_id'=>$request->unit_id,
          'minimum'=>$request->minimum,
          'maximum'=>$request->maximum,
          'name'=>$request->name,
          'model'=>$request->model,
          'sensorIp'=>$request->sensorIp,
          'community_group'=>$request->community_group,
          'connected_board'=>$request->connected_board,
          'container_id'=>$request->container_id,
          'created_by' => Auth::user()->id,
      ]);//insert data 
      
    //   $queries = \DB::getQueryLog();
    //     return dd($queries);
       
       
        return redirect()->route('sensor.index');
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
        
        $sensor=Sensor::find($id);
        $sensorType= $this->getSensorType();
        $user=$this->getUser();
        
         $unit = Unit::whereIn('communitygroup', $auth_user_comgrp)->pluck('name','id');
         
         $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        $containers = DB::table('container AS z')
            ->leftjoin('community_groups AS cg', 'z.com_group', '=', 'cg.id')
            ->select('z.*','cg.name AS com_name')
            ->whereNull('z.deleted_at')
            ->whereIn('com_group', $auth_user_comgrp)
            ->get();
        
        return view('allpages.sensor.edit',compact('sensor','id','sensorType','user','unit','communitygrp','containers'));
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
        $sensor=Sensor::find($id);
        $sensor->update([
            'sensor_type_id'=>$request->sensor_type_id,
            'sensorId'=>$request->sensorId,
            'brand'=>$request->brand,
            'user_id'=>$request->user_id,
            'unit_id'=>$request->unit_id,
            'minimum'=>$request->minimum,
            'maximum'=>$request->maximum,
            'name'=>$request->name,
            'model'=>$request->model,
            'sensorIp'=>$request->sensorIp,
            'community_group'=>$request->community_group,
            'connected_board'=>$request->connected_board,
            'container_id'=>$request->container_id,
            'updated_by'=>Auth::user()->id,
        ]);
        return redirect()->route('sensor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sensor=Sensor::find($id);
        $sensor->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $sensor->delete($id);
        return redirect()->route('sensor.index');
    }
}