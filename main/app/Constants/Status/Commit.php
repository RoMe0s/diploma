<?php

namespace App\Constants\Status;

class Commit
{
    const WRITING = 'writing';

    const WRITTEN = 'written';

    const CHECKING = 'checking';

    const CHECKED = 'checked';

    const PAYING = 'paying';

    const DONE = 'done';

    const FAILED = 'failed';

    const ALL = [
        self::WRITING,
        self::WRITTEN,
        self::CHECKING,
        self::CHECKED,
        self::PAYING,
        self::DONE,
        self::FAILED
    ];
}
