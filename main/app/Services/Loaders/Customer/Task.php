<?php

namespace App\Services\Loaders\Customer;

use App\Models\User;
use App\Models\Project;
use App\Scopes\Pagination;
use App\Scopes\ScopeInterface;
use App\Services\Loaders\Loader;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Loaders\PaginatorTrait;
use App\Services\Loaders\PaginatorInterface;
use App\Constants\Status\Task as TaskStatus;
use App\Models\Task\Task as TaskModel;
use App\Scopes\Customer\Task\Filter;
use App\Scopes\Customer\Task\Sort;
use App\Models\Order\Commit;
use App\Models\Order\Order;

class Task extends Loader implements PaginatorInterface
{
    use PaginatorTrait;

    /**
     * @var
     */
    private $user;

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * Task constructor.
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
        $task = new TaskModel;
        $commit = new Commit;
        $order = new Order;

        $commitDateSubQuery = $commit->newQuery()->select($commit->qualifyColumn('created_at'))
            ->whereRaw($commit->qualifyColumn('order_id') . ' = ' . $task->qualifyColumn('order_id'))
            ->latest($commit->getQualifiedKeyName())
            ->limit(1);

        return $task->newQuery()->select($task->qualifyColumn('*'))
            ->addSelect($order->qualifyColumn('description'))
            ->addSelect($order->qualifyColumn('name'))
            ->selectSub($commitDateSubQuery, 'date')
            ->leftJoin(
                $order->getTable(),
                $order->getQualifiedKeyName(),
                '=',
                $task->qualifyColumn('order_id')
            )
            ->where($task->qualifyColumn('status'), TaskStatus::PAYING)
            ->whereHas('order', function (Builder $builder) {
                $typeColumn = $builder->qualifyColumn('relation_type');
                $idColumn = $builder->qualifyColumn('relation_id');
                $builder->where(function (Builder $builder) use ($typeColumn, $idColumn) {
                    $builder->where($typeColumn, User::class)
                        ->where($idColumn, $this->user->id);
                })->orWhere(function (Builder $builder) use ($typeColumn, $idColumn) {
                    $project = new Project;
                    $isUserProjectSubQuery = $project->newQuery()
                        ->whereRaw($project->getQualifiedKeyName() . ' = ' . $idColumn)
                        ->where($project->qualifyColumn('user_id'), $this->user->id)
                        ->toBase();

                    $builder->where($typeColumn, Project::class)
                        ->addWhereExistsQuery($isUserProjectSubQuery);
                });
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
