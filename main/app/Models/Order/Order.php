<?php

namespace App\Models\Order;

use App\Models\Setting;
use App\Models\Task\Task;
use App\Models\User;
use App\Models\Text;
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
        'estimate',
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function settings()
    {
        return $this->morphMany(Setting::class, 'relation');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function text()
    {
        return $this->belongsTo(Text::class);
    }

    /**
     * @param Builder $builder
     * @param User $user
     */
    public function scopeRelatedToUser(Builder $builder, User $user)
    {
        $builder->where(function (Builder $builder) use ($user) {
            $builder->where($this->qualifyColumn('relation_type'), User::class)
                ->where($this->qualifyColumn('relation_id'), $user->id);
        })->orWhere(function (Builder $builder) use ($user) {
            $project = new Project;
            $projectSubQuery = $project->newQuery()
                ->where($project->qualifyColumn('user_id'), $user->id)
                ->whereRaw("{$this->qualifyColumn('relation_id')} = {$project->getQualifiedKeyName()}")
                ->toBase();
            $builder->where($this->qualifyColumn('relation_type'), Project::class)
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
    public function canBeRolledBack(): bool
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

    /**
     * @param User $user
     * @return bool
     */
    public function belongsToCustomer(User $user): bool
    {
        if ($this->relation_type === Project::class) {
            return $this->relation->user_id == $user->id;
        }
        return $this->relation_id == $user->id;
    }
}
