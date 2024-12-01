<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Auth\Access\Response;

class SettingPolicy
{
    public function viewSetting(User $user): bool
    {
        return $user->role == 'admin';
    }

    public function updateSetting(User $user): bool
    {
        return $user->role == 'admin';
    }
}
