<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;
    protected $table = 'zone';
    public $timestamps = false;
    protected $fillable=[
        'name','description','com_group','type','parent_zone','class','plan','deleted','created_date','created_by','created_date_utc','last_changed_by','last_changed_utc'
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
