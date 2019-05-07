<?php

namespace App\Constants\Check;

class Config
{
    const NUMERIC = 'numeric';

    const BOOLEAN = 'boolean';

    const PERCENT = 'percent';

    const RULES = [
        self::BOOLEAN => ['required', 'boolean'],
        self::NUMERIC => ['required', 'int', 'min:0'],
        self::PERCENT => ['required', 'numeric', 'min:0', 'max:100']
    ];

    const MAPPINGS_PATH = "App\\Services\\Checks\\Mappings\\";
}