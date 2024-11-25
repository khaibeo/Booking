<?php

namespace App\Services;

use App\Models\StaffSchedule;

class StaffScheduleService
{
    public function getStaffSchedules()
    {
        return StaffSchedule::query()->where('user_id', auth()->user()->id)
            ->orderBy('date', 'desc')
            ->get();
    }

    public function createSchedule($data)
    {
        return StaffSchedule::create($data);
    }
}
