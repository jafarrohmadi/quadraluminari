<?php

namespace App\Models;

use App\Models\Traits\Attribute\ActiveOpportunityAttribute;
use App\Models\Traits\Observer\Blameable;
use App\Models\Traits\Relationship\ActiveOpportunityRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ActiveOpportunity
 * @package App\Models
 */
class ActiveOpportunity extends Model
{
    use Blameable, SoftDeletes, ActiveOpportunityRelationship, ActiveOpportunityAttribute;

    protected $fillable = [
        'active_client_id',
        'user_id',
        'project',
        'product_name',
        'value_currency',
        'value',
        'act_history',
        'act_history_other_name',
        'act_history_date',
        'act_history_remarks',
        'opportunity_status',
        'opportunity_status_remarks',
        'reminder',
        'status',
        'created_by',
        'updated_by',
    ];

    public const CURRENCY_IDR = 1;
    public const CURRENCY_USD = 2;

    public const ACT_HISTORY_CALL = 1;
    public const ACT_HISTORY_EMAIL = 2;
    public const ACT_HISTORY_MEETING = 3;
    public const ACT_HISTORY_PRESENTATION = 4;
    public const ACT_HISTORY_OTHER = 5;

    public const STATUS_SUCCESS = 1;
    public const STATUS_FAILED = 2;
    public const STATUS_ON_PROGRESS = 3;
}
