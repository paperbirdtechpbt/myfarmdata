<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityGroup extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'description','community_group', 'created_by', 'updated_by', 'deleted_by'
    ];
    
    public function user()
    {
        return $this->hasMany('App\User');
    }
    
    public function list()
    {
        return $this->hasOne(Lists::class);
    }
    
    public function lists()
    {
        return $this->morphedByMany(Lists::class, 'community_groupable');
    }
}
