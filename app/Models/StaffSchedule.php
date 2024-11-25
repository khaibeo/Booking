<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    use HasFactory;

    protected $table = 'staff_schedules';

    protected $fillable = ['user_id', 'date', 'start_time', 'end_time'];

    protected $casts = [
        'date' => 'date',
    ];
}
