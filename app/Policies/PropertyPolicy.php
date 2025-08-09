<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Users with show-property permission can view properties
        return $user->can('show-property');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Property $property): bool
    {
        // Super Admin can view all properties
        if ($user->hasRole('Super Admin')) {
            return true;
        }
        
        // Users can only view their own properties
        return $property->added_by === $user->id && $user->can('show-property');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Users with add-property permission can create properties
        return $user->can('add-property');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Property $property): bool
    {
        // Super Admin can update all properties
        if ($user->hasRole('Super Admin')) {
            return $user->can('edit-property');
        }
        
        // Users can only update their own properties
        return $property->added_by === $user->id && $user->can('edit-property');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Property $property): bool
    {
        // Super Admin can delete all properties
        if ($user->hasRole('Super Admin')) {
            return $user->can('delete-property');
        }
        
        // Users can only delete their own properties
        return $property->added_by === $user->id && $user->can('delete-property');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Property $property): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Property $property): bool
    {
        //
    }
}
