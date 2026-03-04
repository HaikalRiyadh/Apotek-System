<?php

namespace App\Policies;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicinePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view medicines');
    }

    public function view(User $user, Medicine $medicine): bool
    {
        return $user->hasPermissionTo('view medicines');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create medicines');
    }

    public function update(User $user, Medicine $medicine): bool
    {
        return $user->hasPermissionTo('edit medicines');
    }

    public function delete(User $user, Medicine $medicine): bool
    {
        return $user->hasPermissionTo('delete medicines');
    }
}
