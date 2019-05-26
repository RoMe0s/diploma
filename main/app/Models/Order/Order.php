<?php

namespace App\Models\Order;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Plan\Plan;
use App\Models\Balance\Payment;
use App\Models\Balance\LockedChunk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Constants\Status\Order as OrderStatus;

class Order extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'relation_type',
        'relation_id',
        'description',
        'status',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function relation()
    {
        return $this->morphTo('relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lockedChunk()
    {
        return $this->hasOne(LockedChunk::class);
    }

    /**
     * @param Builder $builder
     * @param User $user
     */
    public function scopeRelatedToUser(Builder $builder, User $user)
    {
        $builder->where(function (Builder $builder) use ($user) {
            $builder->where('relation_type', User::class)
                ->where('relation_id', $user->id);
        })->orWhere(function (Builder $builder) use ($user) {
            $projectSubQuery = Project::query()->where('user_id', $user->id)
                ->whereRaw('orders.relation_id = projects.id')
                ->toBase();
            $builder->where('relation_type', Project::class)
                ->addWhereExistsQuery($projectSubQuery);
        });
    }

    /**
     * @return bool
     */
    public function canBePublished(): bool
    {
        return $this->status === OrderStatus::DRAFT;
    }

    /**
     * @return bool
     */
    public function canBeRollbacked(): bool
    {
        return $this->status === OrderStatus::PUBLISHED;
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        if ($this->relationLoaded('plan')) {
            $sizeTo = $this->plan->size_to;
        } else {
            $sizeTo = $this->plan()->value('size_to');
        }
        return round($this->price * $sizeTo / 1000, 2);
    }
}
