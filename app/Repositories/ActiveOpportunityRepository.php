<?php

namespace App\Repositories;

use App\Models\ActiveOpportunity;

/**
 * Class ActiveOpportunityRepository
 * @package App\Repositories
 */
class ActiveOpportunityRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ActiveOpportunity::class;
    }
}
