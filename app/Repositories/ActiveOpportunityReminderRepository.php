<?php

namespace App\Repositories;

use App\Models\ActiveOpportunityReminder;

/**
 * Class ActiveOpportunityReminderRepository
 * @package App\Repositories
 */
class ActiveOpportunityReminderRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ActiveOpportunityReminder::class;
    }
}
