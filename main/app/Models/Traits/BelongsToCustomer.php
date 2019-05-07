<?php

namespace App\Models\Traits;

use App\Models\User;

trait BelongsToCustomer
{
    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}