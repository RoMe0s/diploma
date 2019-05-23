<?php

namespace App\Models\Order;

use App\Models\Task;
use App\Models\Plan\Plan;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'relation_type',
        'relation_id',
        'description',
        'price',
        'done_at',
        'text_id',
        'name'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'done_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commits()
    {
        return $this->hasMany(Commit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
