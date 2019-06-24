<?php

namespace App\Services\Checks\Translators\Settings;

use App\Models\Task\Task;
use App\Services\Checks\Translators\TranslatorInterface;

class DisallowTitle3NextToTitle2 implements TranslatorInterface
{
    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function match(string $key, $value): bool
    {
        return $key === 'settings.DisallowTitle3NextToTitle2'
            && is_array($value)
            && key_exists('part', $value);
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
            __('check_errors.settings.DisallowTitle3NextToTitle2'),
            $value['part']
        );
    }
}
