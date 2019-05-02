<?php

namespace App\Models;

use App\GlobalScopes\Author as AuthorScope;

class Author extends User
{
    /**
     * @var string
     */
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AuthorScope);
    }
}
