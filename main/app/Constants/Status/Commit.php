<?php

namespace App\Constants\Status;

class Commit
{
    const WRITING = 'writing';

    const CHECKING = 'checking';

    const PAYING = 'paying';

    const DONE = 'done';

    const FAILED = 'failed';

    const ALL = [
        self::WRITING,
        self::CHECKING,
        self::PAYING,
        self::DONE,
        self::FAILED
    ];
}
