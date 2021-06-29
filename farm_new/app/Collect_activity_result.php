<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collect_activity_result extends Model
{
  use SoftDeletes;
    protected $fillable=[
    	'collect_activity_id','result_name','unit_id','type_id','result_class', 'created_by','update_by','deleted_by','list_id'
    ];
    
    public $timestamps=true;
    
    public function units()
    {
        return $this->belongsToMany('App\Unit');
    }
}
