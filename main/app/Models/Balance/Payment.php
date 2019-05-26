<?php

namespace App\Models\Balance;

use App\Models\Task;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'balance_id',
        'order_id',
        'task_id',
        'amount',
        'changed_at',
        'status',
        'error'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'changed_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
