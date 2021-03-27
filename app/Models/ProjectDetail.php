<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDetail extends Model
{
    protected $fillable = [
        'active_opportunity_id',
        'detail_name',
        'detail_qty',
        'detail_value',
        'detail_notes',
    ];

    /**
     * @return mixed
     */
    public function projectDetailHistoryData()
    {
        return $this->hasMany(ProjectDetailHistory::class, 'project_detail_id');
    }
}
