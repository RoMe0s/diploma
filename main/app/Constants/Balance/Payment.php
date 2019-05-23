<?php

namespace App\Constants\Balance;

class Payment
{
    const NEW = 'new';

    const PROCESSING = 'processing';

    const DONE = 'done';

    const FAILED = 'failed';

    const ALL = [
        self::NEW,
        self::PROCESSING,
        self::DONE,
        self::FAILED
    ];
}
