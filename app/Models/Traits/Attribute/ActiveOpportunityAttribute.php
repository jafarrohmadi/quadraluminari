<?php

namespace App\Models\Traits\Attribute;

use App\Models\Province;

/**
 * Trait ActiveOpportunityAttribute
 * @package App\Models\Traits\Attribute
 */
trait ActiveOpportunityAttribute
{
    /**
     * @param $actHistory
     * @return string
     */
    public function getActHistory($actHistory)
    {
        $data = [
            self::ACT_HISTORY_CALL         => 'Call',
            self::ACT_HISTORY_EMAIL        => 'Email',
            self::ACT_HISTORY_MEETING      => 'Meeting',
            self::ACT_HISTORY_PRESENTATION => 'Presentation',
            self::ACT_HISTORY_OTHER        => 'Other',
        ];

        return $data[$actHistory];
    }

    /**
     * @param $currency
     * @return string
     */
    public function getCurrency($currency)
    {
        $data = [
            self::CURRENCY_IDR => 'Rp.',
            self::CURRENCY_USD => 'USD',
        ];

        return $data[$currency];
    }
}
