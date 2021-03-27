<?php

namespace App\Models\Traits\Relationship;

use App\Models\City;
use App\Models\ContactPerson;
use App\Models\Province;

/**
 * Trait ActiveClientRelationship
 * @package App\Models\Traits\Relationship
 */
trait ActiveClientRelationship
{
    /**
     * @return mixed
     */
    public function contactPersonProvinceData()
    {
        return $this->belongsTo(Province::class, 'contact_person_province_id');
    }

    /**
     * @return mixed
     */
    public function contactPersonCityData()
    {
        return $this->belongsTo(City::class, 'contact_person_city_id');
    }

    /**
     * @return mixed
     */
    public function addressProvinceData()
    {
        return $this->belongsTo(Province::class, 'address_province_id');
    }

    /**
     * @return mixed
     */
    public function addressCityData()
    {
        return $this->belongsTo(City::class, 'address_city_id');
    }

    /**
     * @return mixed
     */
    public function contactPersonData()
    {
        return $this->hasMany(ContactPerson::class, 'active_client_id', 'id');
    }
}

