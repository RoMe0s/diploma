<?php

namespace App\Constants\Status;

class Task
{
    const WRITING = 'writing';

    const CHECKING = 'checking';

    const PAYING = 'paying';

    const ALL = [
        self::WRITING,
        self::CHECKING,
        self::PAYING
    ];
}
