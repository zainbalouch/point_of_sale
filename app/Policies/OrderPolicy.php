<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // The basic permission check
        // Actual filtering by company/POS is done in getEloquentQuery in the Resource class
        return $user->can('view_any_order');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        // Check basic permission
        if (!$user->can('view_order')) {
            return false;
        }

        // If user has point_of_sale_id, they can only view orders from their POS
        if ($user->point_of_sale_id) {
            return $order->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only view orders from their company
        if ($user->company_id) {
            return $order->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_order');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        // Check basic permission
        if (!$user->can('update_order')) {
            return false;
        }

        // If user has point_of_sale_id, they can only update orders from their POS
        if ($user->point_of_sale_id) {
            return $order->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only update orders from their company
        if ($user->company_id) {
            return $order->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        // Check basic permission
        if (!$user->can('delete_order')) {
            return false;
        }

        // If user has point_of_sale_id, they can only delete orders from their POS
        if ($user->point_of_sale_id) {
            return $order->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only delete orders from their company
        if ($user->company_id) {
            return $order->company_id === $user->company_id;
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
        return $user->can('delete_any_order');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        // Check basic permission
        if (!$user->can('force_delete_order')) {
            return false;
        }

        // If user has point_of_sale_id, they can only force delete orders from their POS
        if ($user->point_of_sale_id) {
            return $order->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only force delete orders from their company
        if ($user->company_id) {
            return $order->company_id === $user->company_id;
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
        return $user->can('force_delete_any_order');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Order $order): bool
    {
        // Check basic permission
        if (!$user->can('restore_order')) {
            return false;
        }

        // If user has point_of_sale_id, they can only restore orders from their POS
        if ($user->point_of_sale_id) {
            return $order->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only restore orders from their company
        if ($user->company_id) {
            return $order->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user, Order $order): bool
    {
        // Check basic permission
        if (!$user->can('restore_any_order')) {
            return false;
        }

        // If user has point_of_sale_id, they can only replicate orders from their POS
        if ($user->point_of_sale_id) {
            return $order->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only replicate orders from their company
        if ($user->company_id) {
            return $order->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Order $order): bool
    {
        // Check basic permission
        if (!$user->can('replicate_order')) {
            return false;
        }

        // If user has point_of_sale_id, they can only replicate orders from their POS
        if ($user->point_of_sale_id) {
            return $order->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only replicate orders from their company
        if ($user->company_id) {
            return $order->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_order');
    }
}
