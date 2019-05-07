<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'length',
        'content'
    ];
}