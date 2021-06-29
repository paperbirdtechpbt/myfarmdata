<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ListChoice extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    protected $fillable = [
        'name', 'community_group_id', 'description', 'created_by', 'updated_by', 'deleted_by','choice_communitygroup'
    ];
    
    public function lists()//inverse method
    {
        return $this->belongsTo('App\Lists');
    }
}
