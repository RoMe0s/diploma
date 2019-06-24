<?php

namespace App\Services\Checks\Translators\Settings;

use App\Models\Task\Task;
use App\Services\Checks\Translators\TranslatorInterface;

class MinimumNumberOfLettersInTheTitle implements TranslatorInterface
{
    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function match(string $key, $value): bool
    {
        return $key === 'settings.MinimumNumberOfLettersInTheTitle'
            && is_array($value)
            && key_exists('part', $value)
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
            __('check_errors.settings.MinimumNumberOfLettersInTheTitle'),
            $value['part'],
            $value['got'],
            $value['excpected']
        );
    }
}
