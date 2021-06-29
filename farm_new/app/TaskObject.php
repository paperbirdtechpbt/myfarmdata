<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskObject extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'task_id','name','type','no','class','last_changed_by','last_changed_date'
    ];
   
}
