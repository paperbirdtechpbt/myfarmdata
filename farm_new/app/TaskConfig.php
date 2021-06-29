<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskConfig extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'name','description','type','class','com_group','name_prefix','record_event','created_by', 'created_date', 'last_changed_by', 'last_changed_date'
    ];
   
}
