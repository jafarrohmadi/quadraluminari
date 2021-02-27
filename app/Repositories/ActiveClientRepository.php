<?php

namespace App\Repositories;

use App\Models\ActiveClient;

/**
 * Class ActiveClientRepository
 * @package App\Repositories
 */
class ActiveClientRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ActiveClient::class;
    }
}
