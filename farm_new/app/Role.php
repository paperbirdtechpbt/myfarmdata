<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'description','dashboard_view', 'created_by', 'updated_by', 'deleted_by','community_group'
    ];
    
    public function users()//inverse method
    {
        return $this->belongsToMany('App\User');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
