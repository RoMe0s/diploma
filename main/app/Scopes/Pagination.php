<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class Pagination implements ScopeInterface
{
    /**
     * @param array $config
     * @param User|null $user
     * @return bool
     */
    public static function supports(array $config, ?User $user): bool
    {
        return key_exists('perPage', $config) && $config['perPage'];
    }

    /**
     * @param Builder $builder
     * @param array $config
     * @param User|null $user
     */
    public function apply(Builder $builder, array $config, ?User $user): void
    {
        $perPage = $config['perPage'];
        if ($page = ($config['currentPage'] ?? 1) - 1) {
            $builder->skip($page * $perPage);
        }
        $builder->take($perPage);
    }
}