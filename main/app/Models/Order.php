<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'relation',
        'done_at',
        'hash'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'done_at'
    ];
}
