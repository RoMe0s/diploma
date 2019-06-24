<?php

namespace App\Services\Checks;

use App\Models\Task\Task;
use App\Services\Checks\Translators\Plan;
use App\Services\Checks\Translators\Keys;
use App\Services\Checks\Translators\Blocks;
use App\Services\Checks\Translators\Settings;
use App\Services\Checks\Translators\SettingBlocks;
use App\Services\Checks\Translators\TranslatorInterface;

class Translator
{
    /**
     * @var Task
     */
    private $task;

    /**
     * Translator constructor.
     * @param Task $task
     */
    function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @param string $key
     * @param string $value
     * @return string
     * @throws \Exception
     */
    public function translate(string $key, string $value): string
    {
        $value = json_decode($value, true);
        if ($translator = $this->getTranslator($key, $value)) {
            return $translator->translate($this->task, $key, $value);
        }
        throw new \Exception("There is no '$key' exception translator");
    }

    /**
     * @param string $key
     * @param $value
     * @return TranslatorInterface|null
     */
    private function getTranslator(string $key, $value): ?TranslatorInterface
    {
        /** @var TranslatorInterface $translator */
        foreach ($this->translators() as $translator) {
            if ($translator::match($key, $value)) {
                return resolve($translator);
            }
        }
        return null;
    }

    /**
     * @return array
     */
    private function translators(): array
    {
        return [
            Plan\SizeFrom::class,
            Plan\SizeTo::class,
            Keys\Mismatch::class,
            Blocks\DoesNotExist::class,
            Blocks\SizeFrom::class,
            Blocks\SizeTo::class,
            Settings\DisallowTitle3NextToTitle2::class,
            Settings\MinimumNumberOfLettersInTheTitle::class,
            Settings\MaximumNumberOfLettersInTheTitle::class,
            Settings\MinimumNumberOfLettersInTheParagraph::class,
            Settings\MaximumNumberOfLettersInTheParagraph::class,
            SettingBlocks\Mismatch::class
        ];
    }
}
