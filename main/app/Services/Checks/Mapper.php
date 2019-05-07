<?php

namespace App\Services\Checks;

use App\Constants\Check\Available;
use App\Constants\Check\Config;
use App\Services\Checks\Mappings\CheckMappingInterface;

class Mapper
{
    /**
     * @param array $settings
     * @return array
     */
    public function map(array $settings): array
    {
        $result = [];
        foreach (Available::SEQUENCE as $baseClassName) {
            $check = $this->resolveCheckMapping($baseClassName);
            if (key_exists($baseClassName, $settings)) {
                $value = $check->convertValueFromString($settings[$baseClassName]);
            } else {
                $value = null;
            }
            $result[] = [
                'type' => $check->getType(),
                'key' => $baseClassName,
                'value' => $value
            ];
        }
        return $result;
    }

    /**
     * @param string $baseClassName
     * @return CheckMappingInterface
     */
    private function resolveCheckMapping(string $baseClassName): CheckMappingInterface
    {
        return resolve(Config::MAPPINGS_PATH . $baseClassName);
    }
}
