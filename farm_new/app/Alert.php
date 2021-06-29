<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'description', 'created_by', 'updated_by', 'deleted_by'
    ];
    
    public function alert_ranges()
    {
        return $this->hasMany('App\AlertRange');
    }

}
