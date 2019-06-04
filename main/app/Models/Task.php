<?php

namespace App\Models;

use App\Models\Order\Order;
use App\Models\Balance\Payment;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const UPDATED_AT = null;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function text()
    {
        return $this->belongsTo(Text::class);
    }

    /**
     * @return string|null
     */
    public function getExpiredAtDiff(): ?string
    {
        if ($this->expired_at && $this->expired_at->gt(now())) {
            return $this->expired_at->diffForHumans();
        }
        return null;
    }
}