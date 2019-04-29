<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'relation_type',
        'relation_id'
    ];

    /**
     * @return mixed
     */
    public function values()
    {
        return $thas->hasMany(SettingValue::class);
    }
}
