<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    public function viewAllStore(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function store(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function edit(User $user, Store $store)
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $user->store_id === $store->id;
    }

    public function update(User $user, Store $store): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $user->store_id === $store->id;
    }

    public function delete(User $user, Store $store): bool
    {
        return $this->isAdmin($user);
    }

    public function viewStaff(User $user, Store $store): bool
    {
        if ($this->isAdmin($user)) {
            return true;
        }

        return $user->store_id === $store->id;
    }

    private function isManager(User $user): bool
    {
        return $user->role === 'manager';
    }

    private function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }
}
