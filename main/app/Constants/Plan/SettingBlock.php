<?php

namespace App\Constants\Plan;

class SettingBlock
{
    const BOLD = 'b';

    const ITALIC = 'i';

    const IMAGE = 'img';

    const VIDEO = 'video';

    const ALL = [
        self::BOLD,
        self::ITALIC,
        self::IMAGE,
        self::VIDEO
    ];

    public static function getConfig(): array
    {
        return [
            self::BOLD => __('plan.setting-block.' . self::BOLD),
            self::ITALIC => __('plan.setting-block.' . self::ITALIC),
            self::IMAGE => __('plan.setting-block.' . self::IMAGE),
            self::VIDEO => __('plan.setting-block.' . self::VIDEO)
        ];
    }
}
