<?php

namespace App\Scopes\Author\Task;

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
        $descriptionColumn = $order->qualifyColumn('description');
        $orderNameSubQuery = $order->newQuery()
            ->whereRaw($order->getQualifiedKeyName() . ' = ' . $builder->getModel()->qualifyColumn('order_id'))
            ->where(function (Builder $builder) use ($nameColumn, $descriptionColumn, $filter) {
                $builder->where($nameColumn, 'LIKE', "%$filter%")
                    ->orWhere(function (Builder $builder) use ($nameColumn, $descriptionColumn, $filter) {
                        $builder->whereNull($nameColumn)->where($descriptionColumn, 'LIKE', "%$filter%");
                    });
            })
            ->toBase();

        $builder->addWhereExistsQuery($orderNameSubQuery);
    }
}