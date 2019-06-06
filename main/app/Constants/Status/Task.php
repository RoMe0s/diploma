<?php

namespace App\Constants\Status;

class Task
{
    const WRITING = 'writing';

    const CHECKING = 'checking';

    const WAITING = 'waiting';

    const PAYING = 'paying';

    const ALL = [
        self::WRITING,
        self::CHECKING,
        self::WAITING,
        self::PAYING
    ];
}