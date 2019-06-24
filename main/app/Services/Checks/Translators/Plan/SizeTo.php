<?php

namespace App\Services\Checks\Translators\Plan;

use App\Models\Task\Task;
use App\Services\Checks\Translators\TranslatorInterface;

class SizeTo implements TranslatorInterface
{
    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function match(string $key, $value): bool
    {
        return $key === 'plan.size_to'
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
        return sprintf(
            __('check_errors.plan.size_to'),
            $value['got'],
            $value['excpected']
        );
    }
}
