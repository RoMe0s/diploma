<?php

namespace App\Constants;

class Role
{
    const AUTHOR = 'author';

    const CUSTOMER = 'customer';

    const ALL = [
        self::AUTHOR,
        self::CUSTOMER
    ];

    const REGISTER = [
        self::AUTHOR,
        self::CUSTOMER
    ];
}