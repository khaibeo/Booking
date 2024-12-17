<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';

    protected $fillable = ['name', 'code', 'address', 'link_map', 'phone', 'description'];

    public function users()
    {
        return $this->hasMany(User::class, 'store_id');
    }

    public function storeSchedule()
    {
        return $this->hasMany(StoreSchedule::class, 'store_id', 'id');
    }

    public function staffs()
    {
        return $this->hasMany(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
