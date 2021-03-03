<?php

namespace App\Models\Traits\Relationship;

use App\Models\ActiveOpportunity;
use App\Models\User;

trait ActiveOpportunityHistoryRelationship
{
    /**
     * @return mixed
     */
    public function activeOpportunityData()
    {
        return $this->belongsTo(ActiveOpportunity::class, 'active_opportunity_id');
    }


    /**
     * @return mixed
     */
    public function createdByData()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return mixed
     */
    public function userData()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
