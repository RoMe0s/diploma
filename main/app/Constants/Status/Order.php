<?php

namespace App\Constants\Status;

class Order
{
    const DRAFT = 'draft';

    const PUBLISHED = 'published';

    const IN_WORK = 'in_work';

    const ALL = [
        self::DRAFT,
        self::PUBLISHED,
        self::IN_WORK
    ];
}
