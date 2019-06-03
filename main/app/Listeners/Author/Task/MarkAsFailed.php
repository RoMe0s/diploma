<?php

namespace App\Listeners\Author\Task;

use App\Events\Author\Task\TimeIsOver;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Handlers\Author\Task\Strategies\Failed;

class MarkAsFailed implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * @var Failed
     */
    private $failed;

    /**
     * Create the event listener.
     *
     * @param Failed $failed
     * @return void
     */
    public function __construct(Failed $failed)
    {
        $this->failed = $failed;
    }

    /**
     * Handle the event.
     *
     * @param TimeIsOver $event
     * @return void
     */
    public function handle(TimeIsOver $event)
    {
        $this->failed->apply($event->getTask());
    }
}