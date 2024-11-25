<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['customer_name', 'status']);

        $storeId = Auth()->user()->store_id;

        $bookings = $this->bookingService->getBookingByStore($filters, $storeId);

        return view('cashier.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $bookingDetail = $booking->details()->with(['service' => function ($query) {
            $query->withTrashed();
        }])->get();

        $booking->load(['user' => function ($query) {
            $query->withTrashed();
        }]);

        return view('cashier.bookings.show', compact('booking', 'bookingDetail'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $result = $this->bookingService->updateBookingStatus($request, $booking);
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('cashier.bookings.index')->with('success', $result['success']);
    }
}
