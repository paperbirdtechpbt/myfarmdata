<?php

namespace App\Http\Controllers;
use App\Unit;
use App\DataLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class UnitController extends Controller
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
        
        $unit = Unit::whereIn('communitygroup', $auth_user_comgrp)->get();
        return view('allpages.unit.index', compact('unit'));
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
            
        return view('allpages.unit.create', compact('communitygrp'));
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
            'name' => ['required', 'unique:units'],
            'description' => 'required',
        ]);
        
        $unit = Unit::create([
            'name' => $request->name,
            'description' => $request->description,
            'communitygroup' => $request->communitygroup,
            'created_by' => Auth::user()->id,
        ]);
        
        $unit = DataLog::create([
            'table_name' => 'units',
            'operation' => 'Insert',
            'user_id' => Auth::user()->id,
        ]);
        
        return redirect('unit')->with('success', 'Inserted Successfully');
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
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        $unit = Unit::findorfail($id);
        return view('allpages.unit.edit', compact('unit','communitygrp'));
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

        $unit = Unit::findorfail($id);
        // $unit->update($request->all());
        $unit->update([
            'name' => $request->name,
            'description' => $request->description,
            'communitygroup' => $request->communitygroup,
            'updated_by' => Auth::user()->id,
            // 'updated_by' => $request->user_id,
        ]);

        return redirect('unit')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::findorfail($id);
        $unit->update([
            'deleted_by' => Auth::user()->id,
        ]);
        $unit->delete();
        $data = array();
        $data['error'] = 'success';
        $data['message'] = 'Deleted Successfully';
        return json_encode($data);
    }
}
