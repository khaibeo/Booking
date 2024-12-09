<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'name',
        'email',
        'phone',
        'role',
        'password',
        'biography',
        'is_locked',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class);
    }

    public function getAvailableTimeSlots($date)
    {
        // Get working hours for the given date
        $dayOfWeek = date('w', strtotime($date));
        $workingHours = $this->working_hours[$dayOfWeek] ?? null;

        if (! $workingHours || in_array($date, $this->days_off)) {
            return [];
        }

        // Get all bookings for this date
        $existingBookings = $this->bookings()
            ->whereDate('booking_time', $date)
            ->with('services')
            ->get();

        // Generate available time slots
        return $this->generateTimeSlots($workingHours, $existingBookings, $date);
    }

    private function generateTimeSlots($workingHours, $existingBookings, $date)
    {
        $slots = [];
        $start = strtotime($workingHours['start']);
        $end = strtotime($workingHours['end']);

        // Generate slots every 30 minutes
        for ($time = $start; $time < $end; $time += 1800) {
            $slotStart = date('Y-m-d H:i:s', $time);
            $isAvailable = true;

            // Check if slot conflicts with any existing booking
            foreach ($existingBookings as $booking) {
                $bookingStart = strtotime($booking->booking_time);
                $bookingEnd = $bookingStart + ($booking->services->sum('duration') * 60);

                if ($time >= $bookingStart && $time < $bookingEnd) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $slots[] = [
                    'time' => $slotStart,
                    'available' => true,
                ];
            }
        }

        return $slots;
    }
}
