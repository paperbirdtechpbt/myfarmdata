<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskField extends Model
{
    // use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'task_id','field_id','value'
    ];
   
}
