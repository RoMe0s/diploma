<?php

namespace App\Services\Price;

use App\Constants\Tax;

class Author extends Price
{
    /**
     * @param float $price
     * @return float
     */
    public static function convert(float $price): float
    {
        return parent::convert($price * Tax::AUTHOR);
    }
}
