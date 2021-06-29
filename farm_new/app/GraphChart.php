<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class GraphChart extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = false;
    
    protected $fillable = [
        'name', 'description', 'object_class', 'com_group', 'title', 'abcissa_title','ordinate_title','created_by','created_date','last_changed_by','last_changed_date','deleted_at'
    ];
    
    // public function alert_ranges()
    // {
    //     return $this->hasMany('App\AlertRange');
    // }

}
