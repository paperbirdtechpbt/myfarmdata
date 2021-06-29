<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\CommunityGroup;
use App\TaskConfig;
use App\Person;
use App\Team;
use App\Field;
use App\Task;
use App\Event;


use App\TaskConfigField;
use App\TaskConfigFunction;
use App\Lists;
use App\ListChoice;


use DB;

class UniqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

     //checkunique
    public function checkunique(Request $request)
    {
        $array1 = '';
        if($request->page == 'taskconfig'){
            $array1 = TaskConfig::where('name',$request->name);
        }else if($request->page == 'task'){
            $array1 = Task::where('name',$request->name);
        }else if($request->page == 'event'){
            $array1 = Event::where('name',$request->name);
        }
        
        if($request->id != null){
            $array = $array1->where('id','!=',$request->id)->get();
        }else{
            $array = $array1->get();
        }
        
        if(count($array) > 0) {
            $valid = true;
        } else {
            $valid = false;
        }
        
        return $valid;
    }
    
   
}
