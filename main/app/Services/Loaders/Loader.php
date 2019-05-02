<?php

namespace App\Services\Loaders;

use App\Models\User;
use App\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class Loader
{
    /**
     * @var
     */
    protected $user;

    /**
     * @param User $user
     */
    final public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @param array $config
     * @return array
     */
    final public function get(array $config): array
    {
        return $this->query($config)->get()->toArray();
    }

    /**
     * @param array $config
     * @return Builder
     */
    final public function query(array $config): Builder
    {
        $query = $this->prepareQuery($config);
        /** @var $scope ScopeInterface */
        foreach ($this->scopes() as $scope) {
            if ($scope::supports($config, $this->user)) {
                resolve($scope)->apply($query, $config, $this->user);
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