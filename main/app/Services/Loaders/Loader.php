<?php

namespace App\Services\Loaders;

use App\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class Loader
{
    /**
     * @param array $config
     * @return array
     */
    public function get(array $config): array
    {
        return $this->query($config)->get()->toArray();
    }

    /**
     * @param array $config
     * @return Builder
     */
    public function query(array $config): Builder
    {
        $query = $this->prepareQuery($config);
        /** @var $scope ScopeInterface */
        foreach ($this->scopes() as $scope) {
            if ($scope::supports($config)) {
                resolve($scope)->apply($query, $config);
            }
        }
        return $query;
    }

    /**
     * @return array
     */
    protected function scopes(): array
    {
        return [];
    }

    /**
     * @param array $config
     * @return Builder
     */
    abstract protected function prepareQuery(array $config): Builder;
}