<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function password()
    {
        return view('allpages.setting.resetpassword');
    }
    
    public function updatepassword(Request $request)
    {
        $this->validate($request,[
			'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
		
		$user = User::findorfail(Auth::user()->id);
		
		if(password_verify($request->old_password, $user->password))
		{
			$user->password = Hash::make($request->password);
			$user->save();
            return redirect('/')->with('success','Password Updated Successfully');
		}
		else{
		    return redirect('/')->with('error','Old Password Does not Match');
		}
    }
    
    public function rolefromemailid(Request $request)
    {
        $data = array();
        
        $email = $request->email;
        
        $user = User::where('email',$email)->first();
        
        if($user != '')
        {
            $roles = $user->roles()->get();
            return response()->json([ 'status' => 'data_found', 'roles' => $roles ]);
        }
        else{
            return response()->json([ 'status' => 'data_not_found', 'roles' => $data ]);
        }
        
        // return $roles;
        // return response()->json([
        //     'name' => 'Abigail',
        //     'state' => 'CA',
        // ]);
    }
}