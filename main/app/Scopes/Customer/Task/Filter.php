<?php

namespace App\Scopes\Customer\Task;

use App\Models\Order\Order;
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
        $order = new Order;
        $filter = $config['filter'];
        $nameColumn = $order->qualifyColumn('name');
        $orderIdColumn = $builder->getModel()->qualifyColumn('order_id');

        $orderNameSubQuery = $order->newQuery()->where($nameColumn, 'LIKE', "%$filter%")
            ->whereRaw($order->getQualifiedKeyName() . ' = ' . $orderIdColumn)
            ->toBase();

        $builder->addWhereExistsQuery($orderNameSubQuery);
    }
}
