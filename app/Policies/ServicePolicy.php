<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
    public function create(User $user)
    {
        return $user->role == 'admin';
    }

    public function update(User $user, Service $service)
    {
        return $user->role == 'admin';
    }

    public function delete(User $user, Service $service)
    {
        return $user->role == 'admin';
    }
}
