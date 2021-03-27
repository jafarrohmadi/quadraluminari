<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDetailHistory extends Model
{
    protected $fillable = [
        'project_detail_id',
        'active_opportunity_id',
        'detail_name',
        'detail_qty',
        'detail_value',
        'detail_notes',
    ];
}
