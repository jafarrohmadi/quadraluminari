<?php

namespace App\Repositories;

use App\Models\ProjectDetail;

/**
 * Class ProjectDetailRepository
 * @package App\Repositories
 */
class ProjectDetailRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProjectDetail::class;
    }
}
