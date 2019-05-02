<?php

namespace App\Models;

use App\GlobalScopes\Customer as CustomerScope;

class Customer extends User
{
    /**
     * @var string
     */
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CustomerScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
