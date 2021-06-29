<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskConfigField extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'task_config_id','field_name','field_description','editable','field_type','list','created_by', 'created_date', 'last_changed_by', 'last_changed_date'
    ];
    
}
