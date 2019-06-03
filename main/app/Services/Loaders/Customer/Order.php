<?php

namespace App\Services\Loaders\Customer;

use App\Models\Plan\Plan;
use App\Models\User;
use App\Scopes\Pagination;
use App\Scopes\ScopeInterface;
use App\Services\Loaders\Loader;
use App\Scopes\Customer\Order\Sort;
use App\Scopes\Customer\Order\Filter;
use App\Models\Order\Order as OrderModel;
use App\Services\Loaders\PaginatorInterface;
use App\Services\Loaders\PaginatorTrait;
use Illuminate\Database\Eloquent\Builder;

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
        $order = new OrderModel;
        $plan = new Plan;
        return $order->newQuery()->select($order->qualifyColumn('*'))
            ->leftJoin($plan->getTable(), $plan->qualifyColumn('order_id'), '=', $order->getQualifiedKeyName())
            ->selectSub($order->qualifyColumn('price') . '*' . $plan->qualifyColumn('size_to'), 'dirty_price')
            ->selectSub("IFNULL({$order->qualifyColumn('done_at')}, {$order->qualifyColumn('updated_at')})", 'date')
            ->relatedToUser($this->user);
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