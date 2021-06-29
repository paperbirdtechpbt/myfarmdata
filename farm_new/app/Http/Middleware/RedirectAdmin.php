<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Illuminate\Support\Facades\Cookie;
use App\Role;

use Illuminate\Support\Str;

class RedirectAdmin
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
        
        // if (!$userRoles->contains('admin')) {
        //     return redirect('/home');
        // }
        
        $cookiename = 'userlogin_roleid';
        $role_id = Cookie::get($cookiename);
        
        // echo "hello4545";
        
        $userRoles = Auth::user()->roles->pluck('id');
        
        if ($userRoles->contains($role_id)) {
        //     // return redirect('/home');
            $role = Role::findorfail($role_id);
            
            // echo Str::contains($role->name, 'admin');
            
            if(Str::contains(strtolower($role->name), 'admin'))
            {
                // echo "true";
            }
            else{
                // echo "false";
                return redirect('/home')->with('info','You can not access this url : '.$request->url());
            }
            
        //     $search = 'admin';
            
        //     if($role->name != 'admin' && Str::contains($role->name, 'admin') == false){
        //     // if(str_contains($role->name, 'ADMIN') == false){
        //     // if (preg_match('/\badmin\b/', $role->name)) {
        //     // if(preg_match("/{$search}/i", $role->name)) {
        //     // if(Str::contains($role->name, 'admin')){
        //         return redirect('/home')->with('info','You can not access this url : '.$request->url());
        //     }
        //     // elseif(Str::contains($role->name, 'admin') == false){
        //     //     return redirect('/home')->with('info','You can not access this url : '.$request->url());
        //     // }
        }
        else{
            return redirect('/home')->with('info','You can not access this url : '.$request->url());
        }

        return $next($request);
    }
}
