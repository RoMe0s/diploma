<?php

namespace App\Services\Loaders\Customer;

use App\Scopes\Customer\Project\Filter;
use App\Scopes\Customer\Project\Sort;
use App\Scopes\Pagination;
use App\Scopes\ScopeInterface;
use App\Services\Loaders\Loader;
use App\Models\Project as ProjectModel;
use App\Services\Loaders\PaginatorInterface;
use App\Services\Loaders\PaginatorTrait;
use Illuminate\Database\Eloquent\Builder;

class Project extends Loader implements PaginatorInterface
{
    use PaginatorTrait;

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
    public function prepareQuery(array $config): Builder
    {
        return ProjectModel::query()->selectOrdersCount()->where('customer_id', $this->user->id);
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