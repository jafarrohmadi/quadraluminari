<?php

namespace App\Repositories;

use App\Models\ActiveOpportunityHistory;

/**
 * Class ActiveOpportunityHistoryRepository
 * @package App\Repositories
 */
class ActiveOpportunityHistoryRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ActiveOpportunityHistory::class;
    }
}
