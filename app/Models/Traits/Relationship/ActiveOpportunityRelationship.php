<?php

namespace App\Models\Traits\Relationship;

use App\Models\ActiveClient;
use App\Models\ActiveOpportunityHistory;
use App\Models\ActiveOpportunityReminder;
use App\Models\User;

trait ActiveOpportunityRelationship
{
    /**
     * @return mixed
     */
    public function activeOpportunityHistoryData()
    {
        return $this->hasMany(ActiveOpportunityHistory::class, 'active_opportunity_id', 'id');
    }

    /**
     * @return mixed
     */
    public function activeOpportunityHistoryReminderData()
    {
        return $this->hasMany(ActiveOpportunityReminder::class, 'active_opportunity_id', 'id');
    }

    /**
     * @return mixed
     */
    public function userData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return mixed
     */
    public function activeClientData()
    {
        return $this->belongsTo(ActiveClient::class , 'active_client_id');
    }
}
