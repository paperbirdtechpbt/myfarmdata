<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = false;
    
    protected $fillable = [
        'title', 'description', 'pack_reference', 'pic_link', 'video_link', 'status','resolution','com_group','created_date','created_by','closed_by','closed_by'
    ];
    
}
