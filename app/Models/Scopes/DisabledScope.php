<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * @template TModelClass of Model
 */
class DisabledScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder<TModelClass>  $builder
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where($model->getTable().'.disabled', false);
    }
}
