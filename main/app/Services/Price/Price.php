<?php

namespace App\Services\Price;

abstract class Price
{
    /**
     * @param float $price
     * @return float
     */
    public static function convert(float $price): float
    {
        return round($price, 2);
    }
}
