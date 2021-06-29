<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class GraphChartObject extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    public $timestamps = false;
    
    protected $fillable = [
        'graphs_charts_id', 'name', 'line_type', 'result_class', 'result_class','ref_ctrl_points','created_by','created_date','last_changed_by','last_changed_date','deleted_at'
    ];
}
