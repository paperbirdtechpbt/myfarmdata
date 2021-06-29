<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskConfigFunction extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'task_config_id','name','description','privilege','created_by', 'created_date', 'last_changed_by', 'last_changed_date'
    ];
    
}
