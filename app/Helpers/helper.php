<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('me')) {
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    function me()
    {
        return Auth::user();
    }
}
