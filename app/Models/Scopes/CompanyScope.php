<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Prevent infinite recursion when resolving the authenticated user
        if ($model instanceof \App\Models\User && !Auth::hasUser()) {
            return;
        }

        // Only apply scope if a user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Bypass scope for superadmins
            if ($user->role !== 'superadmin') {
                $builder->where($model->getTable() . '.company_id', $user->company_id);
            }
        }
    }
}
