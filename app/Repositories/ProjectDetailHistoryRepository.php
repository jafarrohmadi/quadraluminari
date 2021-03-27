<?php

namespace App\Repositories;

use App\Models\ProjectDetailHistory;

/**
 * Class ProjectDetailHistoryRepository
 * @package App\Repositories
 */
class ProjectDetailHistoryRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProjectDetailHistory::class;
    }
}
