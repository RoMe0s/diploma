<?php

namespace App\Services\Handlers\Customer\Setting;

use App\Constants\Check\Config;
use App\Models\Setting;
use App\Services\Checks\Mappings\CheckMappingInterface;
use Illuminate\Database\Eloquent\Model;

class UpdateOrCreate
{
    /**
     * @param string $check
     * @param Model $relation
     * @param $value
     */
    public function updateOrCreate(string $check, Model $relation, $value): void
    {
        $mapping = $this->resolveCheckMapping($check);
        $value = $mapping->convertValueToString($value);
        Setting::query()->updateOrCreate([
            'relation_type' => get_class($relation),
            'relation_id' => $relation->getKey(),
            'key' => $check
        ], compact('value'));
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