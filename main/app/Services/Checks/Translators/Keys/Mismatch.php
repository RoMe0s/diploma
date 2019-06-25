<?php

namespace App\Services\Checks\Translators\Keys;

use App\Constants\Plan\Heading;
use App\Models\Task\Task;
use App\Services\Checks\Translators\TranslatorInterface;

class Mismatch implements TranslatorInterface
{
    const REGEX = '@^plan\.blocks\.(\d+)\.keys\.(.+)$@';

    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function match(string $key, $value): bool
    {
        return preg_match(self::REGEX, $key)
            && is_array($value)
            && key_exists('excpected', $value)
            && key_exists('got', $value);
    }

    /**
     * @param Task $task
     * @param string $key
     * @param $value
     * @return string
     */
    public function translate(Task $task, string $key, $value): string
    {
        preg_match(self::REGEX, $key, $matches);
        $error = $value['got'] > $value['excpected'] ? 'more' : 'less';
        return sprintf(
            __('check_errors.keys.' . $error),
            $this->getBlockName($task, $matches[1]),
            $matches[2],
            $value['got'],
            $value['excpected']
        );
    }

    /**
     * @param Task $task
     * @param int $position
     * @return string
     */
    private function getBlockName(Task $task, int $position): string
    {
        $hasOpeningBlock = $task->order->plan->blocks->where('heading', Heading::OPENING)->isNotEmpty();
        if ($hasOpeningBlock && $position < 2) {
            return __('messages.opening block');
        }
        return $task->order->plan->blocks->where('position', $position)->first()->name;
    }
}
