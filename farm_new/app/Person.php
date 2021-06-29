<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
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
    
    public function teams(){
        return $this->belongsToMany('\App\Team');
    }
    
    public function responsible_team(){
        return $this->hasOne('\App\Team', 'responsible');
    }
    
    public function field_contact()
    {
        return $this->hasOne('App\Field', 'field_contact');
    }
    
    public function last_visited_by()
    {
        return $this->hasOne('App\Field', 'last_visited_by');
    }
}
