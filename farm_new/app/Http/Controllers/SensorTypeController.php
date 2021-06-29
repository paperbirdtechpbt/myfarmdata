<?php

namespace App\Http\Controllers;

use App\SensorType;
use Illuminate\Http\Request;
use DB;

use Illuminate\Support\Facades\Auth;

class SensorTypeController extends Controller
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
        
        $sensor_type = SensorType::whereIn('communitygroup', $auth_user_comgrp)->get();
        return view('allpages.sensortype.index', compact('sensor_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        return view('allpages.sensortype.create', compact('communitygrp'));
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
            'name' => ['required', 'unique:sensor_types'],
            'description' => 'required',
        ]);
        
        $sensor_type = SensorType::create([
            'name' => $request->name,
            'description' => $request->description,
            'communitygroup'=>$request->communitygroup,
            'created_by' => Auth::user()->id,
            // 'created_by' => $request->user_id,
        ]);
        
        return redirect('sensortype')->with('success', 'Inserted Successfully');
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
        $sensor_type = SensorType::findorfail($id);
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        return view('allpages.sensortype.edit', compact('sensor_type','communitygrp'));
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
        ]);

        $sensor_type = SensorType::findorfail($id);
        // $sensor_type->update($request->all());
        $sensor_type->update([
            'name' => $request->name,
            'description' => $request->description,
            'communitygroup'=>$request->communitygroup,
            'updated_by' => Auth::user()->id,
            // 'updated_by' => $request->user_id,
        ]);

        return redirect('sensortype')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sensortype = SensorType::findorfail($id);
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
