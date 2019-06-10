<?php

namespace App\Services\Price;

use App\Constants\Tax;

class Author
{
    /**
     * @param float $price
     * @return float
     */
    public static function convert(float $price): float
    {
        return round($price * Tax::AUTHOR, 2);
    }
}
