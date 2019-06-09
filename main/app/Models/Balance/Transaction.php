<?php

namespace App\Models\Balance;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const UPDATED_AT = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'balance_id',
        'notice',
        'after',
        'before',
        'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }
}
