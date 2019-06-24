<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'value',
        'key'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
