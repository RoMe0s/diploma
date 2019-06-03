<?php

namespace App\Scopes\Author\Order;

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
        $sortBy = $this->getSortBy($builder->getModel(), $config);
        $sortType = ($config['sortDesc'] ?? false) ? 'desc' : 'asc';
        $builder->orderBy($sortBy, $sortType);
    }

    /**
     * @param Model $model
     * @param array $config
     * @return string
     */
    private function getSortBy(Model $model, array $config): string
    {
        $sortBy = $config['sortBy'] ?? null;
        switch ($sortBy) {
            case 'size_from':
            case 'size_to':
                return $sortBy;
            case 'min_price':
                return 'dirty_min_price';
            case 'max_price':
                return 'dirty_max_price';
            case 'name':
            case 'estimate':
                return $model->qualifyColumn($sortBy);
            default:
                return $model->getQualifiedKeyName();
        }
    }
}