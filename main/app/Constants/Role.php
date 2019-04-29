<?php

namespace App\Constants;

class Role
{
    const AUTHOR = 'author';

    const CUSTOMER = 'customer';

    const ADMIN = 'admin';

    const ALL = [
        self::ADMIN,
        self::AUTHOR,
        self::CUSTOMER
    ];

    const REGISTER = [
        self::AUTHOR,
        self::CUSTOMER
    ];
}
