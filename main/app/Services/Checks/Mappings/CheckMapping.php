<?php

namespace App\Services\Checks\Mappings;

use App\Constants\Check\Config;

abstract class CheckMapping implements CheckMappingInterface
{
    /**
     * @return array
     */
    public function getValidationRules(): array
    {
        return Config::RULES[$this->getType()] ?? [];
    }

    /**
     * @param string $value
     * @return bool|float|int|string
     */
    public function convertValueFromString(string $value)
    {
        switch ($this->getType()) {
            case Config::NUMERIC:
                return (int)$value;
            case Config::BOOLEAN:
                return (bool)$value;
            case Config::PERCENT:
                return (float)$value;
            default:
                return $value;
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function convertValueToString($value): string
    {
        switch ($this->getType()) {
            case Config::BOOLEAN:
                return (int)$value;
            default:
                return $value;
        }
    }
}