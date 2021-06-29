<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Lists extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'community_group_id', 'description', 'created_by', 'updated_by', 'deleted_by'
    ];
    
    public function community_group()
    {
        return $this->belongsTo(CommunityGroup::class);
    }
    
    public function choices()//inverse method
    {
        return $this->hasMany('App\ListChoice');
    }
    
    public function community_groups()
    {
        return $this->morphToMany(CommunityGroup::class, 'community_groupable');
    }
    
    public function field()
    {
        return $this->hasOne('App\Field');
    }
}
