<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'date', 'opening_time', 'closing_time'];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
