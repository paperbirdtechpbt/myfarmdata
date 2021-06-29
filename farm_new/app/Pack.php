<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Pack extends Model
{
    use SoftDeletes;
     
    protected $fillable=[
        'creation_date','species','quantity','unit_id','collect_activity_id','community_group_id','description','is_active','type','class','initial_task_no'
    ];
    public function unit(){
        return $this->belongsTo('\App\Unit','unit_id');
         
     }
     public function communityGroup(){
         return $this->belongsTo('\App\CommunityGroup','community_group_id');
     }
     public function collectActivity(){
        return $this->belongsTo('\App\CollectActivity','collect_activity_id');
    }
}
