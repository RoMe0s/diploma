<?php

namespace App\Models\Text;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'length',
        'content'
    ];
}