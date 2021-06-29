<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'sensor_type_id','sensorId','brand','user_id','name','model','sensorIp','unit_id','minimum','maximum','created_by','updated_by','deleted_by','community_group','connected_board','container_id'
    ];

    public function sensorType(){
       return $this->belongsTo('\App\SensorType','sensor_type_id');
        
    }
    
    public function owner(){
        return $this->belongsTo('\App\User','user_id');
    }
    
    public function unit(){
        return $this->belongsTo('\App\Unit','unit_id');
    }

}
