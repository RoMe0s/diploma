<?php

namespace App\Services\Handlers\Author\Task\Strategies;

use App\Models\Task\Task;
use App\Models\Order\Commit;
use App\Services\Elixir\Proxy;
use App\Constants\Status\Task as TaskStatus;
use App\Constants\Status\Commit as CommitStatus;
use App\Http\Resources\Author\Task\ToCheck\RootResource;
use Illuminate\Support\Facades\DB;

class ToAutoChecks implements StrategyInterface
{
    /**
     * @var Proxy
     */
    private $proxy;

    /**
     * ToAutoChecks constructor.
     * @param Proxy $proxy
     */
    function __construct(Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @param Task $task
     * @param array|null $params
     * @return bool
     */
    public static function support(Task $task, array $params = null): bool
    {
        if ($task->status === TaskStatus::WRITING) {
            return $task->order->commits->last()->status !== CommitStatus::CHECKING
                || $task->checks->isNotEmpty();
        }
        return false;
    }

    /**
     * @param Task $task
     * @param array|null $params
     */
    public function apply(Task $task, array $params = null): void
    {
        DB::transaction(function () use ($task) {
            Commit::query()->create([
                'status' => CommitStatus::CHECKING,
                'order_id' => $task->order_id,
                'user_id' => $task->user_id
            ]);
            $task->update(['status' => TaskStatus::CHECKING]);
            $task->checks()->delete();
        });
        $this->sendRequest($task);
    }

    /**
     * @param Task $task
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest(Task $task): void
    {
        $task->loadMissing(['text', 'settings', 'order.plan.blocks' => function ($q) {
            $q->with(['keys', 'settingBlocks']);
        }]);
        $data = RootResource::make($task)->resolve();
        $this->proxy->send('post', 'check', ['form_params' => $data]);
    }
}
