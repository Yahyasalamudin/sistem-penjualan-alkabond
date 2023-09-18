<?php

use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('hashid_encode')) {
    function hashid_encode($value)
    {
        return Hashids::encode($value);
    }
}
