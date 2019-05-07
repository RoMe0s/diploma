<?php

namespace App\Services\Checks\Mappings;

use App\Constants\Check\Config;

class MinimumNumberOfLettersInTheDescription extends CheckMapping
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return Config::NUMERIC;
    }
}
