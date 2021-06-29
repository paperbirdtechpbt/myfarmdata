<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use Sentinel;
use Reminder;
use Mail;
use Illuminate\Support\Facades\Hash;



class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    public function forgot_password(){
        return view('auth.passwords.forgot_password');
    }

    public function password(Request $request){
        $user= User::whereEmail($request->email)->first();
    
        if($user ==null) {
            return redirect()->back()->with(['error' =>'Email does not exist']);
        }
        $user=Sentinel::findById($user->id);
        $reminder=Reminder::exists($user) ? : Reminder::create($user);
        $reminder=Reminder::where('user_id',$user->id)->first();
        $this->sendEmail($user,$reminder->code);

        return redirect()->back()->with(['success' =>'Reset code sent to your email']);
         //use SendsPasswordResetEmails;
     }  
     public function sendEmail($user,$code){
        Mail::send(
            'email.forgot',
            ['user' =>$user, 'code' => $code],
            function($message) use ($user){
                $message->to($user->email);
                //$message->cc('chetan.jaysol@gmail.com');
                $message->from('farm@myfarmdata.io');
                $message->subject("$user->name,reset your password");
                //dd($message);
            }
        );
     }


     public function reset($email,$code){
        $user= User::whereEmail($email)->first();
    
        if($user ==null) {
            return 'Email does not exist';
        }
        $user=Sentinel::findById($user->id);
        $reminder=Reminder::exists($user);

        $reminder=Reminder::where('user_id',$user->id)->first();
        if ($reminder) {
            if ($code==$reminder->code) {
               return view('auth.passwords.reset')->with(['user'=>$user, 'code'=>$code]);
            }else{
                return redirect('/');
            }
        }else{
            echo "time expired";
        }
     }
     
    public function resetpassword(){
        return view('auth.passwords.reset_web');
    }

    public function reset_password(Request $request,$email,$code){
        $this->validate($request,[
            'password'=>'required|min:8|max:20|confirmed',
            'password_confirmation'=>'required|min:8|max:20',
        ]);

        $user= User::whereEmail($email)->first();
        if($user ==null) {
            return 'Email does not exist';
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        $user=Sentinel::findById($user->id);
        
        $reminder=Reminder::exists($user);
        $reminder=Reminder::where('user_id',$user->id)->first();
        
        if ($reminder) {
            if ($code==$reminder->code) {
               $rem=Reminder::complete($user,$code,$request->password);
             
               return redirect('/login')->with('success','password reset.');
            }else{
                return redirect('/');
            }
        }else{
            echo "time expired";
        }
     }
     
     public function resetpassword_update(Request $request,$email){
        $this->validate($request,[
            'password'=>'required|min:8|max:20|confirmed',
            'password_confirmation'=>'required|min:8|max:20',
        ]);

        $user= User::whereEmail($email)->first();
        if($user ==null) {
            return 'Email does not exist';
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back()->with(['success' =>'password reset.']);
        
           
     }

}
