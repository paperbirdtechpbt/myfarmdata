<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskMediaFile extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'task_id','name','latitude','longitude','created_by', 'created_date'
    ];
   
}
