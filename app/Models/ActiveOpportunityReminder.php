<?php

namespace App\Models;

use App\Models\Traits\Observer\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ActiveOpportunityReminder
 * @package App\Models
 */
class ActiveOpportunityReminder extends Model
{
    use Blameable, SoftDeletes;

    protected $fillable = [
        'active_opportunity_id',
        'user_id',
        'act_history_reminder',
        'act_history_other_name_reminder',
        'act_history_order_reminder',
        'act_history_date_reminder',
        'act_history_notes_reminder',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['act_history_date_reminder', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function activeOpportunityData()
    {
        return $this->belongsTo(ActiveOpportunity::class, 'active_opportunity_id');
    }
}
