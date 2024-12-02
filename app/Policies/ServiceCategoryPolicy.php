<?php

namespace App\Policies;

use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceCategoryPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role == 'admin';
    }

    public function update(User $user, ServiceCategory $serviceCategory)
    {
        return $user->role == 'admin';
    }

    public function delete(User $user, ServiceCategory $serviceCategory)
    {
        return $user->role == 'admin';
    }
}
