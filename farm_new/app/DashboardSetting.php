<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class DashboardSetting extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = false;
    
    protected $fillable = [
        'name','title', 'description', 'max_number', 'com_number','created_by','created_date','last_changed_by','last_changed_date','deleted_at'
    ];
    
    // public function alert_ranges()
    // {
    //     return $this->hasMany('App\AlertRange');
    // }

}
