<?php

namespace App\Constants\Plan;

class Key
{
    const STRICT = 'strict';

    const NOT_STRICT = 'not_strict';

    const ALL = [
        self::STRICT,
        self::NOT_STRICT
    ];

    /**
     * @return array
     */
    public static function getConfig(): array
    {
        return [
            self::STRICT => __('plan.key.' . self::STRICT),
            self::NOT_STRICT => __('plan.key.' . self::NOT_STRICT)
        ];
    }
}
