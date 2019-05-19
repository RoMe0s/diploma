<?php

namespace App\Constants\Plan;

class Key
{
    const STRICT = 'strict';

    const NOT_STRICT = 'not_strict';

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
