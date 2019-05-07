<?php

namespace App\Services\Checks\Mappings;

interface CheckMappingInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return array
     */
    public function getValidationRules(): array;

    /**
     * @param $value
     * @return string
     */
    public function convertValueToString($value): string;

    /**
     * @param string $value
     * @return mixed
     */
    public function convertValueFromString(string $value);
}