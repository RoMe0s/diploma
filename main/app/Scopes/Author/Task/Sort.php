<?php

namespace App\Scopes\Author\Task;

use App\Scopes\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Sort implements ScopeInterface
{
    /**
     * @param array $config
     * @return bool
     */
    public static function supports(array $config): bool
    {
        return true;
    }

    /**
     * @param Builder $builder
     * @param array $config
     */
    public function apply(Builder $builder, array $config): void
    {
        $model = $builder->getModel();
        if ($sortBy = $config['sortBy'] ?? null) {
            $sortBy = $this->qualifySortBy($model, $sortBy);
            $sortType = ($config['sortDesc'] ?? false) ? 'desc' : 'asc';
            $builder->orderBy($sortBy, $sortType);
        } else {
            $builder->orderBy('has_expired_at', 'desc')
                ->orderBy($model->qualifyColumn('expired_at'));
        }
    }

    /**
     * @param Model $model
     * @param string $sortBy
     * @return string
     */
    private function qualifySortBy(Model $model, string $sortBy): string
    {
        switch ($sortBy) {
            case 'date':
            case 'name':
                return $sortBy;
            case 'expired_at':
            case 'status':
                return $model->qualifyColumn($sortBy);
            case 'id':
                return $model->getQualifiedKeyName();
        }
    }
}