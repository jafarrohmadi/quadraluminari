<?php

namespace App\Models;

use App\Models\Traits\Observer\Blameable;
use App\Models\Traits\Relationship\ActiveOpportunityHistoryRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ActiveOpportunityHistory
 * @package App\Models
 */
class ActiveOpportunityHistory extends Model
{
    use Blameable,SoftDeletes ,ActiveOpportunityHistoryRelationship;

    protected $fillable = [
        'active_opportunity_id',
        'user_id',
        'product_name',
        'act_history',
        'act_history_other_name',
        'act_history_date',
        'act_history_remarks',
        'opportunity_status',
        'opportunity_status_remarks',
        'created_by',
        'updated_by'
    ];
}
