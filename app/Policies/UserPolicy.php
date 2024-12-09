<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function view(User $user, User $model): bool
    {
        if($user->role == 'admin'){
            return true;
        }

        return $user->store_id == $model->store_id;
    }

    public function create(User $user): bool
    {
        return $user->role == 'admin' || $user->role == 'manager';
    }

    public function update(User $user, User $model): bool
    {
        if($user->role == 'admin'){
            return true;
        }

        return $user->store_id == $model->store_id;
    }

    public function delete(User $user, User $model): bool
    {
        if($user->role == 'admin'){
            return true;
        }

        return $user->store_id == $model->store_id;
    }

    public function viewProfile(User $user, User $model): bool
    {
        return $user->id == $model->id;
    }
}
