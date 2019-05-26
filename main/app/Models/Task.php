<?php

namespace App\Models;

use App\Models\Order\Order;
use App\Models\Balance\Payment;
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
}
