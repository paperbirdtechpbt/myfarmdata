<?php

namespace App\Http\Controllers;

use App\User;
use App\Lists;
use App\Person;
use App\ListChoice;
use App\CommunityGroup;
use Illuminate\Http\Request;

use DB;

use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
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
        //  $user = User::findorfail(Auth::user()->id);
        // $community_group_id = $user->community_group_id;
        // $array1 = explode(",",$community_group_id);
        // $person = Person::whereIn('communitygroup', $array1)->get();
        //$person = Person::get();
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $person = DB::table('people')
            ->join('community_groups', 'people.communitygroup', '=', 'community_groups.id')
            ->select('people.*','community_groups.name as com_group')
            ->whereIn('people.communitygroup', $auth_user_comgrp)
            ->whereNull('people.deleted_at')
            ->get();
        
        // $lists = Lists::with('community_groups', 'choices')->get();
        return view('allpages.person.index', compact('person'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::findorfail(Auth::user()->id);
        $community_group_id = $user->community_group_id;
        $users = User::all();
        // $communitygrp = CommunityGroup::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $class_list = Lists::where('name', 'SYS_PERSON_CLASS')->first();//->whereIn('choice_communitygroup', $auth_user_comgrp)
        $class_list = $class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $type_list = Lists::where('name', 'SYS_PERSON_TYPE')->first();
        $type_list = $type_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $km_center = Lists::where('name', 'SYS_KM_CENTER')->first();
        $km_center = $km_center->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $country_list = Lists::where('name', 'SYS_COUNTRIES')->first();
        $country_list = $country_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
       
        return view('allpages.person.create', compact('users', 'class_list', 'type_list', 'communitygrp', 'km_center','country_list','community_group_id'));
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
            'fname' => ['required', 'unique:people'],
            'description' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        try {
            
            $person = new Person();
            
            $person->fname = $request->fname;
            $person->lname = $request->lname;
            $person->email = $request->email;
            $person->contact = $request->contact;
            $person->dob = $request->dob;
            $person->birth_place = $request->birth_place;
            $person->address = $request->address;
            $person->citizenship = $request->citizenship;
            $person->certification = $request->certification;
            $person->last_certification_date = $request->last_certification_date;
            $person->kakaomundo_center = $request->kakaomundo_center;
            $person->user_id = $request->user_id;
            $person->person_class = $request->person_class;
            $person->person_type = $request->person_type;
            $person->description = $request->description;
            $person->communitygroup = $request->communitygroup;
            $person->created_by = Auth::user()->id;
            // if($request->is_in_coop == 'on')
            //     $person->is_in_coop = true;
            // else
            //     $person->is_in_coop = false;
                
            // if($request->is_kakaomundo == 'on')
            //     $person->is_kakaomundo = true;
            // else
            //     $person->is_kakaomundo = false;
            
            if(isset($request->is_in_coop)){
               $person->is_in_coop = 1; 
            }else{
                $person->is_in_coop = 0; 
            }
            
            if(isset($request->is_kakaomundo)){
                $person->is_kakaomundo = 1; 
            }else{
                $person->is_kakaomundo = 0; 
            }
                
            if($request->image != null){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('file_upload/person'), $imageName);
                $person->photo = $imageName;
            }
    
            $person->save();
            
            return redirect('person')->with('success', 'Inserted Successfully');
            
        } catch (Exception $e) {
            return redirect('person')->with('error', $e);
        }
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
        $user = User::findorfail(Auth::user()->id);
        $community_group_id = $user->community_group_id;
        $users = User::all();
        
        $person = Person::findorfail($id);
        // $communitygrp = CommunityGroup::all();
        $communitygrp = DB::table('community_group_user')
            ->join('community_groups', 'community_group_user.community_group_id', '=', 'community_groups.id')
            ->select('community_groups.*')
            
            ->where('community_group_user.user_id', Auth::user()->id)
            ->get();
        
        $auth_user = Auth::user()->whereId(Auth::user()->id)->with('communitygrp')->first();
        $auth_user_comgrp = $auth_user->communitygrp()->pluck('community_groups.id');
        
        $class_list = Lists::where('name', 'SYS_PERSON_CLASS')->first();//->whereIn('choice_communitygroup', $auth_user_comgrp)
        $class_list = $class_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $type_list = Lists::where('name', 'SYS_PERSON_TYPE')->first();
        $type_list = $type_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        $km_center = Lists::where('name', 'SYS_KM_CENTER')->first();
        $km_center = $km_center->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        
        $country_list = Lists::where('name', 'SYS_COUNTRIES')->first();
        $country_list = $country_list->choices()->whereIn('choice_communitygroup', $auth_user_comgrp)->get();
        
        return view('allpages.person.edit', compact('person', 'users', 'class_list', 'type_list', 'communitygrp', 'km_center','country_list','community_group_id'));
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
            // 'name' => 'required',
            // 'description' => 'required',
        ]);
        
        $person = Person::findorfail($id);

        // $person->fname = $request->fname;
        $person->lname = $request->lname;
        $person->email = $request->email;
        $person->contact = $request->contact;
        $person->dob = $request->dob;
        $person->birth_place = $request->birth_place;
        $person->address = $request->address;
        $person->citizenship = $request->citizenship;
        $person->certification = $request->certification;
        $person->last_certification_date = $request->last_certification_date;
        $person->kakaomundo_center = $request->kakaomundo_center;
        $person->user_id = $request->user_id;
        $person->person_class = $request->person_class;
        $person->person_type = $request->person_type;
        $person->description = $request->description;
        $person->communitygroup = $request->communitygroup;
        $person->updated_by = Auth::user()->id;
        // if($request->is_in_coop == 'on')
        //     $person->is_in_coop = true;
        // else
        //     $person->is_in_coop = false;
            
        // if($request->is_kakaomundo == 'on')
        //     $person->is_kakaomundo = true;
        // else
        //     $person->is_kakaomundo = false;
        
        if(isset($request->is_in_coop)){
           $person->is_in_coop = 1; 
        }else{
            $person->is_in_coop = 0; 
        }
        
        if(isset($request->is_kakaomundo)){
            $person->is_kakaomundo = 1; 
        }else{
            $person->is_kakaomundo = 0; 
        }
            
        if($request->image != null){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('file_upload/person'), $imageName);
            $person->photo = $imageName;
        }
                
        $person->save();
       
        return redirect('person')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sensortype = Person::findorfail($id);
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
