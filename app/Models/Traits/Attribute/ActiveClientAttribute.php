<?php

namespace App\Models\Traits\Attribute;

use App\Models\Province;

/**
 * Trait ActiveClientAttribute
 * @package App\Models\Traits\Attribute
 */
trait ActiveClientAttribute
{
    /**
     * @param $status
     * @return string
     */
    public function getStatus($status)
    {
        $data = [self::Status_Non_Active => 'Non Active', self::Status_Active => 'Active'];

        return $data[$status];
    }
}
