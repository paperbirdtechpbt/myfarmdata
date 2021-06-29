<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'sensor_type_id','sensorId','brand','user_id','name','model','sensorIp','unit_id','minimum','maximum','created_by','updated_by','deleted_by'
    ];

    public function person(){
        return $this->belongsToMany('\App\Person');
    }
    
    public function responsible_person(){
        return $this->belongsTo('\App\Person', 'responsible');
    }
    
    public function field()
    {
        return $this->hasOne('App\Field');
    }

}
