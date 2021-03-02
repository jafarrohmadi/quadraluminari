<?php

namespace App\Models\Traits\Observer;

use App\Observers\BlameableObserver;

trait Blameable
{
    public static function bootBlameable()
    {
        static::observe(BlameableObserver::class);
    }
}
