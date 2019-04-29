<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'expired_at',
        'author_id',
        'order_id',
        'status'
    ];
}
