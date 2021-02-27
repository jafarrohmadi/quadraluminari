<?php

namespace App\Models\Traits\Relationship;

use App\Models\Province;

/**
 * Trait CityRelationship
 * @package App\Models\Traits\Relationship
 */
trait CityRelationship
{
    /**
     * @return mixed
     */
    public function provinceData()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
}

