<?php

namespace App\Models;

use App\Models\Traits\BelongsToAuthor;
use App\Models\Traits\BelongsToOrder;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use BelongsToAuthor, BelongsToOrder;

    /**
     * @var array
     */
    protected $fillable = [
        'status',
        'order_id',
        'user_id',
        'notice'
    ];
}
