<?php

namespace App\Services\Checks\Translators;

use App\Models\Task\Task;

interface TranslatorInterface
{
    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function match(string $key, $value): bool;

    /**
     * @param Task $task
     * @param string $key
     * @param $value
     * @return string
     */
    public function translate(Task $task, string $key, $value): string;
}
