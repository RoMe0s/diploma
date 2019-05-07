<?php

namespace App\Models\Traits;

use App\Models\User;

trait BelongsToAuthor
{
    /**
     * @return mixed
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}