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
        'order_id',
        'text_id',
        'status',
        'user_id'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'expired_at'
    ];
}
