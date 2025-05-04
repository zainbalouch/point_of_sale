<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // The basic permission check
        // Actual filtering by company/POS is done in getEloquentQuery in the Resource class
        return $user->can('view_any_product');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        // Check basic permission
        if (!$user->can('view_product')) {
            return false;
        }

        // If user has point_of_sale_id, they can only view products from their POS
        if ($user->point_of_sale_id) {
            return $product->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only view products from their company
        if ($user->company_id) {
            return $product->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_product');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Check basic permission
        if (!$user->can('update_product')) {
            return false;
        }

        // If user has point_of_sale_id, they can only update products from their POS
        if ($user->point_of_sale_id) {
            return $product->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only update products from their company
        if ($user->company_id) {
            return $product->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Check basic permission
        if (!$user->can('delete_product')) {
            return false;
        }

        // If user has point_of_sale_id, they can only delete products from their POS
        if ($user->point_of_sale_id) {
            return $product->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only delete products from their company
        if ($user->company_id) {
            return $product->company_id === $user->company_id;
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
        return $user->can('delete_any_product');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        // Check basic permission
        if (!$user->can('force_delete_product')) {
            return false;
        }

        // If user has point_of_sale_id, they can only force delete products from their POS
        if ($user->point_of_sale_id) {
            return $product->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only force delete products from their company
        if ($user->company_id) {
            return $product->company_id === $user->company_id;
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
        return $user->can('force_delete_any_product');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Product $product): bool
    {
        // Check basic permission
        if (!$user->can('restore_product')) {
            return false;
        }

        // If user has point_of_sale_id, they can only restore products from their POS
        if ($user->point_of_sale_id) {
            return $product->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only restore products from their company
        if ($user->company_id) {
            return $product->company_id === $user->company_id;
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
        return $user->can('restore_any_product');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Product $product): bool
    {
        // Check basic permission
        if (!$user->can('replicate_product')) {
            return false;
        }

        // If user has point_of_sale_id, they can only replicate products from their POS
        if ($user->point_of_sale_id) {
            return $product->point_of_sale_id === $user->point_of_sale_id;
        }

        // If user has company_id, they can only replicate products from their company
        if ($user->company_id) {
            return $product->company_id === $user->company_id;
        }

        // Super admin or other users with the permission but no restrictions
        return true;
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_product');
    }
}
