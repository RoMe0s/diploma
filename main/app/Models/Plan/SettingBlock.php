<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;

class SettingBlock extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'max',
        'min',
        'block_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
