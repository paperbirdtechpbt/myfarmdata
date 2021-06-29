<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class DataLog extends Model
{
    // use SoftDeletes;

    // protected $dates = ['deleted_at'];
    
    public $timestamps = false;
    protected $table = 'datalogs';
    protected $fillable = [
        'table_name', 'operation', 'user_id', 'created_by'
    ];
}
