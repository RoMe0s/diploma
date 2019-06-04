<?php

namespace App\Scopes\Author\Task;

use App\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class Active implements ScopeInterface
{
    /**
     * @param array $config
     * @return bool
     */
    public static function supports(array $config): bool
    {
        return $config['active'] ?? false;
    }

    /**
     * @param Builder $builder
     * @param array $config
     */
    public function apply(Builder $builder, array $config): void
    {
        $builder->where($builder->getModel()->qualifyColumn('expired_at'), '>', now());
    }
}