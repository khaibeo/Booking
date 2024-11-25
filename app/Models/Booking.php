<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'store_id', 'name', 'phone', 'booking_date', 'booking_time', 'end_time', 'note', 'total_amount', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_details')
            ->withPivot('price');
    }
}
