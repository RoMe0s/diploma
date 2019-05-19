<?php

namespace App\Services\Loaders\Customer;

use App\Scopes\Customer\Order\Filter;
use App\Scopes\Customer\Order\Sort;
use App\Scopes\Pagination;
use App\Scopes\ScopeInterface;
use App\Services\Loaders\Loader;
use App\Models\Order as OrderModel;
use App\Services\Loaders\PaginatorInterface;
use App\Services\Loaders\PaginatorTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Loader implements PaginatorInterface
{
    use PaginatorTrait;

    /**
     * @var Model|null
     */
    private $relation;

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * Project constructor.
     * @param Pagination $pagination
     */
    function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * @param Model $relation
     */
    public function setRelation(Model $relation): void
    {
        $this->relation = $relation;
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
        return OrderModel::query()->where('relation_type', get_class($this->relation))
            ->where('relation_id', $this->relation->getKey());
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