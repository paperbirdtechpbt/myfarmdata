<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use SoftDeletes;
    protected $table = 'container';
    public $timestamps = false;
    protected $fillable=[
        'name','description','com_group','type','class','status','max_capacity','capacity_units','zone','notification_level','parent_container','deleted','created_date','created_by','created_date_utc','last_changed_date','last_changed_by','last_changed_utc'
    ];
    // public function unit(){
    //     return $this->belongsTo('\App\Unit','unit_id');
         
    //  }
    //  public function communityGroup(){
    //      return $this->belongsTo('\App\CommunityGroup','community_group_id');
    //  }
    //  public function collectActivity(){
    //     return $this->belongsTo('\App\CollectActivity','collect_activity_id');
    // }
}
