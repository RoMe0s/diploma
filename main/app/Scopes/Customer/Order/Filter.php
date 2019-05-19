<?php

namespace App\Scopes\Customer\Order;

use App\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class Filter implements ScopeInterface
{
    /**
     * @param array $config
     * @return bool
     */
    public static function supports(array $config): bool
    {
        return $config['filter'] ?? false;
    }

    /**
     * @param Builder $builder
     * @param array $config
     */
    public function apply(Builder $builder, array $config): void
    {
        $builder->where('name', 'LIKE', "%{$config['filter']}%");
    }
}