<?php

namespace App\Http\Resources\Author\Task\ToCheck;

use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Checks\Mappings\CheckMappingInterface;
use App\Constants\Check\Config;

class SettingResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Setting $setting */
        $setting = $this->resource;

        $checkMapping = $this->resolveCheckMapping($setting->key);
        $value = $checkMapping->convertValueFromString($setting->value);

        return [
            'key' => $setting->key,
            'value' => $value
        ];
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
