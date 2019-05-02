<?php

namespace App\GlobalScopes;

use App\Constants\Role;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Author implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->qualifyColumn('role'), Role::AUTHOR);
    }
}
