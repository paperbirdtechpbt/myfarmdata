<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class CollectData extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable=[
        'pack_id','result_id','result_class','value','unit_id','sensor_id', 'duration', 'created_by', 'updated_by', 'deleted_by'
    ];
    public function pack(){
        return $this->belongsTo('\App\Pack','pack_id');
    }
    public function unit(){
        return $this->belongsTo('\App\Unit','unit_id');
    }
    public function sensor(){
        return $this->belongsTo('\App\Sensor','sensor_id');
    }
}
