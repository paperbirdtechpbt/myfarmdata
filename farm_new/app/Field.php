<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'community_group_id', 'description', 'created_by', 'updated_by', 'deleted_by'
    ];
    
    // public function community_group()
    // {
    //     return $this->belongsTo(CommunityGroup::class);
    // }
    
    public function field_contact()
    {
        return $this->belongsTo('App\Person', 'field_contact');
    }
    
    public function last_visited_by()
    {
        return $this->belongsTo('App\Person', 'last_visited_by');
    }
    
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
    
    public function lists()
    {
        return $this->belongsTo('App\Lists');
    }
    
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

}
