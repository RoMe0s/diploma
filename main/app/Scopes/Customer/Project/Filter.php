<?php

namespace App\Scopes\Customer\Project;

use App\Models\User;
use App\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class Filter implements ScopeInterface
{
    /**
     * @param array $config
     * @param User|null $user
     * @return bool
     */
    public static function supports(array $config, ?User $user): bool
    {
        return $config['filter'] ?? false;
    }

    /**
     * @param Builder $builder
     * @param array $config
     * @param User|null $user
     */
    public function apply(Builder $builder, array $config, ?User $user): void
    {
        $builder->where('name', 'LIKE', "%{$config['filter']}%");
    }
}