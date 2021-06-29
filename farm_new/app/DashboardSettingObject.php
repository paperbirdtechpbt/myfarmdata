<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class DashboardSettingObject extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = false;
    
    protected $fillable = [
        'dashboard_setting_id', 'object_class', 'object_key','created_by','created_date','last_changed_by','last_changed_date','deleted_at'
    ];
}
