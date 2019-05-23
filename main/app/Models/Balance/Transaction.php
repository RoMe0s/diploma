<?php

namespace App\Models\Balance;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'balance_id',
        'notice',
        'after',
        'before'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }
}
