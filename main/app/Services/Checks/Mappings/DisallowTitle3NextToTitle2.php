<?php

namespace App\Services\Checks\Mappings;

use App\Constants\Check\Config;

class DisallowTitle3NextToTitle2 extends CheckMapping
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return Config::BOOLEAN;
    }
}
