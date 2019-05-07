<?php

namespace App\Services\Checks\Mappings;

use App\Constants\Check\Config;

class AllowedOverhead extends CheckMapping
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return Config::PERCENT;
    }
}
