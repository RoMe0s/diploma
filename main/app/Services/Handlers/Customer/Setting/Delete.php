<?php

namespace App\Services\Handlers\Customer\Setting;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;

class Delete
{
    /**
     * @param $checks
     * @param Model $relation
     */
    public function delete($checks, Model $relation): void
    {
        $checks = is_array($checks) ? $checks : [$checks];
        Setting::query()->where('relation_id', $relation->getKey())
            ->where('relation_type', get_class($relation))
            ->whereIn('key', $checks)
            ->delete();
    }
}