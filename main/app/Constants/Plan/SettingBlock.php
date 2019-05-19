<?php

namespace App\Constants\Plan;

class SettingBlock
{
    const BOLD = 'b';

    const ITALIC = 'i';

    const IMAGE = 'img';

    const VIDEO = 'video';

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
