<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

interface ScopeInterface
{
    /**
     * @param array $config
     * @return bool
     */
    static function supports(array $config): bool;

    /**
     * @param Builder $builder
     * @param array $config
     */
    function apply(Builder $builder, array $config): void;
}