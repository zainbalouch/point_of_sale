<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // The basic permission check
        // Actual filtering by company/POS is done in getEloquentQuery in the Resource class
        return $user->can('view_any_customer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Customer $customer): bool
    {
        // Check basic permission
        if (!$user->can('view_customer')) {
            return false;
        }

        // If user has point_of_sale_id, they can only view customers from their POS
        if ($user->point_of_sale_id) {
            return $customer->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only view customers from their company
        if ($user->company_id) {
            return $customer->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_customer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Customer $customer): bool
    {
        // Check basic permission
        if (!$user->can('update_customer')) {
            return false;
        }

        // If user has point_of_sale_id, they can only update customers from their POS
        if ($user->point_of_sale_id) {
            return $customer->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only update customers from their company
        if ($user->company_id) {
            return $customer->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Customer $customer): bool
    {
        // Check basic permission
        if (!$user->can('delete_customer')) {
            return false;
        }

        // If user has point_of_sale_id, they can only delete customers from their POS
        if ($user->point_of_sale_id) {
            return $customer->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only delete customers from their company
        if ($user->company_id) {
            return $customer->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        // The basic permission check
        // Actual filtering by company/POS is done in getEloquentQuery in the Resource class
        return $user->can('delete_any_customer');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Customer $customer): bool
    {
        // Check basic permission
        if (!$user->can('force_delete_customer')) {
            return false;
        }

        // If user has point_of_sale_id, they can only force delete customers from their POS
        if ($user->point_of_sale_id) {
            return $customer->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only force delete customers from their company
        if ($user->company_id) {
            return $customer->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        // The basic permission check
        // Actual filtering by company/POS is done in getEloquentQuery in the Resource class
        return $user->can('force_delete_any_customer');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Customer $customer): bool
    {
        // Check basic permission
        if (!$user->can('restore_customer')) {
            return false;
        }

        // If user has point_of_sale_id, they can only restore customers from their POS
        if ($user->point_of_sale_id) {
            return $customer->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only restore customers from their company
        if ($user->company_id) {
            return $customer->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        // The basic permission check
        // Actual filtering by company/POS is done in getEloquentQuery in the Resource class
        return $user->can('restore_any_customer');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Customer $customer): bool
    {
        // Check basic permission
        if (!$user->can('replicate_customer')) {
            return false;
        }

        // If user has point_of_sale_id, they can only replicate customers from their POS
        if ($user->point_of_sale_id) {
            return $customer->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only replicate customers from their company
        if ($user->company_id) {
            return $customer->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_customer');
    }
}
