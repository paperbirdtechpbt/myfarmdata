<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'name','description','task_config_id','com_group','created_by', 'created_date', 'last_changed_by', 'last_changed_date'
    ];
   
}
