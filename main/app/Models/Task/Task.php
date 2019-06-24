<?php

namespace App\Models\Task;

use App\Models\Order\Order;
use App\Models\Text;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Constants\Status\Task as Status;
use App\Models\Setting;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function text()
    {
        return $this->belongsTo(Text::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checks()
    {
        return $this->hasMany(Check::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function settings()
    {
        return $this->morphMany(Setting::class, 'relation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(TaskMessage::class);
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

    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->status === Status::WRITING;
    }

    /**
     * @return bool
     */
    public function onCheck(): bool
    {
        return $this->status === Status::CHECKING;
    }

    /**
     * @return bool
     */
    public function onPaying(): bool
    {
        return $this->status === Status::PAYING;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function belongsToCustomer(User $user): bool
    {
        return $this->order->belongsToCustomer($user);
    }
}
