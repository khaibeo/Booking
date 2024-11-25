<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\BookingService;

class DashboardController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $today = now()->startOfDay();
        $staffId = Auth()->user()->id;

        $bookings = $this->bookingService->getStaffBookingToday($today, $staffId);

        return view('admin.bookings.staff-dashboard', compact('bookings'));
    }
}
