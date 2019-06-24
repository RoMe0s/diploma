<?php

namespace App\Services\Handlers\Author\Task\Strategies;

use Carbon\Carbon;
use App\Models\Task\Task;
use Illuminate\Support\Facades\DB;
use App\Constants\Status\Task as Status;
use App\Events\Author\Task\Checked as CheckedEvent;

class Checked implements StrategyInterface
{
    /**
     * @param Task $task
     * @param array|null $params
     * @return bool
     */
    public static function support(Task $task, array $params = null): bool
    {
        return $task->onCheck() && is_a($task->expired_at, Carbon::class) && $task->expired_at->gt(now());
    }

    /**
     * @param Task $task
     * @param array|null $params
     */
    public function apply(Task $task, array $params = null): void
    {
        DB::transaction(function () use ($task, $params) {
            $task->update(['status' => Status::WRITING]);
            $this->parseChecks($task, $params);
        });
        CheckedEvent::dispatch($task);
    }

    /**
     * @param Task $task
     * @param array $params
     */
    private function parseChecks(Task $task, array $params): void
    {
        if (key_exists('settings', $params)) {
            $this->saveSettings($task, $params['settings']);
        }
        if (key_exists('plan', $params)) {
            $this->savePlan($task, $params['plan']);
        }
    }

    /**
     * @param Task $task
     * @param array $settings
     */
    private function saveSettings(Task $task, array $settings): void
    {
        foreach ($settings as $setting => $error) {
            $key = "settings.$setting";
            $value = json_encode($error);
            $task->checks()->updateOrCreate(compact('key'), compact('value'));
        }
    }

    /**
     * @param Task $task
     * @param array $plan
     */
    private function savePlan(Task $task, array $plan): void
    {
        if (key_exists('size_from', $plan)) {
            $key = 'plan.size_from';
            $value = json_encode($plan['size_from']);
            $task->checks()->updateOrCreate(compact('key'), compact('value'));
        }
        if (key_exists('size_to', $plan)) {
            $key = 'plan.size_to';
            $value = json_encode($plan['size_to']);
            $task->checks()->updateOrCreate(compact('key'), compact('value'));
        }
        if (key_exists('blocks', $plan)) {
            $this->saveBlocks($task, $plan['blocks']);
        }
    }

    /**
     * @param Task $task
     * @param array $blocks
     */
    private function saveBlocks(Task $task, array $blocks): void
    {
        foreach ($blocks as $position => $blockErrors) {
            foreach ($blockErrors as $errorKey => $error) {
                if ($errorKey === 'settings') {
                    $this->saveSettingBlocks($task, $position, $error);
                } elseif ($errorKey === 'keys') {
                    $this->saveKeys($task, $position, $error);
                } else {
                    $key = "plan.blocks.$position.$errorKey";
                    $value = json_encode($error);
                    $task->checks()->updateOrCreate(compact('key'), compact('value'));
                }
            }
        }
    }

    /**
     * @param Task $task
     * @param int $position
     * @param array $settingBlocksErrors
     */
    private function saveSettingBlocks(Task $task, int $position, array $settingBlocksErrors): void
    {
        foreach ($settingBlocksErrors as $errorKey => $error) {
            $key = "plan.blocks.$position.settings.$errorKey";
            $value = json_encode($error);
            $task->checks()->updateOrCreate(compact('key'), compact('value'));
        }
    }

    /**
     * @param Task $task
     * @param int $position
     * @param array $keysErrors
     */
    private function saveKeys(Task $task, int $position, array $keysErrors): void
    {
        foreach ($keysErrors as $errorKey => $error) {
            $key = "plan.blocks.$position.keys.$errorKey";
            $value = json_encode($error);
            $task->checks()->updateOrCreate(compact('key'), compact('value'));
        }
    }
}
