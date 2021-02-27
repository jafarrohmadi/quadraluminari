<?php

namespace App\Models\Traits\Relationship;

use App\Models\City;

/**
 * Trait ProvinceRelationship
 * @package App\Models\Traits\Relationship
 */
trait ProvinceRelationship
{
    /**
     * @return mixed
     */
    public function cityData()
    {
        return $this->hasMany(City::class);
    }
}

