<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface ScopeInterface
{
    /**
     * @param array $config
     * @param User|null $user
     * @return bool
     */
    static function supports(array $config, ?User $user): bool;

    /**
     * @param Builder $builder
     * @param array $config
     * @param User|null $user
     */
    function apply(Builder $builder, array $config, ?User $user): void;
}