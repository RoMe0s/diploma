<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

class Pagination implements ScopeInterface
{
    /**
     * @param array $config
     * @return bool
     */
    public static function supports(array $config): bool
    {
        return key_exists('perPage', $config) && $config['perPage'];
    }

    /**
     * @param Builder $builder
     * @param array $config
     */
    public function apply(Builder $builder, array $config): void
    {
        $perPage = $config['perPage'];
        if ($page = ($config['currentPage'] ?? 1) - 1) {
            $builder->skip($page * $perPage);
        }
        $builder->take($perPage);
    }
}