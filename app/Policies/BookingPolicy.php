<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    public function show(User $user, Booking $booking)
    {
        if($user->role == 'admin'){
            return true;
        }

        if($user->role == 'staff'){
            return $user->id == $booking->user_id;
        }

        return $user->store_id == $booking->store_id;
    }

    public function update(User $user, Booking $booking)
    {
        if($user->role == 'admin'){
            return true;
        }

        return $user->store_id == $booking->store_id;
    }

    public function delete(User $user, Booking $booking)
    {
        if($user->role == 'admin'){
            return true;
        }

        return $user->store_id == $booking->store_id;
    }
}
