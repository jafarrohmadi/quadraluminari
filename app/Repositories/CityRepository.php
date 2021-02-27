<?php

namespace App\Repositories;

use App\Models\City;

/**
 * Class CityRepository
 * @package App\Repositories
 */
class CityRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return City::class;
    }
}
