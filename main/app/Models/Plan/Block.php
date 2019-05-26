<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'position',
        'heading',
        'size_from',
        'size_to',
        'plan_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keys()
    {
        return $this->hasMany(Key::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settingBlocks()
    {
        return $this->hasMany(SettingBlock::class);
    }
}
