<?php

namespace App\Services\Handlers\Author\Task;

use App\Models\Task;
use App\Services\Elixir\Proxy;
use App\Constants\Status\Task as Status;
use App\Http\Resources\Author\Task\ToCheck\RootResource;

class ToCheck
{
    /**
     * @var Proxy
     */
    private $proxy;

    /**
     * ToCheck constructor.
     * @param Proxy $proxy
     */
    function __construct(Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @param Task $task
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function toCheck(Task $task): void
    {
        // $task->update(['status' => Status::CHECKING]);
        $this->sendRequest($task);
    }

    /**
     * @param Task $task
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest(Task $task): void
    {
        $task->loadMissing(['text', 'order' => function ($q) {
            $q->with(['relation.settings', 'settings', 'plan.blocks' => function ($q) {
                $q->with(['keys', 'settingBlocks']);
            }]);
        }]);
        $data = RootResource::make($task)->resolve();
        $this->proxy->send('post', 'check', $data);
    }
}
