<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('view_any_user');
    }

    /**
     * Scope the query to only include users from the same company.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function viewAnyQuery(User $user, Builder $query): Builder
    {
        if ($user->hasRole('super_admin')) {
            return $query;
        }
        return $query->where('company_id', $user->company_id);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('view_user') && $user->company_id === $model->company_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('update_user') && $user->company_id === $model->company_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('delete_user') && $user->company_id === $model->company_id;
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('delete_any_user');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function forceDelete(User $user, User $model): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('force_delete_user') && $user->company_id === $model->company_id;
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('force_delete_any_user');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function restore(User $user, User $model): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('restore_user') && $user->company_id === $model->company_id;
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('restore_any_user');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return bool
     */
    public function replicate(User $user, User $model): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('replicate_user') && $user->company_id === $model->company_id;
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }
        return $user->can('reorder_user');
    }
}
