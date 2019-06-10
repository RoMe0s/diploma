<?php

namespace App\Services\Price;

use App\Constants\Tax;

class Customer
{
    /**
     * @param float $price
     * @return float
     */
    public static function convert(float $price): float
    {
        return round($price * Tax::CUSTOMER, 2);
    }
}
