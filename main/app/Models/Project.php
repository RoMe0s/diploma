<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function orders()
    {
        return $this->morphMany(Order::class, 'relation');
    }

    /**
     * @param Builder $builder
     */
    public function scopeSelectOrdersCount(Builder $builder)
    {
        $order = new Order;
        $query = $order->newQuery()
            ->selectRaw("COUNT({$order->getQualifiedKeyName()})")
            ->whereRaw($order->qualifyColumn('relation_id') . '=' . $this->getQualifiedKeyName())
            ->where($order->qualifyColumn('relation_type'), __CLASS__);

        if (!$builder->getQuery()->columns) {
            $builder->select($this->qualifyColumn('*'));
        }

        $builder->selectSub($query, 'ordersCount');
    }
}
