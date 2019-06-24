<?php

namespace App\Models\Task;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TaskMessage extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'message',
        'user_id',
        'task_id',
        'seen'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
