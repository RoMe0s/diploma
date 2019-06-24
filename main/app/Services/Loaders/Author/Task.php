<?php

namespace App\Services\Loaders\Author;

use App\Models\User;
use App\Scopes\Pagination;
use App\Scopes\ScopeInterface;
use App\Services\Loaders\Loader;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Loaders\PaginatorTrait;
use App\Services\Loaders\PaginatorInterface;
use App\Models\Task\Task as TaskModel;
use App\Scopes\Author\Task\Filter;
use App\Scopes\Author\Task\Active;
use App\Scopes\Author\Task\Sort;
use App\Scopes\Author\Task\Done;
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
            ->where($commit->qualifyColumn('user_id'), $this->user->id)
            ->latest($commit->getQualifiedKeyName())
            ->limit(1);

        $expiredAtColumn = $task->qualifyColumn('expired_at');
        $hasExpiredAtSubQuery = "IF($expiredAtColumn IS NOT NULL AND $expiredAtColumn > NOW(), 1, 0)";

        return $task->newQuery()->select($task->qualifyColumn('*'))
            ->selectSub($hasExpiredAtSubQuery, 'has_expired_at')
            ->addSelect($order->qualifyColumn('description'))
            ->addSelect($order->qualifyColumn('name'))
            ->selectSub($commitDateSubQuery, 'date')
            ->leftJoin(
                $order->getTable(),
                $order->getQualifiedKeyName(),
                '=',
                $task->qualifyColumn('order_id')
            )
            ->where($task->qualifyColumn('user_id'), $this->user->id);
    }

    /**
     * @return array
     */
    protected function scopes(): array
    {
        return [
            Filter::class,
            Active::class,
            Sort::class,
            Done::class
        ];
    }
}
