<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\CollectData;
use App\Unit;
use App\Pack;
use App\Lists;
use App\Sensor;
use App\Collect_activity_result;
use App\AlertRange;
use App\Notification;
use DB;

use Illuminate\Support\Facades\Auth;

class CollectDataController extends Controller
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
        
        // $collectDatas = CollectData::all();
        $collectDatas =  CollectData::select('collect_data.id', 'collect_data.pack_id', 'collect_data.created_at as collect_datetime', 'units.name as unit_name', 'sensors.name as sensor_name', 'users.name as user_name','packs.species','packs.creation_date')
                            ->join('units', 'units.id', '=', 'collect_data.unit_id')
                            ->join('sensors', 'sensors.id', '=', 'collect_data.sensor_id')
                            ->join('users', 'users.id', '=', 'collect_data.created_by')
                            ->join('packs', 'packs.id', '=', 'collect_data.pack_id')
                            ->whereIn('packs.community_group_id', $auth_user_comgrp)
                            ->orderBy('collect_data.id', 'DESC')
                            ->get();
        return view('allpages.collectdata.index',compact('collectDatas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pack=$this->pack();
        $unit=$this->unit();
        $sensor=$this->sensor();
        
        // \DB::connection()->enableQueryLog();
        
        // $pack = Pack::all();
        $pack = Pack::select('packs.id','packs.species','packs.creation_date')
                ->join('community_groups','community_groups.id','=','packs.community_group_id')
                ->join('community_group_user','community_group_user.community_group_id','=','community_groups.id')
                ->where('community_group_user.user_id','=',Auth::user()->id)
                ->get();
                
        // $queries = \DB::getQueryLog();
        // return dd($queries);
        
        //dd($sensor);
        return view('allpages.collectdata.create',compact('unit','pack','sensor'));
    }
    public function unit(){
        return Unit::pluck('name','id');
    }
    public function pack(){
        // return Pack::pluck('id');
        return Pack::pluck('species', 'creation_date', 'id');
    }
    public function sensor(){
        return Sensor::pluck('name','id');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count=$request->result_count;
        for($i = 0; $i<=$count; $i++){
            
            $result_id = "result_id$i";
            $unit_id = "unit_id$i";
            $value="value$i";
            $sensor_id = "sensor_id$i";
            $duration = "duration$i";
            $deleted = "deleted$i";
            
            // if($request->$result_id != '' && $request->$value != '' && $request->$unit_id != '' && $request->$sensor_id != '' && $request->$deleted != 1){
            if($request->$result_id != ''){
                // CollectData::insert([
                //     'result_id' => $request->$result_id,
                //     'pack_id'=>$request->pack_id,
                //     'value'=>$request->$value,
                //     'unit_id' => $request->$unit_id,
                //     'sensor_id' => $request->$sensor_id,
                //     'created_by' => Auth::user()->id,
                //     // 'created_at' => date('Y-m-d H:i:s'),
                // ]);
                
                $result_class = null;
                $getValue = Collect_activity_result::find($request->$result_id);
                if($getValue != null){
                    $result_class = $getValue->result_class;
                }
            
                $r = CollectData::create([
                    'result_id' => $request->$result_id,
                    'result_class' => $result_class,
                    'pack_id'=>$request->pack_id,
                    'value'=>$request->$value,
                    'unit_id' => $request->$unit_id,
                    'sensor_id' => $request->$sensor_id,
                    'duration' => $request->$duration,
                    'created_by' => Auth::user()->id,
                    // 'created_at' => date('Y-m-d H:i:s'),
                ]);
                $id = $r->id;
                $current  = $r->created_at;
                $duration = 0;
                $getCollectData = CollectData::where('pack_id',$request->pack_id)->where('result_class',$result_class)->where('id','!=',$id)->get();
                if(count($getCollectData) > 0){
                    $getCollectData = CollectData::where('pack_id',$request->pack_id)->where('result_class',$result_class)->where('duration',0)->first();
                    if($getCollectData != null){
                        $datetime1 = new \DateTime($current);
                        $datetime2 = new \DateTime($getCollectData->created_at);
                        $interval = $datetime1->diff($datetime2);
                        $duration = $interval->format('%i');
                    }
                }
                CollectData::where('id',$id)->update([
                    'duration' => $duration,
                ]);
                
                $getAlertRange = AlertRange::where('result_id',$request->$result_id)
                    ->where('duration_min_value','<=',$duration)
                    ->where('duration_max_value','>=',$duration)
                    ->get();
               
                $pack = Pack::find($request->pack_id);
                
                $ref_class = $pack->species;
                $ref_object_name = $pack->species;
                $ref_object_no = $pack->id;
                $com_group = $pack->community_group_id;
                
                $ref_zone = null;
                $ref_container = null;
                
                if($request->$sensor_id != ''){
                    $sensor = DB::table('sensors AS s')
                        ->leftjoin('container AS c', 's.container_id', '=', 'c.id')
                        ->select('s.container_id','c.zone')
                        ->where('s.id',$request->$sensor_id)
                        ->first();
                        
                    $ref_zone = $sensor->zone;
                    $ref_container = $sensor->container_id;
                }
                
                
                foreach ($getAlertRange as $value) {
                  
                    if($value['min_value'] <= $duration && $duration <= $value['min_value']){
                        // echo 'inside';
                    }else{
                        // echo 'outide';
                        
                        $noti = new Notification();
                        $noti->result_id        = $value['result_id'];
                        
                        // from alert range table
                        $noti->message          = $value['notif_message'];
                        $noti->level            = $value['notif_level'];
                        $noti->type             = $value['alert_type'];
                        
                        // from Pack table
                        $noti->ref_class        = $ref_class;
                        $noti->ref_object_name  = $ref_object_name;
                        $noti->ref_object_no    = $ref_object_no;
                        $noti->com_group        = $com_group;
                        
                        //from container table
                        $noti->ref_zone         = $ref_zone;
                        $noti->ref_container    = $ref_container;
                        
                        $noti->status           = 'NEW';
                        $noti->closed           = 'F';
                        $noti->created_by       = Auth::user()->id;
                        $noti->save();
                    }
                }
            }
        }
        return redirect()->route('collectdata.index')->with('success','Data Inserted Successfully');
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
        $collectData=CollectData::find($id);
        $result_type = Collect_activity_result::findorfail($collectData->result_id);
        $pack=$this->pack();
        $unit=$this->unit();
        $sensor=$this->sensor();
        $pack = Pack::all();
        $collectactivityresult = Collect_activity_result::where('id', $collectData->result_id)->first();
        $result_units = $collectactivityresult->units()->get();
        $lists = Lists::with('community_groups', 'choices')->where('id',$collectactivityresult->list_id)->first();
        return view('allpages.collectdata.edit',compact('collectData','id','pack','unit','sensor','result_type','result_units','lists'));
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
        $collectData=CollectData::find($id);
        // $collectData->pack_id=$request['pack_id'];
        // $collectData->result_id=$request['result_id0'];
        // $collectData->value=$request['value0'];
        // $collectData->unit_id=$request['unit_id0'];
        // $collectData->sensor_id=$request['sensor_id0'];
        $collectData->update([
            'pack_id'=>$request->pack_id,
            'result_id'=>$request->result_id0,
            'value'=>$request->value0,
            'unit_id'=>$request->unit_id0,
            'sensor_id'=>$request->sensor_id0,
            'duration'=>$request->duration0,
            'updated_by'=>Auth::user()->id,
            //'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $collectData->save();
        return redirect()->route('collectdata.index')->with('success','Data Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $collectData=CollectData :: findorfail($id);
        $collectData->update([
            'deleted_by'=>Auth::user()->id,
        ]);
        $collectData->delete($id);
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
        //return redirect()->route('collectdata.index')->with('success','deleted record successfully');
    }
    
    public function getpackresult(Request $request)
    {
        // The user select from the list Of results name available in the Collect activities linked to the PACK selected 
        // echo "hello";
        $results = \DB::table('collect_activities')
                        ->select('collect_activity_results.id', 'result_name')
                        ->join('collect_activity_results', 'collect_activities.id', '=', 'collect_activity_results.collect_activity_id')
                        ->join('pack_collect_activity', 'collect_activities.id', '=', 'pack_collect_activity.collect_activity_id')
                        ->where('pack_collect_activity.pack_id', '=', $request->pack_id)
                        ->whereNull('collect_activity_results.deleted_at')
                        ->get();

        // dd($results);
        echo $results;
    }
    
    public function getvaluetype(Request $request){
        // echo "helo";
        $results = \DB::table('collect_activity_results')
                    ->select('type_id','list_id')
                    ->whereId($request->result_id)
                    ->get();
                    
        // $user = User::where('email',$email)->first();
        // $roles = $user->roles()->get();
        
        $collectactivityresult = Collect_activity_result::where('id', $request->result_id)->first();
        $result_units = $collectactivityresult->units()->get();
        $lists = Lists::with('community_groups', 'choices')->where('id',$collectactivityresult->list_id)->first();

        // echo $results;
        
        return response()->json([ 'value_datatype' => $results, 'unit_list' => $result_units,'list' => $lists  ]);
    }
}
