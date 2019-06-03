<?php

namespace App\Services\Loaders\Author;

use App\Models\Plan\Plan;
use App\Models\User;
use App\Scopes\Pagination;
use App\Scopes\ScopeInterface;
use App\Services\Loaders\Loader;
use App\Scopes\Author\Order\Sort;
use App\Scopes\Author\Order\Filter;
use App\Models\Order\Order as OrderModel;
use App\Services\Loaders\PaginatorInterface;
use App\Services\Loaders\PaginatorTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Constants\Status\Order as OrderStatus;

class Order extends Loader implements PaginatorInterface
{
    use PaginatorTrait;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * Order constructor.
     * @param Pagination $pagination
     */
    function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return ScopeInterface
     */
    public function getPagination(): ScopeInterface
    {
        return $this->pagination;
    }

    /**
     * @param array $config
     * @return Builder
     */
    protected function prepareQuery(array $config): Builder
    {
        $plan = new Plan;
        $order = new OrderModel;
        return $order->newQuery()->select($order->qualifyColumn('*'))
            ->selectSub($plan->qualifyColumn('size_from'), 'size_from')
            ->selectSub($plan->qualifyColumn('size_to'), 'size_to')
            ->selectSub($plan->qualifyColumn('size_from') . '*' . $order->qualifyColumn('price'), 'dirty_min_price')
            ->selectSub($plan->qualifyColumn('size_to') . '*' . $order->qualifyColumn('price'), 'dirty_max_price')
            ->leftJoin($plan->getTable(), $plan->qualifyColumn('order_id'), '=', $order->getQualifiedKeyName())
            ->where($order->qualifyColumn('status'), OrderStatus::PUBLISHED)
            ->whereDoesntHave('commits', function (Builder $builder) {
                $builder->where($builder->getModel()->qualifyColumn('user_id'), $this->user->id);
            });
    }

    /**
     * @return array
     */
    protected function scopes(): array
    {
        return [
            Filter::class,
            Sort::class
        ];
    }
}