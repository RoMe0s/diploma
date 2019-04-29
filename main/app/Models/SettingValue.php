<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingValue extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'setting_id',
        'value'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
