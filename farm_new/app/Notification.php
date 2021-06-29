<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'result_id','message','level','type','ref_class','ref_object_name','ref_object_no','ref_zone','ref_container','com_group','status','closed','closed_by','closed_date','created_by','created_date'
    ];
   
}