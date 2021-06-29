<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable=[
        'name','description','type','exp_start_date','exp_end_date','exp_duration', 'actual_start_date', 'actual_end_date', 'actual_duration', 'closed','closed_date', 'closed_by', 'com_group', 'status', 'created_date', 'last_changed_by', 'last_changed_date','task_id'
    ];
   
}
