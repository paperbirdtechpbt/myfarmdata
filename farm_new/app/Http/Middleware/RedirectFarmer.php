<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Illuminate\Support\Facades\Cookie;
use App\Role;

class RedirectFarmer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $user_id = Auth::user()->id;
        
        // $userRoles = Auth::user()->roles->pluck('name');
        
        // if (!$userRoles->contains('FARMER')) {
        //     return redirect('/home');
        // }
        
        $cookiename = 'userlogin_roleid';
        $role_id = Cookie::get($cookiename);
        
        $userRoles = Auth::user()->roles->pluck('id');
        
        if ($userRoles->contains($role_id)) {
            // return redirect('/home');
            $role = Role::findorfail($role_id);
            
            if($role->name != 'FARMER'){
                return redirect('/home')->with('info','You can not access this url : '.$request->url());
            }
        }
        else{
            // return redirect('/home');
            return redirect('/home')->with('info','You can not access this url : '.$request->url());
        }
        
        return $next($request);
    }
}
