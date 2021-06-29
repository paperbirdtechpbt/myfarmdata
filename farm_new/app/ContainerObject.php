<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerObject extends Model
{
    use SoftDeletes;
    protected $table = 'container_object';
    public $timestamps = false;
    
    protected $fillable=[
        'object_name','container_no','object_no','type','class','session_id','added_date','added_by','added_utc'
    ];
    public function container(){
        return $this->belongsTo('\App\Container','container_no');
    }
   
}
