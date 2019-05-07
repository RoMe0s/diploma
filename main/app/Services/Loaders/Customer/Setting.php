<?php

namespace App\Services\Loaders\Customer;

use App\Services\Checks\Mapper;
use App\Services\Loaders\Loader;
use App\Models\Setting as SettingModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Setting extends Loader
{
    /**
     * @var Mapper
     */
    private $mapper;

    /**
     * @var Model|null
     */
    private $related;

    /**
     * Setting constructor.
     * @param Mapper $mapper
     */
    function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param Model $related
     */
    public function setRelated(Model $related): void
    {
        $this->related = $related;
    }

    /**
     * @param array $config
     * @return Builder
     */
    public function prepareQuery(array $config): Builder
    {
        return SettingModel::query()->where([
            'relation_type' => get_class($this->related),
            'relation_id' => $this->related->getKey()
        ]);
    }

    /**
     * @param array $config
     * @return array
     */
    public function get(array $config): array
    {
        $settings = $this->query($config)->pluck('value', 'key')->toArray();
        return $this->mapper->map($settings);
    }
}