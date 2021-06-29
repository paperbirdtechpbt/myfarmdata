<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class CollectActivity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'created_by', 'updated_by', 'deleted_by','communitygroup'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    // public function unit()
    // {
    //     return $this->hasOne('App\Unit');
    // }
}
