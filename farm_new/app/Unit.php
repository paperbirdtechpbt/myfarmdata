<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'description', 'created_by', 'updated_by', 'deleted_by','communitygroup'
    ];
    
    public function field()
    {
        return $this->hasOne('App\Field');
    }
}
