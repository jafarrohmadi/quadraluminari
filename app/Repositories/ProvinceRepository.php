<?php

namespace App\Repositories;

use App\Models\Province;

/**
 * Class ProvinceRepository
 * @package App\Repositories
 */
class ProvinceRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Province::class;
    }
}
