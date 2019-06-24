<?php

namespace App\Scopes\Author\Task;

use App\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;
use App\Constants\Status\Task as TaskStatus;

class Done implements ScopeInterface
{
    /**
     * @param array $config
     * @return bool
     */
    public static function supports(array $config): bool
    {
        return $config['done'] ?? false;
    }

    /**
     * @param Builder $builder
     * @param array $config
     */
    public function apply(Builder $builder, array $config): void
    {
        $builder->where(
            $builder->qualifyColumn('status'),
            TaskStatus::DONE
        );
    }
}
